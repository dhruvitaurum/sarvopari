<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function create_permission(Request $request){
        $id = $request->input('id');
        return view('permission.create',compact('id'));
    }
    public function insert_permission(Request $request)
    {
        // echo "<pre>";print_r($request->input('permissions'));exit;
        $request->validate([
            'role_id' => 'required|integer',
            'menu_id' => 'required|array',
            'add'     => 'nullable|array',
            'edit'    => 'nullable|array',
            'view'    => 'nullable|array',
            'delete'  => 'nullable|array',
        ]);

        // Loop through the submitted data and insert into the database
        $permissions = $request->input('permissions');
        if(!empty($permissions)){
            foreach ($permissions as $menuId => $permission) {
                Permission::updateOrCreate(
                    ['role_id' => $request->role_id, 'menu_id' => $menuId],
                    [
                        'add'    => isset($permission['add']) ? $permission['add'] : 0,
                        'edit'   => isset($permission['edit']) ? $permission['edit'] : 0,
                        'view'   => isset($permission['view']) ? $permission['view'] : 0,
                        'delete' => isset($permission['delete']) ? $permission['delete'] : 0,
                    ]
                );
            }
          
        }else{
            // foreach($request->input('menu_id') as $value){
            // Permission::updateOrCreate(
            //     ['role_id' => $request->role_id],
            //     [
            //         'add'    =>  0,
            //         'edit'   =>  0,
            //         'view'   =>  0,
            //         'delete' =>  0,
            //     ]
            // );
            $updatedData = array('add'    =>  0,
                                 'edit'   =>  0,
                                 'view'   =>  0,
                                 'delete' =>  0,);
            Permission::where('role_id', $request->role_id)->update($updatedData);

        
        }
        return redirect()->back()->with('success', 'Permissions added successfully');
    }
}

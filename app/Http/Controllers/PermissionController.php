<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use App\Models\permissions;

class PermissionController extends Controller
{
    public function edit($uid): View
    {
        $module_list=DB::table('module_menu')->leftJoin('permissions','module_menu.id','=','permissions.module_id')
        ->select('module_menu.*','permissions.add','permissions.edit','permissions.delete', 'permissions.view','permissions.user_id')->get();
        //$permissions_module = DB::table('permissions')->where('user_id',$uid)->get();
        return view('permissions.edit', [
            'user_id' => $uid,
            'module'=>$module_list,
        ]);
    }

    public function update(Request $request,$id)
    {
        
            // echo "<pre>";print_r($request->all());exit;
            // Retrieve user permissions
            $user_permission = Permissions::where('user_id', $request->user_id)->get();
    
            if ($user_permission->isNotEmpty()) {
                DB::table('permissions')->where('user_id', $id)->delete();
            } 
                // Create new permissions
                // echo "<pre>";print_r($request->all());exit;
                foreach ($request->input('module_id') as $key => $module_id) {
                    $data = [
                        'module_id' => $module_id,
                        'user_id' => $id,
                        'add' => $request->input('add')[$key]?? 0,
                        'edit' => $request->input('edit')[$key] ?? 0,
                        'delete' => $request->input('delete')[$key] ?? 0,
                        'view' => $request->input('view')[$key]?? 0,
                    ];
        
                    permissions::create($data);
                }
                 
                
                
                
               
            }
    
            // Redirect with success message
            // return Redirect::route('permissions.edit')->with('status', 'profile-updated');
        
    

}

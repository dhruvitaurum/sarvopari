<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function create_role(){
       return view('role.create');
    }
    public function save_role(Request $request){
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'role_name'), 
            ],
        ]);

        Roles::create([
            'role_name' => $request->input('role_name'),
        ]);

        return redirect()->route('roles.create')->with('success', 'Role created successfully');
   
    }
    public function list_role(){
        return view('role.list');
    }
}

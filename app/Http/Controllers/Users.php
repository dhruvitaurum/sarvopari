<?php

namespace App\Http\Controllers;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Users extends Controller
{
    public function list_admin(): View {
        $users = User::where('role_type',[2,3])->paginate(10); 
        return view('admin.list', compact('users'));
    }

    public function subadmin_create(Request $request){
        return view('admin.create');
    }

    public function subadmin_store(Request $request){
        // print_r($request->all());exit;
        $validator=$request->validate([
            'role_type'=>'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        
        // Create sub-admin
        
        $subAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_type' =>$request->role_type,
        ]);

        return Redirect::route('admin.create')->with('success', 'profile-created');
        // return redirect()->route('roles.create')->with('success', 'Role created successfully');
    }
}

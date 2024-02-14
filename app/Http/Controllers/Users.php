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
    public function sub_admin_list($id): View {
        $users = DB::table('users')->where('role_type',$id)->get();
        return view('sub_admin.sub_admin_list',[
            'userdetail'=> $users,
        ]);
    }

    public function subadmin_create(Request $request){
        return view('sub_admin.add-sub_admin');
    }

    public function subadmin_store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create sub-admin
        $subAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_type' => 2,
        ]);

        return Redirect::route('sub_admin_list/{2}')->with('status', 'profile-created');
    }
}

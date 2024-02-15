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
        $users = DB::table('users')->where('role_type','1')->get();
        return view('sub_admin.sub_admin_list',[
            'userdetail'=> $users,
        ]);
    }

    public function subadmin_create(Request $request){
        return view('admin.create');
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

        return Redirect::route('list_admin')->with('status', 'profile-created');
    }
}

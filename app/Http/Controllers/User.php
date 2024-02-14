<?php

namespace App\Http\Controllers;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


use Illuminate\Http\Request;

class User extends Controller
{
    public function sub_admin_list($id): View {
        $users = DB::table('users')->where('role_type',$id)->get();
        return view('sub_admin_list',[
            'userdetail'=> $users,
        ]);
    }
}

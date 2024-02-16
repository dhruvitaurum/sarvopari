<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class institute extends Controller
{
    public function list_admin(): View {
        $users = User::where('role_type',[2,3])->paginate(10); 
        return view('admin.list', compact('users'));
    }
}

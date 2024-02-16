<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function list_admin(): View {
        $users = User::where('role_type',[2,3])->paginate(10); 
        return view('admin.list', compact('users'));
    }
    public function create_institute(){
        return view('institute/create_institute');
    }
}

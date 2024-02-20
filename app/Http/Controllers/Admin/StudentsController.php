<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function list_student(): View {
        $student = User::where('role_type',[4])->paginate(10); 
        return view('student.list', compact('student'));
    }

    public function create_student(){
        return view('student.create');
    }
}

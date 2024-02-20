<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\board;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\institute_for;
use App\Models\medium;
use App\Models\class_model;
use App\Models\stream;
use App\Models\subject;
use App\Models\institute_for_sub;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function list_student(): View {
        $student = User::where('role_type',[4])->paginate(10); 
        return view('student.list', compact('student'));
    }

    public function create_student(){
        $id = Auth::id();
        $formdropdowns['institute_for'] = institute_for::join('institute_for_sub', 'institute_for.id', '=', 'institute_for_sub.institute_for_id')->where('institute_for_sub.institute_id',$id)->get(); 
        $formdropdowns['board'] = board::join('board_sub', 'board.id', '=', 'board_sub.board_id')->where('board_sub.institute_id',$id)->get();
        $formdropdowns['medium'] = medium::join('medium_sub', 'medium.id', '=', 'medium_sub.medium_id')->where('medium_sub.institute_id',$id)->get();
        $formdropdowns['class'] = class_model::join('class_sub', 'class.id', '=', 'class_sub.class_id')->where('class_sub.institute_id',$id)->get();
        $formdropdowns['stream'] = stream::join('stream_sub', 'stream.id', '=', 'stream_sub.stream_id')->where('stream_sub.institute_id',$id)->get();
        $formdropdowns['subject'] = subject::join('subject_sub', 'subject.id', '=', 'subject_sub.subject_id')->where('subject_sub.institute_id',$id)->get(); 
        return view('student.create',compact('formdropdowns'));
    }

    public function save_student(Request $request){

        $student = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile'=>  $request->mobile,
        'address'=>$requst->address;
        'dob'=>$requst->dob;
        'password' => Hash::make($request->password),
        'role_type' =>4,
        ]);
        $student_id = $student->id;
        $student = student_detail::create([
            'student_id' => $student_id,
            'stage' => $request->stage,
            'board'=>  $request->board,
            'medium' =>$request->medium,
            'class' =>$request->class,
            'stream'=>$request->stream,
            'subject'=>$request->subject,
            ]);

        return Redirect::route('student.list')->with('success', 'profile-created');
    }
}

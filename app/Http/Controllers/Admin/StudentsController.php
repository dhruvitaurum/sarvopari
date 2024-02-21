<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\board;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Institute_for_model;
use App\Models\Medium_model;
use App\Models\class_model;
use App\Models\Stream_model;
use App\Models\subject;
use App\Models\institute_for_sub;
use App\Models\Institute_detail;
use App\Models\Subject_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function list_student(): View {
        $student = User::where('role_type',[4])->paginate(10); 
        $id = Auth::id();
        $institute_for = Institute_for_model::join('institute_for_sub', 'institute_for.id', '=', 'institute_for_sub.institute_for_id')->where('institute_for_sub.institute_id',$id)->get(); 
        $board = board::join('board_sub', 'board.id', '=', 'board_sub.board_id')->where('board_sub.institute_id',$id)->get();
        $medium = Medium_model::join('medium_sub', 'medium.id', '=', 'medium_sub.medium_id')->where('medium_sub.institute_id',$id)->get();
        $class = class_model::join('class_sub', 'class.id', '=', 'class_sub.class_id')->where('class_sub.institute_id',$id)->get();
        $stream = Stream_model::join('stream_sub', 'stream.id', '=', 'stream_sub.stream_id')->where('stream_sub.institute_id',$id)->get();
        $subject = Subject_model::join('subject_sub', 'subject.id', '=', 'subject_sub.subject_id')->where('subject_sub.institute_id',$id)->get(); 
        return view('student.list', compact('student','institute_for','board','medium','class','stream','subject'));
    }

    public function create_student(){
        $id = Auth::id();
        $institute = Institute_detail::where('user_id',[$id])->get();
        $institute_for = Institute_for_model::join('institute_for_sub', 'institute_for.id', '=', 'institute_for_sub.institute_for_id')->where('institute_for_sub.institute_id',$id)->select('institute_for.*')->get(); 
        $board = board::join('board_sub', 'board.id', '=', 'board_sub.board_id')->where('board_sub.institute_id',$id)->get();
        $medium = Medium_model::join('medium_sub', 'medium.id', '=', 'medium_sub.medium_id')->where('medium_sub.institute_id',$id)->get();
        $class = class_model::join('class_sub', 'class.id', '=', 'class_sub.class_id')->where('class_sub.institute_id',$id)->get();
        $stream = Stream_model::join('stream_sub', 'stream.id', '=', 'stream_sub.stream_id')->where('stream_sub.institute_id',$id)->get();
        $subject = Subject_model::join('subject_sub', 'subject.id', '=', 'subject_sub.subject_id')->where('subject_sub.institute_id',$id)->get(); 
        $standard = Standard_model::join('standard_sub', 'standard.id', '=', 'standard_sub.standard_id')->where('standard_sub.institute_id',$id)->get(); 
        return view('student.create',compact('institute','institute_for','board','medium','class','stream','subject','standard'));
    }

    public function save_student(Request $request){

        $validator = $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            'mobile'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            
            ],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('public/profile'), $imageName);
        }

        $student = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile'=>  $request->mobile,
        'address'=> $request->address,
        'dob'=> $request->dob,
        'image'=>'public/profile/'.$imageName,
        //'password' => Hash::make($request->password),
        'role_type' =>4,
        'status'=>$request->status,
        ]);

        $student_id = $student->id;
        $studentdetail = student_detail::create([
            'student_id' => $student_id,
            'institute_for_id' => $request->institute_for_id,
            'board_id'=>  $request->board_id,
            'medium_id' =>$request->medium_id,
            'class_id' =>$request->class_id,
            'stream_id'=>$request->stream_id,
            'subject_id'=>$request->subject_id,
            ]);

        return Redirect::route('student.list')->with('success', 'profile-created');
    }

    public function edit_student(Request $request){
        $student_id = $request->input('student_id');
        $studentDT = User::find($student_id);
        
    
    if($studentDT) {
        $institute_id = Auth::id();
        
        $studentdetailsDT = students_details::where('student_id', $student_id) ->where('institute_id', $institute_id)->first();
        return response()->json(['studentDT' => $studentDT, 'studentsdetailsDT' => $studentdetailsDT]);
    } else {
        return response()->json(['error' => 'Student not found'], 404);
    }
    }

    public function update_student(Request $request){
        $student_id = $request->student_id;
        $studentUP = User::find($student_id);

        $validator = $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('users', 'email')->ignore($studentUP),
            ],
        ]);
      
        //image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('public/profile'), $imageName);
        }

        //update
        
        $studentUP->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'address'=>$request->input('address'),
            'dob'=> $request->input('dob'),
            'image'=>'public/profile/'.$imageName,
        ]);

        $institute_id = Auth::id();
        $studentdetailsDT = students_details::where('student_id', $student_id) 
        ->where('institute_id', $institute_id)->first();
        $studentdetailsDT->update([
            'board_id'=>  $request->board_id,
            'medium_id' =>$request->medium_id,
            'class_id' =>$request->class_id,
            'stream_id'=>$request->stream_id,
            'subject_id'=>$request->subject_id,
        ]);
    }

    public function delete_student(){
        $did=$request->input('student_id');
        $student = User::find($did);
        if(Auth::role_type() == 1 && $student){
            students_details::where('student_id', $student_id)->delete();
            $student->delete();
        }elseif(Auth::role_type() == 3 && $student){
            $institute_id = Auth::id();
            students_details::where('student_id', $student_id)->where('institute_id', $institute_id)->delete();
            
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }
}

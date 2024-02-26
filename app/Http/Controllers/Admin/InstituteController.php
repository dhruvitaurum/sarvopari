<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\board;
use App\Models\Class_model;
use App\Models\Institute_detail;
use App\Models\Institute_for_model;
use App\Models\Medium_model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstituteController extends Controller
{
    public function list_admin() {
        $users = User::where('role_type',[2,3])->paginate(10); 
        return view('admin.list', compact('users'));
    }
    public function list_institute(){
        $institute_list = Institute_detail::paginate(10); 
        return view('institute/list_institute',compact('institute_list'));

    }
    public function create_institute(){
        $institute_for=Institute_for_model::get()->toArray();
        $board_list = board::get()->toArray();
        $medium_list = Medium_model::get()->toArray();

        $class_list = Class_model::get()->toArray();
        return view('institute/create_institute',compact('institute_for','board_list','medium_list','class_list'));
    }
    public function create_institute_for(){
        return view('institute/create_institute_for');
    
    }
    public function list_institute_for(){
        $institute_for = Institute_for_model::paginate(10); 
        return view('institute/list_institute_for',compact('institute_for'));

    }
    public function institute_for_save(Request $request){
        // dd($request->all());exit;
        $request->validate([
                'icon' =>'required|image|mimes:svg|max:2048',
                'name'=>['required','string','max:255',Rule::unique('institute_for', 'name')],
                'status'=>'required',
        ]);
        $iconFile = $request->file('icon');
        $imagePath = $iconFile->store('icon', 'public');


        Institute_for_model::create([
            'name'=>$request->input('name'),
            'icon'=>$imagePath,
            'status'=>$request->input('status'),
        ]);
      return redirect()->route('institute_for.create')->with('success', 'Institute For Created Successfully');
   
    }
    public function institute_for_edit(Request $request){
        $id = $request->input('institute_id');
        $Institute_for_model = Institute_for_model::find($id);
        return response()->json(['Institute_for_model'=>$Institute_for_model]);
    }
    public function institute_for_update(Request $request){
        $id=$request->input('institute_id');
        $role = Institute_for_model::find($id);
        $request->validate([
            'icon' =>'required|image|mimes:svg|max:2048',
            'name'=>['required','string','max:255',Rule::unique('institute_for', 'name')->ignore($id)],
            'status'=>'required',
       ]);
      
        $iconFile = $request->file('icon');
        if(!empty($iconFile)){
            $imagePath = $iconFile->store('icon', 'public');
        }else{
            $imagePath=$request->input('old_icon');
        }
        $role->update([
            'name'=>$request->input('name'),
            'icon'=>$imagePath,
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('institute_for.list')->with('success', 'Institute For Updated successfully');
    }
    public function institute_for_delete(Request $request){
        $institute_id=$request->input('institute_id');
        $institute_for = Institute_for_model::find($institute_id);

        if (!$institute_for) {
            return redirect()->route('institute_for.list')->with('error', 'Institute for not found');
        }

        $institute_for->delete();

        return redirect()->route('institute_for.list')->with('success', 'Institute for deleted successfully');
  }
  function institute_register(Request $request){
    echo "<pre>";print_r($request->All());exit;
  }
}
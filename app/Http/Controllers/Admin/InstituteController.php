<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institute_for_model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstituteController extends Controller
{
    public function list_admin() {
        $users = User::where('role_type',[2,3])->paginate(10); 
        return view('admin.list', compact('users'));
    }
    public function create_institute(){
        return view('institute/create_institute');
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
                'name'=>['required','string','max:255',Rule::unique('institute_for', 'name')],
                'status'=>'required',
        ]);

        Institute_for_model::create([
            'name'=>$request->input('name'),
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
            'name'=>['required','string','max:255',Rule::unique('institute_for', 'name')->ignore($id)],
            'status'=>'required',
       ]);
      
        $role->update([
            'name'=>$request->input('name'),
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
}
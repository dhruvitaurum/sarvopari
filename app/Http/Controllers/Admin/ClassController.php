<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\board;
use App\Models\Class_model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    function list_class(){
        $classlist = Class_model::paginate(10);
        $boardlist = board::get()->toArray(); 
        return view('class.list', compact('classlist','boardlist'));
    }
    function create_class(){
        $boardlist = board::get()->toArray(); 
        return view('class.create',compact('boardlist'));
    }
    function class_list_save(Request $request){
        $request->validate([
            'board_id' => 'required',
            'name' => ['required', 'string', 'max:255', Rule::unique('class', 'name')],
            'status' => 'required',
    ]);

    Class_model::create([
        'board_id'=>$request->input('board_id'),
        'name'=>$request->input('name'),
        'status'=>$request->input('status'),
    ]);

    return redirect()->route('class.create')->with('success', 'Class Created Successfully');

    }
    function class_list_edit(Request $request){
        $id = $request->input('class_id');
        $board_list = board::get()->toArray();
        $class_list = Class_model::find($id);
        return response()->json(['board_list'=>$board_list,'class_list'=>$class_list]);
        
    }
    function class_update(Request $request){
        $id=$request->input('class_id');
        $class = Class_model::find($id);
        $request->validate([
            'board_id'=>'required',
            'name'=>['required','string','max:255',Rule::unique('board', 'name')->ignore($id)],
            'status'=>'required',
       ]);
      
        $class->update([
            'board_id'=>$request->input('board_id'),
            'name'=>$request->input('name'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('class.list')->with('success', 'Class Updated successfully');
    

    }
    function class_delete(Request $request){
        $class_id=$request->input('class_id');
        // dd($request->all());exit;
        $class_list = Class_model::find($class_id);

        if (!$class_list) {
            return redirect()->route('class.list')->with('error', 'Class not found');
        }

        $class_list->delete();

        return redirect()->route('class.list')->with('success', 'Class deleted successfully');
  
    }
}

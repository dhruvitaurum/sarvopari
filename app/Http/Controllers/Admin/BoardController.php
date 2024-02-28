<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\board;
use App\Models\Institute_for_model;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function list_board() {
        $board_list = DB::table('board')
        ->join('institute_for', 'board.institute_for_id', '=', 'institute_for.id')
        ->select('board.*', 'institute_for.name as institute_name')
        ->whereNull('board.deleted_at')
        ->paginate(10);
        $institute_list = Institute_for_model::get()->toArray();
        // return view('board.list', compact('boardlist','institute_list'));
        // $board_list = board::paginate(10);
        // echo "<pre>";print_r($board_list);
        return view('board.list', compact('board_list','institute_list'));
    }
    public function create_board(){
        $institute_list = Institute_for_model::get()->toArray();
        return view('board/create',compact('institute_list'));
    }
    public function board_list_save(Request $request){
        $request->validate([
            'institute_for_id' => 'required',
            'icon' => 'required|image|mimes:svg|max:2048',
            'name' => ['required', 'string', 'max:255', Rule::unique('board', 'name')],
            'status' => 'required',
    ]);
    $iconFile = $request->file('icon');
    $imagePath = $iconFile->store('icon', 'public');

    board::create([
        'institute_for_id'=>$request->input('institute_for_id'),
        'name'=>$request->input('name'),
        'icon'=>$imagePath,
        'status'=>$request->input('status'),
    ]);

    return redirect()->route('board.create')->with('success', 'Institute For Created Successfully');

    }
    public function board_list_edit(Request $request){
        $id = $request->input('board_id');
        $institute_list = Institute_for_model::get()->toArray();
        $board_list = board::find($id);
        return response()->json(['board_list'=>$board_list,'institute_list'=>$institute_list]);
        
    }
    public function board_update(Request $request){
        // dd($request->all());exit;
        $id=$request->input('board_id');
        $role = board::find($id);
        $request->validate([
            'institute_for_id' => 'required',
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
            'institute_for_id'=>$request->input('institute_for_id'),
            'name'=>$request->input('name'),
            'icon'=>$imagePath,

            'status'=>$request->input('status'),
        ]);
        return redirect()->route('board.list')->with('success', 'Board Updated successfully');
    

    }
    public function board_delete(Request $request){
        $board_id=$request->input('board_id');
        $board_list = board::find($board_id);

        if (!$board_list) {
            return redirect()->route('board.list')->with('error', 'Board not found');
        }

        $board_list->delete();

        return redirect()->route('board.list')->with('success', 'Board deleted successfully');
  
      
    }
}

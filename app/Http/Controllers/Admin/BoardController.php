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
        $boardlist = DB::table('board')
        ->join('institute_for', 'board.institute_id', '=', 'institute_for.id')
        ->select('board.*', 'institute_for.name as institute_name')
        ->whereNull('board.deleted_at')
        ->paginate(10);; 
        $institute_list = Institute_for_model::get()->toArray();
        return view('board.list', compact('boardlist','institute_list'));
    }
    public function create_board(){
        $institute_list = Institute_for_model::get()->toArray();
        return view('board/create',compact('institute_list'));
    }
    public function board_list_save(Request $request){
        $request->validate([
            'institute_id' => 'required',
            'name' => ['required', 'string', 'max:255', Rule::unique('board', 'name')],
            'status' => 'required',
    ]);

    board::create([
        'institute_id'=>$request->input('institute_id'),
        'name'=>$request->input('name'),
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
        $id=$request->input('board_id');
        $role = board::find($id);
        $request->validate([
            'institute_id'=>'required',
            'name'=>['required','string','max:255',Rule::unique('institute_for', 'name')->ignore($id)],
            'status'=>'required',
       ]);
      
        $role->update([
            'institute_id'=>$request->input('institute_id'),
            'name'=>$request->input('name'),
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

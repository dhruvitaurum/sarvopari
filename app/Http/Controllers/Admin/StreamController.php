<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Standard;
use App\Models\Standard_model;
use App\Models\Stream_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StreamController extends Controller
{
    function list_stream(){
        $straemlist =DB::table('stream')
        ->join('standard', 'stream.standard_id', '=', 'standard.id')
        ->select('stream.*', 'standard.name as standard_name')
        ->whereNull('stream.deleted_at')
        ->paginate(10);
        $standardlist = Standard_model::get()->toArray(); 
        return view('stream.list',compact('straemlist','standardlist'));
    }
    public function create_stream(){
        $standard_list = Standard_model::get()->toArray();
        return view('stream.create',compact('standard_list'));
    }
    public function stream_list_save(Request $request){
        $request->validate([
            'standard_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'status' => 'required',
    ]);

    Stream_model::create([
        'standard_id'=>$request->input('standard_id'),
        'name'=>$request->input('name'),
        'status'=>$request->input('status'),
    ]);

       return redirect()->route('stream.create')->with('success', 'Stream Created Successfully');

    }
    public function stream_list_edit(Request $request){
        $id = $request->input('stream_id');
        $standlist = Standard_model::get()->toArray();
        $straemlist = Stream_model::find($id);
        return response()->json(['standlist'=>$standlist,'straemlist'=>$straemlist]);
    }
    public function stream_update(Request $request){
        $id=$request->input('stream_id');
        $class = Stream_model::find($id);
        $request->validate([
            'standard_id'=>'required',
            'name'=>['required','string','max:255'],
            'status'=>'required',
       ]);
      
        $class->update([
            'standard_id'=>$request->input('standard_id'),
            'name'=>$request->input('name'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('stream.list')->with('success', 'Stream Updated successfully');
    
    }
    function stream_delete(Request $request){
        $stream_id=$request->input('stream_id');
        // dd($request->all());exit;
        $streamlist = Stream_model::find($stream_id);

        if (!$streamlist) {
            return redirect()->route('stream.list')->with('error', 'Class not found');
        }

        $streamlist->delete();

        return redirect()->route('stream.list')->with('success', 'Class deleted successfully');
  
    }
}

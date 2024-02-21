<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Standard_model;
use App\Models\Stream_model;
use App\Models\Subject_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    function list_subject(){
        $subjectlist =DB::table('subject')
        ->join('standard', 'subject.standard_id', '=', 'standard.id')
        ->join('stream', 'subject.stream_id', '=', 'stream.id','left')
        ->select('subject.*', 'standard.name as standard_name','stream.name as stream_name')
        ->whereNull('subject.deleted_at')
        ->paginate(10);
        $standardlist = Standard_model::get()->toArray();
        $streamlist = Stream_model::get()->toArray();

        return view('subject.list',compact('streamlist','standardlist','subjectlist'));
    }
    function create_subject(){
        $standardlist = Standard_model::get()->toArray();
        $streamlist = Stream_model::get()->toArray();
        return view('subject.create',compact('streamlist','standardlist'));
    }
    function standard_wise_stream(Request $request){
        $id = $request->input('standard_id');
        $streamlist = Stream_model::where('standard_id',$id)->get()->toArray();
        return response()->json(['streamlist'=>$streamlist]);
    }
    function subject_list_save(Request $request){
        $request->validate([
            'standard_id' => 'required',
            'name' => ['required', 'string', 'max:255', Rule::unique('subject', 'name')],
            'status' => 'required',
    ]);

    Subject_model::create([
        'standard_id'=>$request->input('standard_id'),
        'stream_id'=>$request->input('stream_id'),
        'name'=>$request->input('name'),
        'status'=>$request->input('status'),
    ]);

    return redirect()->route('subject.create')->with('success', 'Subject Created Successfully');
    }
    function subject_edit(Request $request){
        $id = $request->input('subject_id');
        $standardlist = Standard_model::get()->toArray();
        $streamlist = Stream_model::get()->toArray();
        $subjectlist = Subject_model::find($id);
        return response()->json(['standardlist'=>$standardlist,'streamlist'=>$streamlist,
                                 'subjectlist'=>$subjectlist]);
    }
    function subject_update(Request $request){
        $id=$request->input('subject_id');
        $class = Subject_model::find($id);
        $request->validate([
            'standard_id'=>'required',
            'stream_id'=> 'required',
            'name'=>['required','string','max:255',Rule::unique('subject', 'name')->ignore($id)],
            'status'=>'required',
       ]);
      
        $class->update([
            'standard_id'=>$request->input('standard_id'),
            'stream_id'=>$request->input('stream_id'),
            'name'=>$request->input('name'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('subject.list')->with('success', 'Subject Updated successfully');
    
    }
    public function subject_delete(Request $request){
        $subject_id=$request->input('subject_id');
        $subjectlist = Subject_model::find($subject_id);

        if (!$subjectlist) {
            return redirect()->route('subject.list')->with('error', 'Subject not found');
        }

        $subjectlist->delete();

        return redirect()->route('subject.list')->with('success', 'Subject deleted successfully');
  
    }
}

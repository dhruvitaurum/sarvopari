<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Base_table;
use App\Models\board;
use App\Models\Class_model;
use App\Models\Institute_detail;
use App\Models\Institute_for_model;
use App\Models\Medium_model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $institute_for_array = DB::table('base_table')
        // ->leftJoin('institute_for', 'institute_for.id', '=', 'base_table.institute_for')
        // ->select('institute_for.name as institute_for_name', 'base_table.*', 'institute_for.id as institute_for_id', DB::raw('MAX(base_table.id) as max_id'))
        // ->groupBy('institute_for.name', 'base_table.institute_for')
        // ->whereNull('base_table.deleted_at')
        // ->get();
        
        $institute_for_array = Base_table::
            join('institute_for', 'institute_for.id', '=', 'base_table.institute_for')
            ->select('institute_for.name as institute_for_name', 'base_table.institute_for', DB::raw('(base_table.id) as max_id'))
            ->groupBy('institute_for.name', 'base_table.institute_for')
            ->whereNull('base_table.deleted_at')
            ->get();
        // print_r($institute_for_array);exit;

        // echo "<pre>";print_r($institute_for_array);exit;
              

        $institute_for = [];
        foreach ($institute_for_array as $institute_for_array_value) {
             $board_array = DB::table('base_table')
                ->leftJoin('board', 'board.id', '=', 'base_table.board')
                ->select('board.name as board_name','base_table.id')
                ->whereNull('base_table.deleted_at')
                ->where('base_table.id',$institute_for_array_value->max_id)
                ->get();
                        $board = [];
                        foreach ($board_array as $board_array_value) {
                            $medium_array = DB::table('base_table')
                            ->leftJoin('medium', 'medium.id', '=', 'base_table.medium')
                            ->select('medium.name as medium_name','base_table.id')
                            ->whereNull('base_table.deleted_at')
                            ->where('base_table.id',$board_array_value->id)
                            ->get();
                            $medium = [];
                            foreach ($medium_array as $medium_array_value) {
                                $class_array = DB::table('base_table')
                                ->leftJoin('class', 'class.id', '=', 'base_table.institute_for_class')
                                ->select('class.name as class_name','base_table.id')
                                ->whereNull('base_table.deleted_at')
                                ->where('base_table.id',$medium_array_value->id)
                                ->get();
                                $class = [];
                                foreach ($class_array as $class_array_value) {
                                    $standard_array = DB::table('base_table')
                                    ->leftJoin('standard', 'standard.id', '=', 'base_table.standard')
                                    ->select('standard.name as standard_name','base_table.id')
                                    ->whereNull('base_table.deleted_at')
                                    ->where('base_table.id',$class_array_value->id)
                                    ->get();

                                    $standard = [];
                                    foreach ($standard_array as $standard_array_value) {

                                        $stream_array = DB::table('base_table')
                                        ->leftJoin('stream', 'stream.id', '=', 'base_table.stream')
                                        ->select('stream.name as stream_name','base_table.id')
                                        ->whereNull('base_table.deleted_at')
                                        ->where('base_table.id',$standard_array_value->id)
                                        ->get();
                                        $stream = [];
    
                                        foreach ($stream_array as $stream_array_value) {

                                            $subject_array = DB::table('base_table')
                                                ->leftJoin('subject', 'subject.base_table_id', '=', 'base_table.id')
                                                ->select('subject.name as subject_name')
                                                ->whereNull('base_table.deleted_at')
                                                ->where('base_table.id',$standard_array_value->id)
                                                ->get();
                                                $subject = [];
                                                foreach ($subject_array as $value) {
                                                    $subject[] = [
                                                        'subject' => $value->subject_name
                                                    ];
                                                }
                                            $stream[] = [
                                                'stream' => $stream_array_value->stream_name.'',
                                                // 'subject' => $subject_array
                                            ];
                                        }
                                    

                                        $standard[] = [
                                            'standard' => $standard_array_value->standard_name,
                                            'stream' => $stream,
                                            'subject' => $subject
                                        ];
                                    }

                                    $class[] = [
                                        'class' => $class_array_value->class_name,
                                        'standard' => $standard,
                                    ];
                                }
                                
                                $medium[] = [
                                    'medium' => $medium_array_value->medium_name,
                                    'class' => $class,
                                ];
                            }

                            $board[] = [
                                'board' => $board_array_value->board_name,
                                'medium' => $medium,
                            ];
                        }
    
           
            $institute_for[] = [
                'institute_for_value' => $institute_for_array_value->institute_for_name,
                'board_detail' => $board,
            ];
        }
        echo "<pre>";print_r($institute_for);exit;
        return view('institute/create_institute',compact('institute_for'));
    }
    public function create_institute_for(){
        $institute_for = Institute_for_model::paginate(10); 
        return view('institute/create_institute_for',compact('institute_for'));
    
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
      return redirect()->route('institute_for.list')->with('success', 'Institute For Created Successfully');
   
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
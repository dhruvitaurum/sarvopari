<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Subject_model;
use App\Models\Standard_model;
use PHPOpenSourceSaver\JWTAuth\Claims\Subject;

class ChapterController extends Controller
{
    public function add_lists()
    {
        $Standard = Standard_model::
        join('base_table','standard.id','=','base_table.standard')
        ->leftjoin('stream','stream.id','=','base_table.stream')
        ->leftjoin('medium','medium.id','=','base_table.medium')
        ->leftjoin('board','board.id','=','base_table.board')
        ->select('stream.name as sname','standard.*','medium.name as medium',
        'board.name as board','base_table.id as base_id')
        ->where('standard.status','active')->get();
        return view('chapter.list',compact('Standard'));
    }

    //strandard wise data
    public function get_subjects(Request $request){
        $bas_id = $request->standard_id;
        $subject = Subject_model::where('base_table_id',$bas_id)->get();
        return response()->json(['subject'=>$subject]);
    }

}

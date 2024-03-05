<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    public function add_lists()
    {
        $subject_list = Chapter::where('standard')->get();
        return view('chapter.list',compact('subject_list'));
    }

}

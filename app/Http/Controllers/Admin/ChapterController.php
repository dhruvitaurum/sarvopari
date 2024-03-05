<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Standard_model;

class ChapterController extends Controller
{
    public function add_lists()
    {
        $Standard = Standard_model::where('status','active')->paginate(10);
        return view('chapter.list',compact('Standard'));
    }

}

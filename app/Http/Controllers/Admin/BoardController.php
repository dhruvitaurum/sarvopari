<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\board;
use Illuminate\View\View;

class BoardController extends Controller
{
    public function list_board(): View {
        $board = board::where('status',[1])->paginate(10); 
        return view('board.list', compact('board'));
    }
}

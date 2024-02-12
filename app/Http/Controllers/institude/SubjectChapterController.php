`<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\subject_chapter;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectChapterController extends Controller
{
    public function get_subject_chapter(Request $request)
    {
        $token = $request->header('Authorization');
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        } 
        
        
        $existingUser = User::where('token', $token)->first();
        if($existingUser){
            $subject_chapter =subject_chapter::where('subject_id', $request->input('subject_id'))->get();
            foreach ($subject_chapter as $value) {
                $data[] = array(
                    'chapter_no' => $value->chapter_no,
                    'chapter_name' => $value->chapter_name,

                  );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'subject_chapter_list' => $data,
               ], 200, [], JSON_NUMERIC_CHECK);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ],400);        
        }
    }
}
`
<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\Subject_detail;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectDetailController extends Controller
{
    public function get_subject_detail(Request $request)
    {
        $token = $request->header('Authorization');
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        } 
        
        
        $existingUser = User::where('token', $token)->first();
        if($existingUser){
            $subject_detail =Subject_detail::where('subject_chapter_id', $request->input('subject_chapter_id'))->get();
            foreach ($subject_detail as $value) {
                $data[] = array(
                    'topic_no' => $value->topic_no,
                    'topic_name' => $value->topic_name,
                    'topic_video' => asset('video/'.$value->topic_video),

                  );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'subject_detail' => $data,
               ], 200, [], JSON_NUMERIC_CHECK);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ]);        
        }
    }
}

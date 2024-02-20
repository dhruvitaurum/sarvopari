<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function get_subject(Request $request)
    {
        $token = $request->header('Authorization');
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }


        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $subject = Subject::where('standard_id', $request->input('standard_id'))->get();
            foreach ($subject as $value) {
                $data[] = array(
                    'subject_name' => $value->subject_name,
                );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'subject_list' => $data,
            ], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
    }
}

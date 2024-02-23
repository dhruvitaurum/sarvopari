<?php

namespace App\Http\Controllers\API\student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function homescreen_student(Request $request){
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }

        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $Institute_medium = Banner::get();
            foreach ($Institute_medium as $value) {
                $institute_medium_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
    }
}

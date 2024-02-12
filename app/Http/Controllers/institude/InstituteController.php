<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\Institute_board;
use App\Models\Institute_for;
use App\Models\Institute_for_class;
use App\Models\User;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    
    public function get_institute_reponse(Request $request){
        $token = $request->header('Authorization');
       
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        } 
        
        
        $existingUser = User::where('token', $token)->first();
        if($existingUser){
            $institute_for = Institute_for::get();
            foreach ($institute_for as $value) {
                $institute_for_response[] = array(
                    'id'=>$value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                  );
            }
            $Institute_board = Institute_board::get();
            foreach ($Institute_board as $value) {
                $Institute_board_response[] = array(
                    'id'=>$value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                  );
            }
            $Institute_for_class = Institute_for_class::get();
            foreach ($Institute_for_class as $value) {
                $Institute_for_class_response[] = array(
                    'id'=>$value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                  );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'institute_for' => $institute_for_response,
                'institute_board' => $Institute_board_response,
                'institute_for_class'=>$Institute_for_class_response,
                
               ], 200, [], JSON_NUMERIC_CHECK);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ]);        
        }
    }
}

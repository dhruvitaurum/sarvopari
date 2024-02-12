<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\Standard;
use App\Models\User;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function get_standard(Request $request)
    {
        $token = $request->header('Authorization');
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        } 
        
        
        $existingUser = User::where('token', $token)->first();
        if($existingUser){
            $standrad =Standard::where('board_id', $request->input('board_id'))->get();
            foreach ($standrad as $value) {
                $data[] = array(
                    'standard_name' => $value->standard_name,
                  );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'standard_list' => $data,
               ], 200, [], JSON_NUMERIC_CHECK);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ],400);        
        }
    }
}

<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use App\Models\board;
use App\Models\Class_model;
use App\Models\Dobusinesswith_Model;
use App\Models\Institute_for_model;
use App\Models\Medium_model;
use App\Models\Standard_model;
use App\Models\Stream_model;
use App\Models\Subject_model;
use App\Models\User;
use Illuminate\Http\Request;

class InstituteApiController extends Controller
{
    function get_institute_reponse(Request $request){
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }


        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $institute_for = Institute_for_model::get();
            foreach ($institute_for as $value) {
                $institute_for_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_board = Board::get(); 
            $Institute_board_response = []; 
            $Institute_class_response = [];
            
            foreach ($Institute_board as $board) {
                $boardData = [
                    'id' => $board->id,
                    'name' => $board->name,
                    'status' => $board->status,
                ];
            
                $Institute_board_response[] = $boardData;
            
                $classlist = Class_model::where('board_id', $board->id)->get();
            
                foreach ($classlist as $value) {
                    $standards = Standard_model::where('class_id', $value->id)->get()->map(function ($standard) {
                        $stream = Stream_model::where('standard_id', $standard->id)->get()->map(function ($stream) {
                            return [
                                'id' => $stream->id,
                                'name' => $stream->name,
                                'status' => $stream->status,
                            ];
                        });
                        $subject = Subject_model::where('standard_id', $standard->id)->get()->map(function ($subject) {
                            return [
                                'id' => $subject->id,
                                'name' => $subject->name,
                                'status' => $subject->status,
                            ];
                        });
                
                        return [
                            'id' => $standard->id,
                            'name' => $standard->name,
                            'status' => $standard->status,
                            'subject' => $subject->toArray(), 
                            'stream' =>$stream->toArray(),
                        ];
                    });
                
                    $classData = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'status' => $value->status,
                        'standards' => $standards->toArray(), 
                    ];
                
                    $Institute_class_response[] = $classData;
                }
            }
            $Institute_medium = Medium_model::get();
            foreach ($Institute_medium as $value) {
                $institute_medium_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $dobusinesswith = Dobusinesswith_Model::get();
            foreach ($dobusinesswith as $value) {
                $dobusinesswith_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'institute_for' => $institute_for_response,
                'institute_board' => $Institute_board_response,
                'institute_class' => $Institute_class_response,
                'institute_medium' => $institute_medium_response,
                'do_business_with' => $dobusinesswith_response,
              

            ], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
    }
}

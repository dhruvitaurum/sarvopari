<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner_model;
use App\Models\board;
use App\Models\Class_model;
use App\Models\Class_sub;
use App\Models\Dobusinesswith_Model;
use App\Models\Dobusinesswith_sub;
use App\Models\Institute_for_model;
use App\Models\Institute_board_sub;
use App\Models\Institute_detail;
use App\Models\Institute_for_sub;
use App\Models\Medium_model;
use App\Models\Medium_sub;
use App\Models\Standard_model;
use App\Models\Standard_sub;
use App\Models\Stream_sub;
use App\Models\Stream_model;
use App\Models\Subject_model;
use App\Models\Subject_sub;
use App\Models\User;
use App\Models\Insutitute_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstituteApiController extends Controller
{
    function get_institute_reponse(Request $request)
    {
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
                        $streams = Stream_model::where('standard_id', $standard->id)->get()->map(function ($stream) {
                            $subjects = Subject_model::where('stream_id', $stream->id)->get()->map(function ($subject) {
                                return [
                                    'id' => $subject->id,
                                    'name' => $subject->name,
                                    'status' => $subject->status,
                                ];
                            });

                            return [
                                'id' => $stream->id,
                                'name' => $stream->name,
                                'status' => $stream->status,
                                'subjects' => $subjects,
                            ];
                        });

                        return [
                            'id' => $standard->id,
                            'name' => $standard->name,
                            'status' => $standard->status,
                            'streams' => $streams,
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

    public function register_institute(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'institute_for_id' => 'required|string',
            'institute_board_id' => 'required|string',
            'institute_for_class_id' => 'required|string',
            'institute_medium_id' => 'required|string',
            'institute_work_id' => 'required|string',
            'standard_id' => 'required|string',
            'subject_id' => 'required|string',
            'institute_name' => 'required|string',
            'address' => 'required|string',
            'contact_no' => 'required|integer|min:10',
            'email' => 'required|email|unique:institute_detail,email',
        ]);

        if ($validator->fails()) {
            $errorMessages = array_values($validator->errors()->all());
            return response()->json([
                'success' => 400,
                'message' => 'Validation error',
                'errors' => $errorMessages,
            ], 400);
        }
        try {
            //institute_detail
            $instituteDetail = Institute_detail::create([
                'user_id' => $request->input('user_id'),
                'institute_name' => $request->input('institute_name'),
                'address' => $request->input('address'),
                'contact_no' => $request->input('contact_no'),
                'email' => $request->input('email'),
                'status' => 'inactive'
            ]);
            $lastInsertedId = $instituteDetail->id;
            $institute_name = $instituteDetail->institute_name;

            //institute_for_sub
            $intitute_for_id = explode(',', $request->input('institute_for_id'));
            foreach ($intitute_for_id as $value) {
                if ($value == 5) {
                    $instituteforadd = institute_for_model::create([
                        'name' => $request->input('institute_for'),
                        'status' => 'active',
                    ]);
                    $institute_for_id = $instituteforadd->id;
                } else {
                    $institute_for_id = $value;
                }
                Institute_for_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'institute_for_id' => $institute_for_id,
                ]);
            }

            //board_sub
            $institute_board_id = explode(',', $request->input('institute_board_id'));
            foreach ($institute_board_id as $value) {
                //other
                if ($value == 4) {
                    $instituteboardadd = board::create([
                        'name' => $request->input('institute_board'),
                        'status' => 'active',
                    ]);
                    $instituteboard_id = $instituteboardadd->id;
                } else {
                    $instituteboard_id = $value;
                }
                //end other

                Institute_board_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'board_id' => $instituteboard_id,
                ]);
            }

            // class
            $institute_for_class_id = explode(',', $request->input('institute_for_class_id'));
            foreach ($institute_for_class_id as $value) {

                Class_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'class_id' => $value,
                ]);
            }

            //medium
            $institute_medium_id = explode(',', $request->input('institute_medium_id'));
            foreach ($institute_medium_id as $value) {
                Medium_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'medium_id' => $value,
                ]);
            }

            //dobusiness
            $institute_work_id = explode(',', $request->input('institute_work_id'));
            foreach ($institute_work_id as $value) {
                Dobusinesswith_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'do_business_with_id' => $value,
                ]);
            }

            //standard
            $standard_id = explode(',', $request->input('standard_id'));
            foreach ($standard_id as $value) {
                Standard_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'standard_id' => $value,
                ]);
            }

            //stream
            if ($request->input('stream_id')) {
                $stream = explode(',', $request->input('stream_id'));
                foreach ($stream as $value) {
                    Stream_sub::create([
                        'user_id' => $request->input('user_id'),
                        'institute_id' => $lastInsertedId,
                        'stream_id' => $value,
                    ]);
                }
            }
            //subject
            $subject_id = explode(',', $request->input('subject_id'));
            foreach ($subject_id as $value) {
                Subject_sub::create([
                    'user_id' => $request->input('user_id'),
                    'institute_id' => $lastInsertedId,
                    'subject_id' => $value,
                ]);
            }

            return response()->json([
                'success' => 200,
                'message' => 'institute create Successfully',
                'data' => [
                    'institute_id' => $lastInsertedId,
                    'institute_name' => $institute_name,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 500,
                'message' => 'Error creating institute',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    function get_board(Request $request)
    {
        $institute_id = $request->input('institute_id');
        $user_id = $request->input('user_id');
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }


        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $boardlist = DB::table('board_sub')
                ->join('board', 'board_sub.board_id', '=', 'board.id', 'left')
                ->where('board_sub.institute_id', $institute_id)
                ->paginate(10);
            if (!empty($boardlist)) {
                foreach ($boardlist as $value) {
                    $board_array[] = array(
                        'board_id' => $value->id,
                        'board_name' => $value->name
                    );
                }
                $bannerlist=Banner_model::where('user_id',$user_id)->get();
                if($bannerlist){
                    foreach($bannerlist as $value){
                        $banner_array[] = array(
                            'banner_url' => asset($value->banner_image),
                        );
                    }
                }
               
                return response()->json([
                    'success' => 200,
                    'message' => 'Fetch board successfully',
                    'data' => [
                        'boardlist' =>  $board_array,
                        'bannerlist' => $banner_array
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => 500,
                    'message' => 'Not found data.',
                ], 500);
            }
        }
    }
}

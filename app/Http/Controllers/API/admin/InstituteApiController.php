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
            $institute_for = Institute_for_model::with('boards.classes.standards.streams.subjects')->get();

            $institute_for_response = $institute_for->map(function ($institute) {
                $boards = $institute->boards->map(function ($board) {
                    $classes = $board->classes->map(function ($class) {
                        $standards = $class->standards->map(function ($standard) {
                            $streams = $standard->streams->map(function ($stream) {
                                $subjects = $stream->subjects->map(function ($subject) {
                                    return [
                                        'id' => $subject->id,
                                        'stream_id'=>$subject->stream_id,
                                        'name' => $subject->name,
                                        'status' => $subject->status,
                                    ];
                                });
                        
                                return [
                                    'id' => $stream->id,
                                    'standard_id'=>$stream->id,
                                    'name' => $stream->name,
                                    'status' => $stream->status,
                                    'subjects' => $subjects->toArray(),
                                ];
                            });
                        
                            // If there are no streams, include subjects directly at the standard level
                            $subjectsAtStandardLevel = $standard->subjects->map(function ($subject) {
                                return [
                                    'id' => $subject->id,
                                    'standard_id' => $subject->standard_id,
                                    'name' => $subject->name,
                                    'status' => $subject->status,
                                ];
                            });
                        
                            return [
                                'id' => $standard->id,
                                'class_id'=>$standard->class_id,
                                'name' => $standard->name,
                                'status' => $standard->status,
                                'streams' => $streams->isEmpty() ? [] : $streams->toArray(),
                                'subjects' => $streams->isEmpty() ? $subjectsAtStandardLevel->toArray() : [],
                            ];
                        });
            
                        return [
                            'id' => $class->id,
                            'board_id'=>$class->board_id,
                            'name' => $class->name,
                            'icon' =>asset($class->icon),
                            'status' => $class->status,
                            'standards' => $standards,
                        ];
                    });
            
                    return [
                        'id' => $board->id,
                        'institute_id'=>$board->institute_for_id,
                        'name' => $board->name,
                        'icon' =>asset($board->icon),
                        'status' => $board->status,
                        'classes' => $classes,
                    ];
                });
            
                return [
                    'id' => $institute->id,
                    'name' => $institute->name,
                    'icon' =>asset($institute->icon),
                    'status' => $institute->status,
                    'boards' => $boards,
                ];
            });
            $Institute_medium = Medium_model::get();
            foreach ($Institute_medium as $value) {
                $institute_medium_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'icon' =>asset($value->icon),
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
                // 'institute_board' => $boards,
                // 'institute_class' => $Institute_class_response,
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

        $boards = Board::whereHas('boardSub', function ($query) use ($institute_id) {
            $query->where('institute_id', $institute_id);
        })
        ->with(['classes.standards.subjects'])
        ->paginate(10);
        
        $board_array = [];
        
        foreach ($boards as $board) {
            $class_array = [];
        
            foreach ($board->classes as $class) {
                $standard_array = [];
        
                foreach ($class->standards as $standard) {
                    $subject_array = $standard->subjects->map(function ($subject) {
                        return [
                            'subject_id' => $subject->id,
                            'subject_name' => $subject->name,
                        ];
                    })->all();
        
                    $standard_array[] = [
                        'standard_id' => $standard->id,
                        'standard_name' => $standard->name,
                        'subject_array' => $subject_array,
                    ];
                }
        
                $class_array[] = [
                    'class_id' => $class->id,
                    'class_name' => $class->name,
                    'standard_array' => $standard_array,
                ];
            }
        
            $board_array[] = [
                'board_id' => $board->id,
                'board_name' => $board->name,
                'class_array' => $class_array,
            ];
        }
        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
        
            $bannerlist=Banner_model::where('user_id',$user_id)->get();
            if($bannerlist){
                foreach($bannerlist as $value){
                    $banner_array[] = array(
                        'banner_url' => asset($value->banner_image),
                        
                    );
                }
            }
     
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'institute_for' => '',
                'banner_array' => $banner_array,
                'board_array' =>$board_array


            ], 200, [], JSON_NUMERIC_CHECK);
        } 
        else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
            }
            
    function get_class(Request $request){
        $institute_id = $request->input('institute_id');
        $user_id = $request->input('user_id');
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }


        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
      
            $classlist = DB::table('class')
            ->join('class_sub', 'class_sub.class_id', '=', 'class.id')
            ->where('class_sub.institute_id', $institute_id)
            ->where('class_sub.user_id', $user_id)
            ->select('class.*')
            ->paginate(10);
        
        $class_array = [];
        
        foreach ($classlist as $classItem) {
            $standardlist = DB::table('standard')
                ->join('standard_sub', 'standard.id', '=', 'standard_sub.standard_id')
                ->where('standard.class_id', $classItem->id)
                ->where('standard_sub.institute_id', $institute_id)
                ->where('standard_sub.user_id', $user_id)
                ->select('standard.*')
                ->get();
                
        
            $standard_array = [];
        
            foreach ($standardlist as $standardItem) {
                $streamlist = DB::table('stream')
                ->join('stream_sub', 'stream_sub.stream_id', '=', 'stream.id')
                ->where('stream.standard_id', $standardItem->id)
                ->where('stream_sub.institute_id', $institute_id)
                ->where('stream_sub.user_id', $user_id)
                ->select('stream.*')
                ->get();

                $subjectlist = DB::table('subject')
                    ->join('subject_sub', 'subject_sub.subject_id', '=', 'subject.id','left')
                    ->where('subject.standard_id', $standardItem->id)
                    ->select('subject.*')
                    ->paginate(10);
                  $subject_array= [];
                  $stream_array= [];
                  foreach ($streamlist as $streamItem) {
                    $stream_array[] = [
                        'stream_id'=> $streamItem->id,
                        'stream_name'=> $streamItem->name,
                        'subject'=> $subject_array,
                       ];
            foreach($subjectlist as $subjectItem){
                  
                    $subject_array[] = [
                        'subject_id'=> $subjectItem->id,
                        'subject_name'=> $subjectItem->name,
                        
                       ];
                  }
                 }
                $standard_array[] = [
                    'standard_id' => $standardItem->id,
                    'standard_name' => $standardItem->name,
                    'stream' => $stream_array,
               ];
            }
            $class_array[] = [
                'class_id' => $classItem->id,
                'class_name' => $classItem->name,
                'standard' => $standard_array,
            ];
         }
            return response()->json([
                'success' => 200,
                'message' => 'Fetch Class successfully',
                'data' =>  $class_array,
                
            ], 200);
        } else {
            return response()->json([
                'success' => 500,
                'message' => 'No found data.',
            ], 500);
        
        }
    }
    // function get_subject_stream(Request $request){
    //     $institute_id = $request->input('institute_id');
    //     $user_id = $request->input('user_id');
    //     $standard_id = $request->input('standard_id');
    //     $token = $request->header('Authorization');
    //     if (strpos($token, 'Bearer ') === 0) {
    //         $token = substr($token, 7);
    //     }
    //    $existingUser = User::where('token', $token)->first();
    //     if ($existingUser) {
    //         $subjectlist = DB::table('subject')
    //         ->join('subject_sub', 'subject_sub.subject_id', '=', 'subject.id')
    //         ->where('subject.standard_id', $standard_id)
    //         ->select('subject.*')
    //         ->paginate(10);
        
    //     $subject_array = [];
        
    //     foreach ($subjectlist as $subjectItem) {
    //         $streamlist = DB::table('stream')
    //             ->join('stream_sub', 'stream_sub.stream_id', '=', 'stream.id')
    //             ->where('stream.standard_id', $subjectItem->standard_id)
    //             ->where('stream_sub.institute_id', $institute_id)
    //             ->where('stream_sub.user_id', $user_id)
    //             ->select('stream.*')
    //             ->get();
        
    //         $subject_array_collection = [];
        
    //         foreach ($streamlist as $streamItem) {
    //             $subject_array_collection[] = [
    //                 'stream_id' => $streamItem->id,
    //                 'stream_name' => $streamItem->name,
    //             ];
    //         }
        
    //         $subject_array[] = [
    //             'subject_id' => $subjectItem->id,
    //             'subject_name' => $subjectItem->name,
    //             'stream' => $subject_array_collection,
    //         ];
    //      }
    //         return response()->json([
    //             'success' => 200,
    //             'message' => 'Fetch Subject successfully',
    //             'data' =>  $subject_array,
                
    //         ], 200);

    //     }else{
    //         return response()->json([
    //             'success' => 500,
    //             'message' => 'No found data.',
    //         ], 500); 
    //     }

    // }
}

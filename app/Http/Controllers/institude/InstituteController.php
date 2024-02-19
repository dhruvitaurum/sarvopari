<?php

namespace App\Http\Controllers\institude;

use App\Http\Controllers\Controller;
use App\Models\Institute_board;
use App\Models\Institute_board_sub;
use App\Models\Institute_for;
use App\Models\Institute_for_class;
use App\Models\Institute_for_class_sub;
use App\Models\Institute_for_sub;
use App\Models\Institute_medium;
use App\Models\Institute_medium_sub;
use App\Models\Institute_subject;
use App\Models\Institute_subject_sub;
use App\Models\Institute_work;
use App\Models\Institute_work_sub;
use App\Models\Insutitute_detail;
use App\Models\User;
use Illuminate\Http\Request;

class InstituteController extends Controller
{

    public function get_institute_reponse(Request $request)
    {
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }


        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $institute_for = Institute_for::get();
            foreach ($institute_for as $value) {
                $institute_for_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_board = Institute_board::get();
            foreach ($Institute_board as $value) {
                $Institute_board_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_for_class = Institute_for_class::get();
            foreach ($Institute_for_class as $value) {
                $Institute_for_class_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_medium = Institute_medium::get();
            foreach ($Institute_medium as $value) {
                $Institute_medium_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_work = Institute_work::get();
            foreach ($Institute_work as $value) {
                $Institute_work_response[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'status' => $value->status,

                );
            }
            $Institute_subject = Institute_subject::get();
            foreach ($Institute_subject as $value) {
                $Institute_subject_response[] = array(
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
                'institute_for_class' => $Institute_for_class_response,
                'institute_medium' => $Institute_medium_response,
                'institute_work' => $Institute_work_response,
                'institute_subject' => $Institute_subject_response,


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
        // echo "<pre>";print_r($request->all());exit;
        $validator = \Validator::make($request->all(), [
            'user_id'=> 'required|integer',
            'institute_for_id' => 'required|string',
            'institute_board_id' => 'required|string',
            'institute_for_class_id' => 'required|string',
            'institute_medium_id' => 'required|string',
            'institute_work_id' => 'required|string',
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
            $instituteDetail =Insutitute_detail::create([
                'user_id'=>$request->input('user_id'),
                'institute_name'=>$request->input('institute_name'),
                'address'=>$request->input('address'),
                'contact_no'=>$request->input('contact_no'),
                'email'=>$request->input('email'),
            ]);
            $lastInsertedId = $instituteDetail->id;
            $intitute_for_id = explode(',',$request->input('institute_for_id'));
            foreach($intitute_for_id as $value){
                if($value == 5){
                    $instituteforadd = institute_for::create([
                        'name'=>$request->input('institute_for'),
                        'status'=>1,
                    ]);
                    $institute_for_id = $instituteforadd->id;
                }else{
                    $institute_for_id = $value;
                }
                Institute_for_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'institute_for_id'=>$institute_for_id,
                ]);
            }
            $institute_board_id = explode(',',$request->input('institute_board_id'));
            foreach($institute_board_id as $value){
                Institute_board_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'institute_board_id'=>$value,
                ]);
            }
            $institute_for_class_id = explode(',',$request->input('institute_for_class_id'));
            foreach($institute_for_class_id as $value){
                Institute_for_class_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'institute_for_class_id'=>$value,
                ]);
            }
            $institute_medium_id = explode(',',$request->input('institute_medium_id'));
            foreach($institute_medium_id as $value){
                Institute_medium_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'institute_medium_id'=>$value,
                ]);
            }
            $institute_work_id = explode(',',$request->input('institute_work_id'));
            foreach($institute_work_id as $value){
                Institute_work_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'institute_work_id'=>$value,
                ]);
            }
            $subject_id = explode(',',$request->input('subject_id'));
            foreach($subject_id as $value){
                Institute_subject_sub::create([
                    'user_id'=>$request->input('user_id'),
                    'institute_id'=>$lastInsertedId,
                    'subject_id'=>$value,
                ]);
            }
            

            return response()->json([
                'success' => 200,
                'message' => 'Institute created successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 500,
                'message' => 'Error creating institute',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

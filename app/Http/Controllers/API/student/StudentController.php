<?php

namespace App\Http\Controllers\API\student;
use App\Http\Controllers\Controller;
use App\Models\Banner_model;
use App\Models\Institute_detail;
use App\Models\Student_detail;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function homescreen_student(Request $request){
        $token = $request->header('Authorization');
        
        
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }
        $user_id = $request->user_id;
        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {
            $studentDT = Student_detail::where('id',$user_id) ->get();
            $instituteids = '';
            $instuser_ids = '';
            foreach($studentDT as $value){
                $instituteids .= $value->institute_id.',';
                $instuser_ids .=$value->user_id;
            }
            $instituteids .= '0';
            if($instituteids == '0'){
                $instuser_id = '1';
            }else{
                $instuser_id = $instuser_ids;
            }
            $banners = Banner_model::where('status','active')->wherein('user_id',$instuser_id)->get();
            
            $banners_data = [];
            foreach ($banners as $value) {
                $banners_data[] = array(
                    'id' => $value->id,
                    'banner_image' => $value->banner_image,
                );
            }

            $allinstitute = Institute_detail::where('status','active') ->get();
            $institute_list = [];
            foreach ($allinstitute as $value) {
                $institute_list[] = array(
                    'id' => $value->id,
                    'institute_name' => $value->institute_name,
                    'address'=>$value->address,
                );
            }

            
            $joininstitute =Institute_detail::where('status','active') ->whereIn('id', function($query) use ($user_id) {
                $query->select('institute_id')
              ->where('student_id', $user_id)
              ->from('students_details');
            })->get();
            $join_with = [];
            foreach ($joininstitute as $value) {
                $join_with[] = array(
                    'id' => $value->id,
                    'institute_name' => $value->institute_name,
                    'address'=>$value->address,
                );
            }

            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetch data.',
                'banner' => $banners_data,
                'institute_list' => $institute_list,
                'join_with' => $join_with,
            ], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\API\student;
use App\Http\Controllers\Controller;
use App\Models\Banner_model;
use App\Models\Institute_detail;
use App\Models\Student_detail;
use App\Models\Search_history;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function homescreen_student(Request $request){
        $token = $request->header('Authorization');
        
        
        if (strpos($token, 'Bearer') === 0) {
            $token = substr($token, 7);
        }

        $user_id = $request->user_id;
        $search_keyword = $request->search;

        $existingUser = User::where('token', $token)->first();
        if ($existingUser) {

            //banner
            $studentDT = Student_detail::where('id',$user_id) ->get();
            $instituteids = '';
            $instuser_ids = '';
            foreach($studentDT as $value){
                $instituteids .= $value->institute_id.',';
                $instuser_ids .=$value->user_id.',';
            }
            $instituteids .= '0';
            $instuser_ids .= '0';
            if($instituteids == '0'){
                $instuser_id = '1';
            }else{
                $instuser_id = $instuser_ids;
            }
            
            
                $banners = Banner_model::where('status', 'active')
                            ->whereIn('user_id', explode(',',$instuser_id))
                            ->orWhereIn('institute_id', explode(',',$instuser_ids))
                            ->get();
            $banners_data = [];
            foreach ($banners as $value) {
                $banners_data[] = array(
                    'id' => $value->id,
                    'banner_image' => $value->banner_image,
                );
            }

            //student searched response 
            $allinstitute = Institute_detail::where('institute_name','like','%' . $search_keyword . '%')->where('status','active')->get();
            $institute_list = [];
            foreach ($allinstitute as $value) {
                $institute_list[] = array(
                    'id' => $value->id,
                    'institute_name' => $value->institute_name,
                    'address'=>$value->address,
                );
            }

            //student search history
            $searchhistory = Search_history::where('user_id',$user_id)->get();
            $searchhistory_list = [];
            foreach ($searchhistory as $value) {
                $searchhistory_list[] = array(
                    'id' => $value->id,
                    'user_id' => $value->user_id,
                    'title'=>$value->title,
                );
            }
            
            //requested institute
            $requestnstitute =Student_detail::where('status','inactive')->where('student_id',$user_id)->get();
           
            $requested_institute = [];
            foreach ($requestnstitute as $value) {
                $requested_institute[] = array(
                    'id' => $value->id,
                    'institute_name' => $value->institute_name,
                    'address'=>$value->address,
                );
            }

            //join with
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
                'searchhistory_list'=>$searchhistory_list,
                'requested_institute'=>$requested_institute,
                'join_with' => $join_with,
            ], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid token.',
            ], 400);
        }
    }

    public function student_searchhistory_add(Request $request){

        $search_add = Search_history::create([
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
        ]);

        return response()->json([
            'success' => 200,
            'message' => 'Serach History Added',
        ], 200);
    }

    public function student_add_institute_request(Request $request){
        $instituteid = $request->institute_id;
        $getuid = Institute_detail::where('id',$instituteid)->get();

        $search_add = Student_detail::create([
            'user_id' => $getuid->user_id,
            'institute_id' => $request->input('institute_id'),
            'student_id' => $request->input('user_id'),
            'status' => 'inactive',
        ]);

        return response()->json([
            'success' => 200,
            'message' => 'Add into Serach History',
        ], 200);
    }
}

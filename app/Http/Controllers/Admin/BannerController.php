<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function list_banner(){
        $banner_list = Banner_model::paginate(10);
        return view('banner/list',compact('banner_list'));
    }
    public function create_banner(){
        return view('banner/create');
    }
    public function save_banner(Request $request){
    $request->validate([
            'banner_image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'=>'required',
    ]);
    $iconFile = $request->file('banner_image');
    $imagePath = $iconFile->store('banner_image', 'public');


    Banner_model::create([
        'user_id'=>Auth::user()->id,
        'banner_image'=>$imagePath,
        'status'=>$request->input('status'),
    ]);

    return redirect()->route('banner.list')->with('success', 'Banner Created Successfully');

    }
    function edit_banner(Request $request){
        $id = $request->input('banner_id');
        $banner_list = Banner_model::find($id);
        return response()->json(['banner_list'=>$banner_list]);
    }
    function update_banner(Request $request){
        // dd($request->all());exit;
        $id=$request->input('banner_id');
        $role = Banner_model::find($id);
        $request->validate([
            'banner_image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'=>'required',
       ]);
      
        $iconFile = $request->file('banner_image');
        if(!empty($iconFile)){
            $imagePath = $iconFile->store('banner_image', 'public');
        }else{
            $imagePath=$request->input('old_banner_image');
        }
        $role->update([
            'banner_image'=>$imagePath,
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('banner.list')->with('success', 'Banner Updated successfully');
   
    }
    function banner_delete(Request $request){
        $banner_id=$request->input('banner_id');
        $banner_list = Banner_model::find($banner_id);

        if (!$banner_list) {
            return redirect()->route('banner.list')->with('error', 'banner not found');
        }

        $banner_list->delete();

        return redirect()->route('banner.list')->with('success', 'Banner deleted successfully');
  
      
    }
}

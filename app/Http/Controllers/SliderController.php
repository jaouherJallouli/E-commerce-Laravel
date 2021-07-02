<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class SliderController extends Controller
{
    public function index()
    {
        return view('admin.add_slider');
    }


    public function save_slider(Request $request)
    {
        $data=array ();
        $data['publication_statuts'] = $request->publication_statuts;
        $image=$request->file('slider_image');
        if($image){
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $img_full_name=$image_name.'.'.$ext;
            $upload_path='slider/';
            $img_url=$upload_path.$img_full_name;
            $success=$image->move($upload_path, $img_full_name);
            if($success){
                $data['slider_image']=$img_url;
                    DB::table('slider')->insert($data);
                    $request->session()->put('message', 'Slider Successfully Added');
                    return Redirect::to ('/add-slider');

                 }
            }
            $data['slider_image']='';
            DB::table('slider')->insert($data);
            $request->session()->put('message', 'Slider Successfully Added without image');
            return Redirect::to ('/add-slider');
    }

    public function all_slider()
    {
        $all_slider=DB::table('slider')->get();
             $manage_slider=view('admin.all_slider')
             ->with('all_slider',$all_slider);

            return view('admin_layout')
            ->with('admin.all_slider',$manage_slider);
    }

    public function unactive_slider($slider_id ,Request $request){
          
        DB::table('slider')
          ->where('slider_id',$slider_id)
          ->update(['publication_statuts' =>0]);
          $request->session()->put('message', 'Slider unactive successfully');
          return Redirect::to('/all-slider');
    }
    public function active_slider($slider_id ,Request $request){
          
        DB::table('slider')
          ->where('slider_id',$slider_id)
          ->update(['publication_statuts' =>1]);
          $request->session()->put('message', 'Slider activated successfully');
          return Redirect::to('/all-slider');
    }
    public function delete_slider(Request $request,$slider_id)
    {
        
        DB::table('slider')
        ->where('slider_id',$slider_id)
        ->delete();
        $request->session()->put('message', 'Slider Delete successfully');
        return Redirect::to('/all-slider');
    }

 }

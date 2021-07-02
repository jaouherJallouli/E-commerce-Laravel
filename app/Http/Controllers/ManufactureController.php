<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ManufactureController extends Controller
{
        public function index()
        {
            return view('admin.add_manufacture');
        }



        public function save_manufacture(Request $request)
     {
         $data=array();
         $data['manufacture_id']=$request->manufacture_id;
         $data['manufacture_name']=$request->manufacture_name;
         $data['manufacture_description']=$request->manufacture_description;
         $data['publication_status']=$request->publication_status;

         DB::table('manufacture')->insert($data);
         $request->session()->put('message', 'Manufacture add successfully');
         return Redirect::to('/add-manufacture');
     }
     public function all_manufacture()
     {
             $all_manufacture_info=DB::table('manufacture')->get();
             $manage_manufacture=view('admin.all_manufacture')
             ->with('all_manufacture_info',$all_manufacture_info);

            return view('admin_layout')
            ->with('admin.all_manufacture',$manage_manufacture);
     }

     public function delete_manufacture(Request $request,$manufacture_id){
        
        DB::table('manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->delete();
        $request->session()->put('message', 'manufacture Delete successfully');
        return Redirect::to('/all-manufacture');

    }
    public function unactive_manufacture($manufacture_id ,Request $request){
          
        DB::table('manufacture')
          ->where('manufacture_id',$manufacture_id)
          ->update(['publication_status' =>0]);
          $request->session()->put('message', 'Manufacture unactive successfully');
          return Redirect::to('/all-manufacture');
    }

    public function active_manufacture($manufacture_id ,Request $request){
          
        DB::table('manufacture')
          ->where('manufacture_id',$manufacture_id)
          ->update(['publication_status' =>1]);
          $request->session()->put('message', 'Manufacture activated successfully');
          return Redirect::to('/all-manufacture');
    }

    public function edit_manufacture($manufacture_id){

       
        $manufacture_info=DB::table('manufacture')
             ->where('manufacture_id',$manufacture_id)->first();

            
             
             $manufacture_info=view('admin.edit_manufacture')
             ->with('manufacture_info',$manufacture_info);
             return view ('admin_layout')
             ->with('admin.edit_manufacture',$manufacture_info);         
    }
    public function update_manufacture(Request $request,$manufacture_id){

        $data=array();
        $data['manufacture_name']=$request->manufacture_name;
        $data['manufacture_description']=$request->manufacture_description;
        
        DB::table('manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->update($data);
        $request->session()->put('message', 'Manufacture Updated successfully');
        return Redirect::to('/all-manufacture');

    }
    
    }



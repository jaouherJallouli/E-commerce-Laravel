<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class ProductController extends Controller
{
    public function index(){
        return view('admin.add_product');
    }

    public function all_product()
     {
             $all_product_info=DB::table('products')
             ->join('category','products.category_id','=','category.category_id')
             ->join('manufacture','products.manufacture_id','=','manufacture.manufacture_id')
             ->get();

             $manage_product=view('admin.all_product')
             ->with('all_product_info',$all_product_info);

            return view('admin_layout')
            ->with('admin.all_product',$manage_product);
     }
    public function save_product (Request $request)
    {
        $data=array ();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_short_description'] = $request->product_short_description;
        $data['product_long_description'] = $request->product_long_description;
        $data['product_price'] = $request->product_price;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['publication_statuts'] = $request->publication_statuts;
        $image=$request->file('product_image');
        if($image){
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $img_full_name=$image_name.'.'.$ext;
            $upload_path='image/';
            $img_url=$upload_path.$img_full_name;
            $success=$image->move($upload_path, $img_full_name);
            if($success){
                $data['product_image']=$img_url;
                    DB::table('products')->insert($data);
                    $request->session()->put('message', 'Product Successfully Added');
                    return Redirect::to ('/add-product');
            }

        }
        $data['product_image']='';
            DB::table('products')->insert($data);
            $request->session()->put('message', 'Product Successfully Added without image');
            return Redirect::to ('/add-product');
    }

    public function unactive_product($product_id ,Request $request){
          
        DB::table('products')
          ->where('product_id',$product_id)
          ->update(['publication_statuts' =>0]);
          $request->session()->put('message', 'product unactive successfully');
          return Redirect::to('/all-product');
    }

    public function active_product($product_id ,Request $request){
          
        DB::table('products')
          ->where('product_id',$product_id)
          ->update(['publication_statuts' =>1]);
          $request->session()->put('message', 'product activated successfully');
          return Redirect::to('/all-product');
    }
    public function delete_product(Request $request,$product_id){
        
        DB::table('products')
        ->where('product_id',$product_id)
        ->delete();
        $request->session()->put('message', 'Product Delete successfully');
        return Redirect::to('/all-product');

    }
}

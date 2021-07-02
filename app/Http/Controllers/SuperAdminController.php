<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

Session_start();
class SuperAdminController extends Controller
{
    

    public function index(Request $request)
    {
      $this->AdminAuthCheck($request);
        return view('admin.dashbord');
    }

    public function logout(Request $request){
        $request->session()->put('admin_name',null);
        $request->session()->put('admin_id',null);
        return Redirect::to('/admin');
    }

    public function AdminAuthCheck(Request $request)
    {
     $admin_id=$request->session()->get('admin_id');
     if ($admin_id) {
         return;
     }else{
         return Redirect::to('/admin')->send();
     }

     }

     
    }
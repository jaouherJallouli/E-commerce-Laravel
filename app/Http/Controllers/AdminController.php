<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Session;

Session_start();
class AdminController extends Controller
{
    public function index()
    {
        return view('admin_login');
    }
    

    public function dashbord(Request $request)
    {
       $admin_email=$request->admin_email;
       $admin_password=md5($request->admin_password);
       $result=DB::table('admin')
                 ->where('admin_email',$admin_email)
                 ->where('admin_password',$admin_password)
                 ->first();
                if ($result){
                    $request->session()->put('admin_name',$result->admin_name);
                    $request->session()->put('admin_id',$result->admin_id);
                    return Redirect::to('/dashbord');

                }else{
                    $request->session()->put::put('message','Email or Password Invalid');
                    return Redirect::to('/admin');

                }

    }
}

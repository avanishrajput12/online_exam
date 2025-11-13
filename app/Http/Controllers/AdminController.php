<?php

namespace App\Http\Controllers;
use App\Models\AdminsModel;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Category;


class AdminController extends Controller
{
         public function adminlogin(Request $request){
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|min:6|confirmed',            
                ]);
                if($request->isMethod("POST")){
                  $data= AdminsModel::where("email",$request->email)->first();
                 if ($data && $data->checkPassword($request->password)){
                        return redirect()->route('dashboard')->with('success');
                  }else{
                        return redirect()->route('admin')->with('error','Invalid Credentials');
                  }  
                }
                return view('login.adminlogin');               
         }
     
      public function AddStudent(Request $request){
        $request->validate([
            'email' => 'required|email|unique:students,email',
        ]);
              $data=Students::create([
                    'email'=>$request->email,
                    'fname' => '',
                    'image' => '',
                    'phone' => '',
                    'dob' => null,
              ]);
           
                return response()->json($data); 
      } 

      public function allData(){
        $data=Students::all();
        return view("admin.students",compact('data'));
      }
}

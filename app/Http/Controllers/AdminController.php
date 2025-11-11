<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;


class AdminController extends Controller
{

     
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

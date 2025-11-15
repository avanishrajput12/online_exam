<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // LOGIN USER
    public function login(Request $request)
    {
        $user = Students::where('email', $request->email)->first();

        if (!$user || $user->password != $request->password) {
            return back()->with('error', 'Invalid Credentials');
        }

        session([
            'student_id' => $user->id,
            'student_name' => $user->fname
        ]);

        return redirect()->route('user.profile');
    }

    // PROFILE PAGE VIEW
    public function profilePage()
    {
        $user = Students::findOrFail(session('student_id'));

        return view('student.update_profile', compact('user'));
    }

    // PROFILE UPDATE
    public function updateProfile(Request $request)
    {
        $user = Students::findOrFail(session('student_id'));

        if ($request->hasFile('profile_image')) {
            $img = $request->file('profile_image')->store('profile_images', 'public');
            $user->image = $img;
        }

        $user->fname = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->tenth_percentage = $request->tenth_percentage;
        $user->twelfth_percentage = $request->twelfth_percentage;
        $user->cgpa = $request->cgpa;

        $user->save();

        return redirect()->route('student.test.start', 1); // Start test after update
    }
}

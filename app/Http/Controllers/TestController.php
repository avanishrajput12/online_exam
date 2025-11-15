<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Questions;
use App\Models\Students;

use App\Models\TestAssignment;

use Illuminate\Http\Request;

class TestController extends Controller
{
   
    public function createTestPage()
    {
        return view("admin.partials.create_test", [
            "categories" => \App\Models\Category::all()
        ]);
    }



    /* -----------------------------------------------------
        ACTION: Create Test
    ----------------------------------------------------- */
    public function createTest(Request $request)
    {
        $request->validate([
            "title" => "required",
            "categories" => "required|array",
            "counts" => "required|array",
            "duration" => "required|integer|min:1"

        ]);

        $total_questions = array_sum($request->counts);

        $test = Test::create([
            "title" => $request->title,
            "total_questions" => $total_questions,
            "duration" => $request->duration
        ]);

        // SAVE ALL CATEGORY QUESTIONS
        foreach ($request->categories as $index => $cat_id) {

            $count = $request->counts[$index];

            $questions = Questions::where("category_id", $cat_id)
                ->inRandomOrder()
                ->limit($count)
                ->get();

            foreach ($questions as $q) {
                TestQuestion::create([
                    "test_id" => $test->id,
                    "question_id" => $q->id
                ]);
            }
        }

        return response()->json([
            "success" => true,
            "msg" => "Test Created Successfully!"
        ]);
    }




    /* -----------------------------------------------------
        PAGE: All Tests
    ----------------------------------------------------- */
    public function allTests()
    {
        $tests = Test::withCount("testQuestions")
            ->orderBy("id", "DESC")
            ->get();

        return view("admin.partials.all_tests", compact("tests"));
    }




    /* -----------------------------------------------------
        PAGE: View Test Details
    ----------------------------------------------------- */
    public function viewTest($id)
    {
        $test = Test::with(["testQuestions.question"])->findOrFail($id);

        return view("admin.partials.view_test", compact("test"));
    }




    /* -----------------------------------------------------
        PAGE: Assign Test Modal + Assign User
    ----------------------------------------------------- */
    public function assignTest(Request $request)
{
    $request->validate([
        "test_id" => "required|exists:tests,id",
        "student_id" => "required|exists:students,id",
    ]);

    TestAssignment::create([
        'test_id' => $request->test_id,
        'student_id' => $request->student_id,
        'status' => 'pending',
        'assigned_at' => now()
    ]);

    return response()->json([
        "success" => true,
        "msg" => "Test Assigned Successfully!"
    ]);
}




    /* -----------------------------------------------------
        ACTION: Delete Test
    ----------------------------------------------------- */
    public function deleteTest($id)
    {
        TestQuestion::where("test_id", $id)->delete();
        Test::where("id", $id)->delete();

        return response()->json([
            "success" => true
        ]);
    }

    public function assignModal($id)
{
    $test = Test::find($id);

    if(!$test){
        return response("<h4>Invalid Test ID</h4>", 404);
    }

    $users = Students::all();

    return view('admin.partials.assign_test_modal', compact('test','users'));
}



public function studentStartTest($id)
{
    $test = Test::with(['testQuestions.question'])->findOrFail($id);

    return view('student.student_test', compact('test'));
}



}

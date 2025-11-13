<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /* -----------------------------------------------------
        PAGE: Create Test Page (Multi Category)
    ----------------------------------------------------- */
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
            "counts" => "required|array"
        ]);

        $total_questions = array_sum($request->counts);

        $test = Test::create([
            "title" => $request->title,
            "total_questions" => $total_questions
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
            "test_id" => "required",
            "user_id" => "required",
        ]);

        // Example assign — you can save in DB table test_assignments
        // For now simply respond
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Category;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // List questions under category
    public function index($category_id)
    {
        $category = Category::find($category_id);
        $questions = Questions::where('category_id', $category_id)->get();

        return view('admin.partials.questions_list', compact('category', 'questions'));
    }

    // Store Question
    public function store(Request $req)
    {
        $req->validate([
            'category_id' => 'required',
            'question' => 'required',
            'op_1' => 'required',
            'op_2' => 'required',
            'op_3' => 'required',
            'op_4' => 'required',
            'correct' => 'required'
        ]);

        $q = Questions::create($req->all());

        return response()->json(['success' => true, 'data' => $q]);
    }

    // Get question for edit
    public function getQuestion($id)
    {
        return response()->json([
            'success' => true,
            'data' => Questions::find($id)
        ]);
    }

    // Update question
    public function update(Request $req, $id)
    {
        $q = Questions::find($id);
        $q->update($req->all());

        return response()->json(['success' => true, 'data' => $q]);
    }

    // Delete
    public function delete($id)
    {
        Questions::find($id)->delete();

        return response()->json(['success' => true]);
    }

}

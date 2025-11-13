<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    // existing methods...

    // 1. Return partial view (you may already have)
    public function allcateory()
    {
        $data = Category::orderBy('id','desc')->get();
        return view('admin.partials.questions', compact('data'));
    }

    // 2. Store category (Add)
    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2'
        ]);

        $cat = Category::create([
            'title' => $request->title
        ]);

        return response()->json([
            'success' => true,
            'data' => $cat
        ]);
    }

    // 3. Get single category (for edit populate)
    public function getCategory($id)
    {
        $cat = Category::find($id);
        if(!$cat) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true, 'data' => $cat]);
    }

    // 4. Update category
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2'
        ]);

        $cat = Category::find($id);
        if(!$cat) {
            return response()->json(['success' => false], 404);
        }

        $cat->title = $request->title;
        $cat->save();

        return response()->json(['success' => true, 'data' => $cat]);
    }

    // 5. Delete category
    public function deleteCategory($id)
    {
        $cat = Category::find($id);
        if(!$cat) {
            return response()->json(['success' => false], 404);
        }
        $cat->delete();
        return response()->json(['success' => true]);
    }
}



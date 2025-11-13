<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'layouts.admin');

Route::prefix('admin')->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/students', [AdminController::class, 'allData'])->name('students');
    Route::view('/results', 'admin.result')->name('results');
    Route::view('/settings', 'admin.settings')->name('settings');

    Route::post('/add-student', [AdminController::class, 'AddStudent'])->name('addstu');

    // ---- CATEGORY ROUTES MUST BE HERE ----
    Route::get('/questions', [CategoryController::class, 'allcateory'])->name('questions');
    Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
    Route::get('/category/{id}', [CategoryController::class, 'getCategory'])->name('category.get');
    Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');
      Route::get('/questions/list/{category_id}', [QuestionController::class, 'index'])->name('questions.list');

    // Store QuestionQuestionController
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');

    // Get Single Question
    Route::get('/questions/get/{id}', [QuestionController::class, 'getQuestion'])->name('questions.get');

    // Update Question
    Route::post('/questions/update/{id}', [QuestionController::class, 'update'])->name('questions.update');

    // Delete
    Route::delete('/questions/delete/{id}', [QuestionController::class, 'delete'])->name('questions.delete');
});

Route::get('/user', function(){
    return view('login.userlogin');
})->name('user');

Route::match(['get','post'], 'admin', [AdminController::class, 'adminlogin'])->name('admin');

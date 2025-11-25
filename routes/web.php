<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::view('/', 'layouts.admin');


//      ADMIN ROUTES

Route::prefix('admin')->group(function () {

    // Dashboard
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // Students
    Route::get('/students', [AdminController::class, 'allData'])->name('students');
    Route::post('/add-student', [AdminController::class, 'AddStudent'])->name('addstu');

    // Results & Settings
   Route::get('/results', [AdminController::class, 'index'])->name('results');


    Route::view('/settings', 'admin.settings')->name('settings');



  
    Route::get('/questions', [CategoryController::class, 'allcateory'])->name('questions');
    Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
    Route::get('/category/{id}', [CategoryController::class, 'getCategory'])->name('category.get');
    Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');


   

   
    Route::get('/questions/list/{category_id}', [QuestionController::class, 'index'])->name('questions.list');
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/get/{id}', [QuestionController::class, 'getQuestion'])->name('questions.get');
    Route::post('/questions/update/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/delete/{id}', [QuestionController::class, 'delete'])->name('questions.delete');



    
    Route::get('/test/create-page', [TestController::class, 'createTestPage'])->name('generate.test');
    Route::post('/test/create', [TestController::class, 'createTest'])->name('test.create');
    Route::get('/tests', [TestController::class, 'allTests'])->name('tests.all');
     

    
    Route::get('/test/view/{id}', [TestController::class, 'viewTest'])->name('test.view');
    Route::get('/test/assign-modal/{id}', [TestController::class, 'assignModal'])->name('test.assign.modal');
    Route::post('/test/assign', [TestController::class, 'assignTest'])->name('test.assign');
    Route::delete('/test/delete/{id}', [TestController::class, 'deleteTest'])->name('test.delete');

});


// User Login
Route::get('/user', function () {
    return view('login.userlogin');
})->name('user');


// Admin Login
Route::match(['get', 'post'], '/admin', [AdminController::class, 'adminlogin'])->name('admin');








Route::get('/student/test/start/{id}', [TestController::class, 'studentStartTest'])
     ->name('student.test.start');
Route::post('/student/test/submit/{id}', [TestController::class, 'studentSubmitTest'])
     ->name('student.test.submit');




     // TEMPORARY — Test Preview Without Login
Route::get('/preview/test/{id}', [TestController::class, 'previewTest']);




// User Login Page
Route::get('/user/login', function () {
    return view('login.userlogin');
})->name('user.login');

// Handle login
Route::post('/user/login', [UserController::class, 'login'])->name('user.login.submit');
    Route::get('/user/profile', [UserController::class, 'profilePage'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/student/test/start/{id}', [TestController::class, 'studentStartTest'])
        ->name('student.test.start');
    Route::post('/student/test/submit/{id}', [TestController::class, 'studentSubmitTest'])
        ->name('student.test.submit');


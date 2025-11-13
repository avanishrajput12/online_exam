<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'layouts.admin');

Route::prefix('admin')->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/students', [AdminController::class, 'allData'])->name('students');
    Route::view('/results', 'admin.result')->name('results');
    Route::view('/settings', 'admin.settings')->name('settings');

    // CATEGORY ROUTES...
    // QUESTION ROUTES...
    // TEST CREATE ROUTES
    Route::get('/test/create-page', [TestController::class, 'createTestPage'])->name('generate.test');
    Route::post('/test/create', [TestController::class, 'createTest'])->name('test.create');
    Route::get('/tests', [TestController::class, 'allTests'])->name('tests.all');

    // ⭐ ADD THESE EXACTLY HERE
    Route::get('/test/view/{id}', [TestController::class, 'viewTest'])->name('test.view');
    Route::get('/test/assign-modal/{id}', [TestController::class, 'assignModal'])->name('test.assign.modal');
    Route::post('/test/assign', [TestController::class, 'assignTest'])->name('test.assign');
    Route::delete('/test/delete/{id}', [TestController::class, 'deleteTest'])->name('test.delete');

});

Route::get('/user', function () {
    return view('login.userlogin');
})->name('user');

Route::match(['get', 'post'], '/admin', [AdminController::class, 'adminlogin'])->name('admin');

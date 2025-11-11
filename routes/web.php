<?php
use Illuminate\Support\Facades\Route;

Route::view('/', 'layouts.admin');

Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/students', 'admin.students')->name('students');
    Route::view('/results', 'admin.result')->name('results');
    Route::view('/questions', 'admin.questions')->name('questions');
    Route::view('/settings', 'admin.settings')->name('settings');
});

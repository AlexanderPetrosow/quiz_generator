<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/enterKey', [QuestionController::class, 'enterKey'])->name('questions.enterKey');

// Это должно идти перед resource, чтобы иметь приоритет
Route::post('/questions/key', [QuestionController::class, 'showByKey'])->name('questions.postByKey');
Route::get('/questions/key', [QuestionController::class, 'showByKey'])->name('questions.showByKey');



// Затем остальные маршруты для questions
Route::resource('questions', QuestionController::class);

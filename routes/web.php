<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/enterKey', [QuestionController::class, 'enterKey'])->name('questions.enterKey');

// Это должно идти перед resource, чтобы иметь приоритет
Route::post('/questions/key', [QuestionController::class, 'showByKey'])->name('questions.postByKey');
Route::get('/questions/key', [QuestionController::class, 'showByKey'])->name('questions.showByKey');






// Затем остальные маршруты для questions
Route::resource('questions', QuestionController::class);

Route::post('/questions/{question}/answer', [QuestionController::class, 'answer'])->name('questions.answer');



Auth::routes();


Route::middleware(['auth', 'checkuserstatus', 'is_admin'])->group(function () {
    // Маршруты, которые требуют аутентификации, активного статуса и административных прав
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');

//редактирование юзеров
Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

Route::get('/questions/{question}/answers-data', [QuestionController::class, 'getAnswersData']);


Route::get('/dashboard', function () {
    return view('dashboards.dashboard');
})->name('dashboard');

Route::get('/dashboard/{uniqueKey}', [QuestionController::class, 'dashboard'])->name('dashboard');


Route::get('/questions/qrcode/{unique_key}', [QuestionController::class, 'generateQRCode'])->name('questions.qrcode');


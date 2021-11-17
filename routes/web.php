<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/random_list', [App\Http\Controllers\RandomController::class, 'list'])->name('random_list');

//ユニットの選択ページ
Route::get('/unit_select', [App\Http\Controllers\SortController::class, 'unit_select'])->name('unit_select');

//問題の選択ページ
Route::get('/q_select/{id}', [App\Http\Controllers\SortController::class, 'q_select'])->name('question_select');

//問題画面

Route::get('/q_select/{unit_id}/{q_id}',[App\Http\Controllers\QuestionController::class, 'question'])->name('question');
Route::get('/redirect/{q_id}',[App\Http\Controllers\SortController::class, 'q_route'])->name('q_route');
Route::post('/q_select/{unit_id}/{q_id}',[App\Http\Controllers\AnswerController::class, 'answer'])->name('answer');


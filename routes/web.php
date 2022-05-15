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
Route::get('/auth/passwords/update', [App\Http\Controllers\HomeController::class, 'password_update'])->name('password_update');
Route::post('/auth/passwords/update', [App\Http\Controllers\HomeController::class, 'password_update_post'])->name('password_update_post');


Route::get('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);
Route::get('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm']);

Route::post('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin']);
Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'registerAdmin'])->name('admin-register');

//管理者用
Route::get('/admin/home',[App\Http\Controllers\AdminController::class, 'index'])->middleware('auth:admin')->name('admin-home');
Route::get('/admin/group_management',[App\Http\Controllers\GroupController::class, 'index'])->middleware('auth:admin')->name('group_manage');
Route::get('/admin/group/{id}', [App\Http\Controllers\GroupController::class, 'user_list'])->name('user_list');
Route::get('/admin/add_group', [App\Http\Controllers\GroupController::class, 'add_group'])->name('add_group');
Route::post('/admin/add_group', [App\Http\Controllers\GroupController::class, 'add'])->name('add_class');
Route::get('/admin/add_member/{id}', [App\Http\Controllers\GroupController::class, 'add_member'])->name('add_member');
Route::post('/admin/add_member/{id}', [App\Http\Controllers\GroupController::class, 'add_member_post'])->name('add_member_post');
Route::get('/admin/user/{id}', [App\Http\Controllers\GroupController::class, 'user_manage'])->name('user_manage');

Route::get('/admin/group/{id}/add_homework', [App\Http\Controllers\HomeworkController::class, 'add_homework'])->name('add_homework');
Route::post('/admin/group/{id}/add_homework', [App\Http\Controllers\HomeworkController::class, 'add'])->name('add_work');
Route::get('/admin/homework/detail/{id}', [App\Http\Controllers\HomeworkController::class, 'homework_detail'])->name('homework_detail');



//ユーザ用
Route::get('/random_list', [App\Http\Controllers\RandomController::class, 'list'])->name('random_list');

//ユニットの選択ページ
Route::get('/unit_select', [App\Http\Controllers\SortController::class, 'unit_select'])->name('unit_select');

//問題の選択ページ
Route::get('/q_select/{id}', [App\Http\Controllers\SortController::class, 'q_select'])->name('question_select');

//公式一覧画面
Route::get('/formula_list', [App\Http\Controllers\FormulaController::class, 'formula_list'])->name('formula_list');
//公式画面
Route::get('/formula/{unit_id}', [App\Http\Controllers\FormulaController::class, 'formula_select'])->name('formula_select');

//問題画面
Route::get('/q_select/{unit_id}/{q_id}',[App\Http\Controllers\QuestionController::class, 'question'])->name('question');
Route::get('/redirect/{q_id}',[App\Http\Controllers\SortController::class, 'q_route'])->name('q_route');
Route::post('/q_select/{unit_id}/{q_id}',[App\Http\Controllers\AnswerController::class, 'answer'])->name('answer');


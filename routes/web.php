<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;
Route::get('/', function () {
    return view("index");
});
Route::get('/auth_proxy', [GlobalController::class, 'auth_proxy']);
Route::get('/home',function(){
    return view("home_proxy");
})->name('home');
Route::get('/change_password', [GlobalController::class, 'change_password']);
Route::get('/new_password', function(){
    return view('new_password');
});

Route::get('/admin', function(){
    return view('admin');
});

Route::get('/auth_admin', [GlobalController::class, 'auth_admin']);

Route::get('/admin_home', function(){
    return view('admin_home');
});

Route::get('/logout', [GlobalController::class, 'logout']);

Route::get('/disable_user', [GlobalController::class, 'disable_user']);

Route::post('/add_new_user', [GlobalController::class, 'add_new_user']);

Route::get('/datos_students', [GlobalController::class, 'datos_students']);

Route::get('/download_pdf', [GlobalController::class, 'download_pdf']);

Route::get('/modal_data', [GlobalController::class, 'modal_data']);

Route::get('/upd_student', [GlobalController::class, 'upd_student']);

Route::get('/add_student_background', [GlobalController::class, 'add_student_background']);

Route::get('/add_student_circle', [GlobalController::class, 'add_student_circle']);



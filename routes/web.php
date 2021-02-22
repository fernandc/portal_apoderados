<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;

Route::get('/', function () {
    return view("index");
});
Route::get('/auth_proxy', [GlobalController::class, 'auth_proxy']);
Route::get('/home', [GlobalController::class, 'home_view']);

Route::get('/change_password', [GlobalController::class, 'change_password']);
Route::get('/new_password', function(){
    return view('new_password');
});

Route::get('/admin', function(){
    return view('admin');
});

Route::post('/auth_admin', [GlobalController::class, 'auth_admin']);

Route::get('/admin_home', function(){
    return view('admin_home');
});

Route::get('/confirmation', function(){
    return view('confirmation');
});
Route::get('/fam_circle', function(){
    return view('/home_proxy_frames/fam_circle');
});


Route::get('/logout', [GlobalController::class, 'logout']);

Route::get('/disable_user', [GlobalController::class, 'disable_user']);

Route::get('/add_new_user', [GlobalController::class, 'add_new_user']);

Route::get('/datos_students', [GlobalController::class, 'datos_students']);

Route::get('/download_pdf', [GlobalController::class, 'download_pdf']);

Route::get('/modal_data', [GlobalController::class, 'modal_data']);

Route::get('/upd_student', [GlobalController::class, 'upd_student']);

Route::get('/add_student_background', [GlobalController::class, 'add_student_background']);

Route::get('/aditional_info', [GlobalController::class, 'aditional_info']);

Route::get('/get_info', [GlobalController::class, 'get_data_info']);

Route::get('/add_student', [GlobalController::class, 'add_student']);

Route::get('/add_proxy_background', [GlobalController::class, 'add_proxy_background']);

Route::get('/add_proxy_data',[GlobalController::class, 'add_proxy_data']);

Route::get('/confirmation_account',[GlobalController::class, 'confirmation_account']);

Route::get('/home_circle',[GlobalController::class, 'home_circle']);

Route::get('/del_inscription', [GlobalController::class, 'del_inscription']);


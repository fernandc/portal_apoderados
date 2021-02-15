<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;
Route::get('/', function () {
    return view("index");
    // if(session::has('apoderado')){
    //     return redirect('/home');
    // }else{
    // }
});
Route::get('/auth_proxy', [GlobalController::class, 'auth_proxy']);
Route::get('/home',function(){
    return view("home_proxy");
});
Route::get('/change_password', [GlobalController::class, 'change_password']);
Route::get('/new_password', function(){
    return view('new_password');
});
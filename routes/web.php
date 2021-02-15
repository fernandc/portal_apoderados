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
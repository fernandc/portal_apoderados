<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view("index");
});

Route::get('/status',function(){
    dd(session::get('apoderado'));
});
Route::get('/auth_proxy', [GlobalController::class, 'auth_proxy']);
Route::get('/home', [GlobalController::class, 'home_view']);

Route::get('/change_password', [GlobalController::class, 'change_password']);
Route::get('/new_password', function(){
    return view('new_password');
});
Route::get('/forgot_pass', function(){
    return view('recovery_pass.forgot_pass');
});
Route::get('/recovery_pass',[GlobalController::class, 'recov_pass']);

Route::get('/changeOldPass',[GlobalController::class, 'changeOldPass']);

Route::get('/updPass',[GlobalController::class, 'updPass']);

Route::get('/forget_pass', [GlobalController::class, 'forget_pass']);

Route::get('/admin', function(){
    return view('admin');
});

Route::post('/auth_admin', [GlobalController::class, 'auth_admin']);

Route::post('/vaccine_info', [GlobalController::class, 'vaccineInfo']);

Route::get('/admin_home', [GlobalController::class, 'admin_home'] );

Route::get('/check_edit_forms', [GlobalController::class, 'check_edit_forms'] );

Route::get('/verificate_state_forms', [GlobalController::class, 'verificate_state_forms'] );

Route::get('/check_matri_process', [GlobalController::class, 'check_matri_process'] );

Route::get('/verificate_matri_process', [GlobalController::class, 'verificate_matri_process'] );

Route::get('/check_student_forms', [GlobalController::class, 'check_student_forms'] );

Route::get('/verificate_student_forms', [GlobalController::class, 'verificate_student_forms'] );

Route::get('/confirmation', function(){
    return view('confirmation');
});
Route::get('/fam_circle', function(){
    return view('/home_proxy_frames/fam_circle');
});

Route::get('/logout', [GlobalController::class, 'logout']);

Route::get('/disable_user', [GlobalController::class, 'disable_user']);

Route::get('/add_new_user', [GlobalController::class, 'add_new_user']);

Route::get('/activate_mail_user',[GlobalController::class, 'activate_mail_user']);

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

Route:: get('/sendInscription', [GlobalController::class, 'sendDetailsInscription']);

Route:: get('/storage/{path}', [GlobalController::class, 'getImage']);


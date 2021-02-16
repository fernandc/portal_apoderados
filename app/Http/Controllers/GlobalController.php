<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GlobalController extends Controller
{
    public function auth_proxy(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'auth_proxy',
            'data' => ['dni' => $gets['dni'], 'passwd' => $gets['passwd']]);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $status = $response->status();
        
        if($status == 200){
            $data= json_decode($response->body(),true);
            if($data==NULL){
                return back()->with('message','Usuario o contraseña incorrecto(s).');
            }
            else{
                if($data[0]["date_login"] ==NULL){
                    session::put(['apoderado'=> $data[0]]);
                    return redirect('/new_password');
                }
                else{
                    session::put(['apoderado'=> $data[0]]);
                    return redirect("/home");     
                }
            }
        }else{
            return back()->with('message','Error interno.');
        }
    }

    public function auth_admin(Request $request){
        $gets= $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'passAdmin',
            'data' => ["passAdmin" => $gets["passAdmin"]]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $status = $response->status();
        $data = json_decode($response->body(),true);
        if($response== "DONE"){ 
            session::put(['admin' => "admin"]);
            return redirect('/admin_home');
        }
        else{
            return back()->with('message','Contraseña incorrecta');
        }
    }

    public function change_password(Request $request){
        $oldPassword=Session::get('apoderado')["passwd"];
        $dni= Session::get('apoderado')["dni"];
        if($request->passwd == $oldPassword){
            return back()->with('message', 'Ingrese una contraseña distinta a la actual.');
        }
        else{
            if($request->passwd == $request->passwdconf)
            {
                if($request->email==NULL && $request->cellphone==NULL){
                    return back()->with('message','Ingrese al menos un dato de contacto.');
                }
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'change_pass',
                    'data' => ["dni" => $dni, "passwd" => $request->passwd]
                );
                $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
                
                $arrContact = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'up_first_data',
                    'data' => ["dni" => $dni, "email" => $request->email, "cell_phone" => $request->cell_phone]
                );

                $responseContact = Http::withBody(json_encode($arrContact), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
                if($response == "DONE" && $responseContact=="DONE"){
                    return $this->logout();
                }
                else{
                    if($response== "FAILED" || $responseContact== "FAILED"){
                        return back()->with('message','Error inesperado.');
                    }
                }
            }
            else{
                return back()->with('message','Las contraseñas deben coincidir');
            }
        }
    }

    public function admin_home(){
        
    }

    public function logout(){
        if(session::has('apoderado')){
            session::forget('apoderado');
            return redirect('/');
        }
        else{
            session::forget('admin');
            return redirect('/admin');
        }
    }

       
}

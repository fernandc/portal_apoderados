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
                    $arrMatricula = array(
                        'institution' => getenv("APP_NAME"),
                        'public_key' => getenv("APP_PUBLIC_KEY"),
                        'method' => 'home_proxy',
                        'data' => ['dni' => $data[0]["dni"], 'matricula' => getenv("MATRICULAS_PARA")]
                    );
                    $responseMatricula = Http::withBody(json_encode($arrMatricula), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
                    $matriculas = json_decode($responseMatricula->body(),true);
                    return view('home_proxy',compact('matriculas'));     
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
        $emails = json_decode($response->body(),true);
        if($response!= "FAILED"){ 
            session::put(['admin' => "admin"]);
            return view('admin_home', compact('emails'));
        }
        else{
            return back()->with('message','Contraseña incorrecta. Vuelva a intentar.');
        }
    }

    public function change_password(Request $request){
        if(Session::has('apoderado')){
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
        else{
            return redirect('/');
        }
    }

   

    public function add_new_user(Request $request){
        $gets = $request->input();
        if(session::has('admin')){
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'first_pass',
                'data' => ["dni" => $gets["dni"]]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
            if($response == "DONE"){
                return back()->with('message','Apoderado agregado');
            }
            else{
                return back()->with('error','El apoderado ya está registrado');
            }
        }
        else{
            return redirect('/');
        }
        
    }

    public function disable_user(Request $request){
        if(Session::has('admin')){
            $gets = $request->input();
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'disable_user',
                'data' => ["id_user" => $gets["id_user"], "method" => $gets["method"]]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
            return back()->with('message', 'Estado modificado');
        }
        else{
            return redirect('/');
        }
    }

    public function download_pdf(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'downloadPdf',
            'data' => ["id" => $gets["student"]]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $data = json_decode($response->body(), true);
        
        $pdfName = getenv("MATRICULAS_PARA") . " Matrícula ". $data["student"]["last_f"]." ".$data["student"]["last_m"]." ".$data["student"]["names"].".pdf";
        $report = \PDF::loadView('print_pdf', compact('data'));
        return $report->download($pdfName);
    }

    public function datos_students(Request $request){
        $gets= $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'datos_students',
            'data' => ["id" => $gets["id"]]
        );

        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        return $response;
    }

    public function modal_data(Request $request){
        $gets = $request->input();

        if($gets["data"] == "stuinfo"){
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'modal_data',
                'data' => ["stu" => $gets["stu"], "data" => $gets["data"], "id_apo" => $gets["id_apo"], "matricula" => getenv("MATRICULAS_PARA")]
            );
            
            $response= Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
    
            $data= json_decode($response->body(),true);
            //dd($data);
            return view("/froms")->with("form",$data[0])->with("student",$data[1])->with("inscription",$data[2]);
        }else if($gets["data"] == "stuback"){
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'modal_data',
                'data' => ["stu" => $gets["stu"], "data" => $gets["data"], "id_apo" => $gets["id_apo"], "matricula" => getenv("MATRICULAS_PARA")]
            );
            
            $response= Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
    
            $data= json_decode($response->body(),true);
            return view("/froms")->with("form",$data[0])->with("id_stu",$data[1])->with("background",$data[2]);
        }else if($gets["data"] == "proxys"){
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'modal_data',
                'data' => ["stu" => $gets["stu"], "data" => $gets["data"], "id_apo" => $gets["id_apo"], "matricula" => getenv("MATRICULAS_PARA"), "parent" => $gets["parent"]]
            );
            
            $response= Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
    
            $data= json_decode($response->body(),true);
            return view("/froms")->with("form",$data[0])->with("parent",$data[1])->with("id_stu",$data[2])->with("parent_data",$data[3])->with("c_apo",$data[4]);
        }else{
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'modal_data',
                'data' => ["stu" => $gets["stu"], "data" => $gets["data"], "id_apo" => $gets["id_apo"], "matricula" => getenv("MATRICULAS_PARA")]
            );
            
            $response= Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
    
            $data= json_decode($response->body(),true);
            return view("/froms")->with("form",$data[0])->with("id_stu",$data[1])->with("misc",$data[2])->with("cantidad",$data[3])->with("circle",$data[4]);
        }
        
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use App\Mail\activationMail;
use Illuminate\Support\Facades\Hash;

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
                if($data[0]["date_login"] == NULL){
                    
                    session::put(['apoderado'=> $data[0]]);
                    return redirect('/new_password');
                }
                else{
                    if($data[0]["account_active"]!= "TRUE"){
                        session::put(['apoderado' => $data[0]]);
                        return $this->confirmation_account();
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
                        return redirect('/home');
                    }
                }
            }
        }else{
            return back()->with('message','Error interno.');
        }
    }
    public function home_view(){
        $dni = session::get('apoderado')['dni'];
        $arrMatricula = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'home_proxy',
            'data' => ['dni' => $dni, 'matricula' => getenv("MATRICULAS_PARA")]
        );
        $responseMatricula = Http::withBody(json_encode($arrMatricula), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $matriculas = json_decode($responseMatricula->body(),true);

        $arrProxy = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'get_data_proxy',
            'data' => ['dni' => $dni]
        );
        $responseProxy = Http::withBody(json_encode($arrProxy), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $dataProxy = json_decode($responseProxy->body(),true);
        //dd($dataProxy);
        return view('home_proxy',compact('matriculas','dataProxy'));     
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
                        'data' => ["dni" => $dni,
                                   "email" => $request->email,
                                   "cell_phone" => $request->cell_phone,
                                   "names" =>$request->names,
                                   "last_p" => $request->last_p,
                                   "last_m" => $request-> last_m,
                        ]
                    );
                    $sesData = session::get('apoderado');
                    $sesData["email"] = $request->email;
                    $sesData["cell_phone"] = $request->cell_phone;
                    $sesData["names"] = $request->names;
                    $sesData["last_p"] = $request->last_p;
                    $sesData["last_m"] = $request->last_m;
                    session::put(['apoderado'=>$sesData]);
                    $responseContact = Http::withBody(json_encode($arrContact), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
                    if($response == "DONE" && $responseContact=="DONE"){
                        
                        return view('mail_send');
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
    public function add_student(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'add_student',
            'data' => ["rut" => $gets["rut"],
                       "nombres" =>$gets["nombres"],
                       "apellido_p" =>$gets["apellido_p"],
                       "apellido_m" => $gets["apellido_m"],
                       "ddlgenero" => $gets["ddlgenero"],
                       "nacionalidad" =>$gets["nacionalidad"],
                       "ddletina" => $gets["ddletina"],
                       "fecha_nac" =>$gets["fecha_nac"],
                       "ddlcurso" => $gets["ddlcurso"],
                       "matricula" => getenv("MATRICULAS_PARA"),
                       "id_apo" => Session::get('apoderado')["id"]
                       ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $message = json_decode($response->body(), true);
        return redirect('/home');
    }
    public function get_data_info(request $request){
        $rut = $request->input()["rut"];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.nombrerutyfirma.com/rut',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('term' => $rut),
          CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=d82fe5f81bf4359611fd43cef8babe72a1607882909'
          ),
        ));
        $response = curl_exec($curl);
        $string = substr($response, strpos($response, '<table class="table table-hover">'), strpos($response, '</table>'));
        $tbody = substr($string, strpos($string, '<tbody>'), strpos($string, '</tbody>'));
        $tr = substr($tbody, strpos($tbody, '<tr tabindex="1">'), strpos($tbody, '</tr>'));
        $order   = array("\t", "\n", "\"");
        $replace = '';
        // Procesa primero \r\n así no es convertido dos veces.
        $newstr = str_replace($order, $replace, $tr);
        $alpha = $porciones = explode("<td", $newstr);
        $array = array();
        $count = 0;
        foreach($alpha as $row){
            if ($count == 1){
                $array["full_name"] = substr($row,1,-5);
            }elseif($count == 2){
                $array["dni"] = substr($row,28,-5);
            }elseif($count == 3){
                $array["gender"] = substr($row,1,-5);
            }elseif($count == 4){
                $array["address"] = substr($row,1,-5);
            }elseif($count == 5){
                $array["commune"] = substr($row,1,-14);
            }
            $count++;
        }
        curl_close($curl);
        header('Content-Type: application/json');;
        print_r(json_encode($array, JSON_PRETTY_PRINT)); 
    }
    public function upd_student(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'upd_student',
            'data' => ["idstu" => $gets["idstu"],
                        "rut" => $gets["rut"],
                        "nombres" => $gets["nombres"],
                        "apellido_p" => $gets["apellido_p"],
                        "apellido_m"=> $gets["apellido_m"],
                        "ddlgenero" => $gets["ddlgenero"],
                        "nacionalidad" => $gets["nacionalidad"],
                        "ddletina" => $gets["ddletina"],
                        "fecha_nac" => $gets["fecha_nac"],
                        "ddlcurso" => $gets["ddlcurso"],
                        "id_apo" => Session::get('apoderado')["id"],
                        "matricula" => getenv("MATRICULAS_PARA")
                    ]
                        
        );
       
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        return back()->with('message',$response);
    }
    public function add_student_background(Request $request){
        $gets = $request->input();
        $arr= array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'add_student_background',
            'data' => [ "student" => $gets["student"],
                        "cellphone" => $gets["cellphone"],
                        "district" => $gets["district"],
                        "address" => $gets["address"],
                        "school_origin" => $gets["school_origin"],
                        "school_origin_year_in" => $gets["school_origin_year_in"],
                        "has_pie" => $gets["has_pie"],
                        "apply_pie_next_year" => $gets["apply_pie_next_year"],
                        "emergency_data" => $gets["emergency_data"],
                        "emergency_data_name" => $gets["emergency_data_name"],
                        "risk_disease" => $gets["risk_disease"],
                        "medical_treatment" => $gets["medical_treatment"],
                        "medical_treatment_from" => $gets["medical_treatment_from"],
                        "sensory_difficulties" => $gets["sensory_difficulties"],
                        "has_special_treatment" => $gets["has_special_treatment"],
                        "does_keep_st" => $gets["does_keep_st"],
                        "why_does_keep_st" => $gets["why_does_keep_st"],
                        "id_apo" => Session::get('apoderado')["id"],
                        "visits_per_month" => $gets["visits_per_month"],
                        "matricula" => getenv("MATRICULAS_PARA")
                    ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $message = json_decode($response->body(),true);
        return back()->with('message',$message);
    }
    public function add_proxy_data(Request $request){
        $gets = $request->input();
        $dni = str_replace("-","",$gets["rut"]);
        if(!isset($gets["ddlproxy"]) && !isset($gets["kinship"])){
            $gets["ddlproxy"] = NULL;
            $gets["kinship"] = NULL;
        }
        if(!isset($gets["current_civil_status"])){
            $gets["current_civil_status"] = NULL;
        }
        if(!isset($gets["legal_civil_status"])){
            $gets["legal_civil_status"] = NULL;
        }
        if(!isset($gets["educational_level"])){
            $gets["educational_level"] = NULL;
        }
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'proxys_data',
            'data' => [ "rut" => $dni,
                        "nombresparent" => $gets["nombresparent"],
                        "apellido_pparent" => $gets["apellido_pparent"],
                        "apellido_mparent" => $gets["apellido_mparent"],
                        "fecha_nacparent" => $gets["fecha_nacparent"],
                        "legal_civil_status" => $gets["legal_civil_status"],
                        "current_civil_status" => $gets["current_civil_status"],
                        "districtparent" => $gets["districtparent"],
                        "addressparent" => $gets["addressparent"],
                        "phoneparent" => $gets["phoneparent"],
                        "cellphoneparent" => $gets["cellphoneparent"],
                        "emailparent" => $gets["emailparent"],
                        "educational_level" => $gets["educational_level"],
                        "work" => $gets["work"],
                        "work_address" => $gets["work_address"],
                        "work_phone" => $gets["work_phone"],
                        "id_apo" => Session::get('apoderado')["id"],
                        "matricula" => getenv("MATRICULAS_PARA"),
                        "kinship" => $gets["kinship"],
            ]
        );
        
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $data = json_decode($response->body(),true);
        return redirect('/home');
    }
    public function add_proxy_background(Request $request){
        $gets = $request->input();
        
        if(!isset($gets["rut"])){
            $gets["rut"] = Session::get('apoderado')["dni"];
        }
        if(isset($gets["kinship"])){
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'add_proxy_background',
                'data' => [ "student" => $gets["student"],
                            "kinship" => $gets["kinship"],
                            "id_apo" => $gets["id_apo"] ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
            $data = json_decode($response->body(),true);
            return redirect('/home');

        }
        if(!isset($gets["ddlproxy"]) && !isset($gets["kinship"])){
            $gets["ddlproxy"] = NULL;
            $gets["kinship"] = NULL;
        }
        if(!isset($gets["ddlproxy"])){
            $gets["ddlproxy"] = NULL;
        }
        if(!isset($gets["parent_type"])){
            $gets["parent_type"] = NULL;
        }
        if(!isset($gets["current_civil_status"])){
            $gets["current_civil_status"] = NULL;
        }
        if(!isset($gets["legal_civil_status"])){
            $gets["legal_civil_status"] = NULL;
        }
        if(!isset($gets["educational_level"])){
            $gets["educational_level"] = NULL;
        }
        if(!isset($gets["visits_per_months"])){
            $gets["visits_per_months"] = NULL;
        }
        if(!isset($gets["live_with"])){
            $gets["live_with"] = NULL;
        }
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'add_proxy_background',
            'data' => [ "student" => $gets["student"],
                        "rut" => $gets["rut"],
                        "parent_type" => $gets["parent_type"],
                        "ddlproxy" => $gets["ddlproxy"],
                        //"kinship" => $gets["kinship"],
                        "visits_per_months" => $gets["visits_per_months"],
                        "live_with" => $gets["live_with"],
                        "nombresparent" => $gets["nombresparent"],
                        "apellido_pparent" => $gets["apellido_pparent"],
                        "apellido_mparent" => $gets["apellido_mparent"],
                        "fecha_nacparent" => $gets["fecha_nacparent"],
                        "legal_civil_status" => $gets["legal_civil_status"],
                        "current_civil_status" => $gets["current_civil_status"],
                        "districtparent" => $gets["districtparent"],
                        "addressparent" => $gets["addressparent"],
                        "phoneparent" => $gets["phoneparent"],
                        "cellphoneparent" => $gets["cellphoneparent"],
                        "emailparent" => $gets["emailparent"],
                        "educational_level" => $gets["educational_level"],
                        "work" => $gets["work"],
                        "work_address" => $gets["work_address"],
                        "work_phone" => $gets["work_phone"],
                        "id_apo" => Session::get('apoderado')["id"],
                        "matricula" => getenv("MATRICULAS_PARA") 
            ]
        );
        
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $data = json_decode($response->body(),true);
        return redirect('/home');
    }
    public function aditional_info(Request $request){
        $gets = $request->input();
        
        $arr= array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'aditional_info',
            'data' => [ "student" => $gets["student"],
                        "time_from_to" => $gets["time_from_to"],
                        "meth_go" => $gets["meth_go"],
                        "meth_back" => $gets["meth_back"],
                        "auth_quit" => $gets["auth_quit"],
                    ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        if($response == "DONE"){
            return back();
        } 
    }
    public function home_circle(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'home_circle',
            'data' => [ "student" => $gets["student"],
                        "kinships" => $gets["kinships"],
                        "full_names" => $gets["full_names"],
                        "same_inss" => $gets["same_inss"],
                        "years_olds" => $gets["years_olds"],
                        "occupations" => $gets["occupations"]
                    ]
        );   
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $data = json_decode($response->body(),true);
        return $data;
    }
    public function del_inscription(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'del_inscription',
            'data' => [ "stu" => $gets["stu"],
                        "id_apo" => Session::get('apoderado')["id"],
                        "matricula" => getenv("MATRICULAS_PARA")   
                    ]
        );

        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $message = $response;
        return $message;
    }
    public function confirmation_account(){
        $id = Session::get('apoderado')["id"];
        $rut = Session::get('apoderado')["dni"];
        $newid = urlencode(Hash::make($id));
        $message = "www.scc.cloupping.com/api-apoderado?method=confirmation_account&id=".$newid;
        Mail::to(session::get('apoderado')["email"])->send(new activationMail($message));
        return view('mail_sended');   
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

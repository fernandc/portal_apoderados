<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GlobalController extends Controller
{
    public function auth_proxy(Request $request){
        //dd(getenv("APP_NAME"));
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'auth_proxy',
            'data' => ['dni' => $gets['dni'], 'passwd' => $gets['passwd']]);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $status = $response->status();
        
        if($status == 200){
            $data= $response->body();
            session::put(['apoderado'=> $data]);
            return redirect("/home");
        }else{
            
        }
    }

    public function getDataProxy(){

        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => '',
            'data' => ['']
        );
        $response = Http::withBody(json_encode)->get("https://scc.clouping.com/api-apoderado");
    }

    

    
}

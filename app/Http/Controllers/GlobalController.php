<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GlobalController extends Controller
{
    public function auth_proxy(){
        //dd(getenv("APP_NAME"));
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'auth_proxy',
            'data' => ['dni' => '12345678', 'passwd' => '10*2*3']);
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $status = $response->status();
        if($status == false){
            return false;
        }else{
            return $response->body();
        }
    }
}

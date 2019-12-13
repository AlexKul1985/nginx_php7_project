<?php

namespace controllers\api_service;

use controllers\ApiController;
use database\DB;
use core\lib\Request;
use core\lib\Response;
use user_services\Authentication;

class MainServicesController extends ApiController{
    protected $id_user = 1;

    protected function getDataByIdUser($name_table,$fields){
        $data = DB::select($name_table)->findWhereAnd($fields,
        [
            
            ['id_user',"=",$this -> id_user]
        ]);
        
        // $response -> sendJson($types);
        return $data;
    }

    public function actionAuth(Request $request, Response $response){
       
        
        
        if($request -> getMethod() == 'POST'){
        
            if(DB::select('users') -> findRow('email', $request -> email)['password'] === $request -> password){
                Authentication::setExpireAT(15);
                $data["token"] = Authentication::getAccessToken();
               
                $response -> sendJson($data);
            }
               
        }
        else if($request -> getMethod() === "OPTIONS"){
            
        }
       
        
    }

    public function actionArticles(Request $request, Response $response){
        // echo 111;
        if($request -> getMethod() == "GET"){
            if(isset(Request::$headers['Authorized'])){
                $headerAuth = "";
                $headerAuth = Request::$headers['Authorized'];
                
                [$header, $payload, $sign] = explode(".",$headerAuth);
                [$header, $payload] = Authentication::unserializeData($header,$payload);
                if($payload['exp'] >= time()){
                    if(base64_encode(Authentication::signature($header, $payload)) === $sign) {
                        $data = DB::select('articles') -> all();
            
                        $response -> sendJson($data);
                    }
                    else{
                        $response -> sendJson(['res' => 'NO']);
                    }
                }
                else{
                    http_response_code(401);
                    $response -> sendJson(['res' => 'Время истекло']);
                }
                
            }
        }
    }
}
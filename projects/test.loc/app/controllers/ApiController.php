<?php
namespace controllers;
use database\DB;
use core\lib\Request;
use core\lib\Response;
use user_services\Authentication;

class ApiController extends AppController{
    
    
    public function __construct($route){
        
        parent::__construct($route);
        header("Content-Type: application/json");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');
    }

   

        
}
       

    
?>

   
    


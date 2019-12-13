<?php
namespace controllers;

// use models\Product;
use database\DB;

class MainController extends AppController{

    public function actionProducts(){
        // $this -> table_name = 'categories';
      
    }
        
        
    public function actionIndex(){
        echo "<h1>App test</h1>";
    }

   
    public function actionAbout(){
        echo __METHOD__;
    }
    public function actionCategory(){
        echo __METHOD__;
    }
    
}


?>
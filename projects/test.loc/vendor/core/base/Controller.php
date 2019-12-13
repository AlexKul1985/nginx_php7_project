<?php
namespace core\base;

use core\lib\Request;
use core\lib\Response;

class Controller{
    public $view;
    public $route;
    public $model = null;
    

    public function __construct( $route){
       
        $this -> route = $route;
        
    }
        
    public function __set($key,$val){
        if($key == 'table_name'){
            Model::setTableName($val);            
        }
    }

}
        

       
        
    
    
    


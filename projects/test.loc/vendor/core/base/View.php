<?php
namespace core\base;

class View{
    public $template;
    public $route = null;
    
    public function __construct($template, $compile, $route){
        
        $this ->  route =  $route;
       
        
    }

    public function render($data,$file_name=""){

        if(empty($file_name)){
            $file_name = $this -> route["action"];
        }

        

        foreach ($data as $key => $value) {
            $this -> template -> assign($key, $value);
        }

        $this -> template -> display($file_name.".tpl");
    }
    
}


?>
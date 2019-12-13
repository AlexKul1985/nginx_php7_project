<?php
namespace core\lib;

class ErrorHandler{
    public function __construct(){
        if(env("DEBUG")){
            error_reporting(-1);
        }
        else{
            error_reporting(0);
        }
        set_error_handler([$this,"errorHandler"]);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline){
        // echo "<br>";
        // var_dump($errno, $errstr, $errfile, $errline);
        $this -> displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function displayError($errno, $errstr, $errfile, $errline, $response = 500){
        http_response_code($response);
        if(env("DEBUG")){
            require ROOT."/app/views/errors/dev.php";
        }

        else{
            require ROOT."/app/views/errors/prod.php";
        }
    }
}


?>
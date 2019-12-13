<?php
namespace core;

use core\lib\ErrorHandler;

class App{

    public function __construct(){
        // session_start();
        lib\Router::run();
        // debug(lib\Router::$uri -> getParams());
        new ErrorHandler();
        // echo 1;
    
    }

    

}
        


?>
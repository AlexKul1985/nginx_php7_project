<?php
namespace app;
use Contracts\IUser;



class User implements IUser {
    private $name = "Alex";
    private $arr = ['One','Two','Three'];
    public function __construct(){
        
        
        require_once VIEW."/temp.php";
       
    }
    public function getName(){
        echo $this -> name;
    }
}


?>
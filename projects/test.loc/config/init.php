<?php
   date_default_timezone_set('Europe/Moscow');
   
   require_once "paths.php";
   require_once  ROOT."/vendor/autoload.php";
   
   require_once "helpers.php";
   
   $dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
   $dotenv->load();
   require_once "routers.php";

  

?>
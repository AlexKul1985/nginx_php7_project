<?php
namespace database;

use \PDO;

class DB{
    private static $builders = [
        'select' => 'database\select\DBSelect',
        'insert' => 'database\insert\DBInsert',
        'update' => 'database\update\DBUpdate',
        'delete' => 'database\delete\DBDelete',
    ];
    private static $connect = null;
    
    public static function __callStatic($type_query, $arguments) {
        if(is_null(self::$connect)) { 
            // echo "Connection";
            self::$connect = self::initConnection();
        }
        if(array_key_exists($type_query,self::$builders)) 
            return (new self::$builders[$type_query](...$arguments)) -> setConnect(self::$connect); 
    }
    
    private static function initConnection(){
        $dsn = "mysql:host=".env('DB_HOST').";dbname=".env('DB_NAME').";charset=".env('DB_CHARSET')."";
        return new PDO($dsn, env('USER_NAME'), env('DB_PASS'));
    }
}
    

 

            
        
        
            

    
    

?>
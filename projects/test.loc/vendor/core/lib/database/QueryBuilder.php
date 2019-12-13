<?php
namespace database;

    class QueryBuilder{
        private static $builders = [
            'select' => 'database\select\QuerySelect',
            'insert' => 'database\insert\QueryInsert',
            'update' => 'database\update\QueryUpdate',
            'delete' => 'database\delete\QueryDelete',
        ];

     

        public static function __callStatic($type_query, $arguments) {
            if(array_key_exists($type_query,self::$builders)){
                return (new self::$builders[$type_query](...$arguments)); 
            }
        }
    }
            
?>
        
       
           
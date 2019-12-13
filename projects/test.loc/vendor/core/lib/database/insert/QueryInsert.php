<?php
    namespace database\insert; 

    class QueryInsert{
       private $table_name = "";
       
      
       public function __construct($table_name){
          $this -> table_name = $table_name;
       }

       public function insert(){
            return "INSERT INTO ".$this -> table_name;
       }

       public function addOneValue($field){
           return $this -> insert()." SET ".$field." = ? ";
       }

       public function addValues($array_fields){
           return $this -> insert()."(`".implode('`,`',$array_fields)."`) VALUES (".str_repeat('?,',count($array_fields) - 1)."?)";
        }

    }



?>
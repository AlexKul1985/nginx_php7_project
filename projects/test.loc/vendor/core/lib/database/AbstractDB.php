<?php
namespace database;

use \PDO;

class AbstractDB{

    protected $connect = null;
    protected $table_name = "";

    public function __construct($table_name = ""){
        $this -> table_name = $table_name;
       
    }

    public function setConnect(PDO $connect){
        $this -> connect = $connect;
        return $this;
    }

    public function setTableName($table_name){
        $this -> table_name = $table_name;
    }

    protected function getArraysFromArray($array_assoc_values){
        $fields = [];
        $values = [];
        foreach ($array_assoc_values as $field => $value) {
            $fields[] = $field;
            $values[] = $value;
        }
        return [$fields, $values];
    }

    public function lastID(string $field_id){
       return $this -> connect -> lastInsertId($field_id);
    }
    
       
        


        
}
           
?>
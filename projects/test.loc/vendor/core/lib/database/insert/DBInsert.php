<?php
namespace database\insert;

use database\QueryBuilder;
use database\AbstractDB;
use \PDO;

class DBInsert extends AbstractDB{
   

    public function addValues($array_fields, $array_values){
        $stmt = $this -> connect -> prepare(QueryBuilder::insert($this -> table_name) -> addValues($array_fields));
        return $stmt->execute($array_values);
        
    }

    

    public function addAssocValues($array_assoc_values){
        $fields_values = $this -> getArraysFromArray($array_assoc_values);
        return $this -> addValues($fields_values[0], $fields_values[1]);
    }

    
}

?>
<?php
namespace database\update;

use database\QueryBuilder;
use database\AbstractDB;
use \PDO;

class DBUpdate extends AbstractDB{
  
    public function changeById($array_fields, $array_values, $id){
        $array_values[] = $id;
        $stmt = $this -> connect -> prepare(QueryBuilder::update($this -> table_name) -> change($array_fields, 'id'));
        return $stmt->execute($array_values);
    }


    public function changeAssocById($array_assoc_values, $id){
        $fields_values = $this -> getArraysFromArray($array_assoc_values);
        return $this -> changeById($fields_values[0], $fields_values[1], $id);
    }

    public function changeByField($array_fields, $array_values, $search){
        
        if(is_string($search) && strpos($search, "=>") !== false){
            $parseValues = explode("=>",$search);
        }
     
        $array_values[] = trim($parseValues[1]);
        $stmt = $this -> connect -> prepare(QueryBuilder::update($this -> table_name) -> change($array_fields, trim($parseValues[0])));
        return $stmt->execute($array_values);
    }
        
            

    public function changeAssocByField($array_assoc_values, $search){
        $fields_values = $this -> getArraysFromArray($array_assoc_values);
        return $this -> changeByField($fields_values[0], $fields_values[1], $search);
    }

    public function changeWhereAnd($update_filelds_value, $arrayWhere){
        $whereValue = [];
        $mergeArr = array_merge($update_filelds_value, $arrayWhere);
        $updateFields = [];
        $arrW = [];
        foreach($mergeArr as $value){
            $whereValue[] = array_pop($value);
            if(count($updateFields) < count($update_filelds_value)){
                $updateFields[] = array_pop($value);

            }
            else{
                $arrW[] = $value;
            }

        }
        

// print_r($whereValue);
        $stmt = $this -> connect -> prepare(QueryBuilder::update($this -> table_name) -> changeWhereAnd($updateFields,$arrW));
        return $stmt->execute($whereValue); 
        // return QueryBuilder::update($this -> table_name) -> changeWhereAnd($updateFields, $arrW);
    }
    
}

?>
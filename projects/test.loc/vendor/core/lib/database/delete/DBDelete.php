<?php
namespace database\delete;

use database\QueryBuilder;
use database\AbstractDB;


class DBDelete extends AbstractDB{
    
    public function remove($field, $value){
        $stmt = $this -> connect -> prepare(QueryBuilder::delete($this -> table_name) -> remove($field));
        return $stmt->execute([$value]); 
    }
    public function removeAnd($arrayWhere){
        $whereValue = [];
        foreach($arrayWhere as $value){
            $whereValue[] = array_pop($value);
        }
        $stmt = $this -> connect -> prepare(QueryBuilder::delete($this -> table_name) -> removeAnd($arrayWhere));
        return $stmt->execute($whereValue); 
    }

   
}


?>
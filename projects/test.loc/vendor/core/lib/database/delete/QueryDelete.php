<?php
    namespace database\delete; 

    class QueryDelete{
       private $table_name = "";
       
       
      
       public function __construct($table_name){
          $this -> table_name = $table_name;
       }

       private function delete(){
           return "DELETE FROM ".$this -> table_name;
       }

       private function where($field,$sep = "="){
           return " WHERE ".$field." ".$sep." ?";
       }
       public function whereAnd($arrayWhere){
        
        $whereAnd = '';
        $oneFlag = true;
        $fieldOne = null;
        $seporatorOne = null;
        if(!empty($arrayWhere)){
             foreach($arrayWhere as $value){
                [$field, $seporator] = $value;
                if($oneFlag) { 
                    $fieldOne = $field; 
                    $seporatorOne = $seporator; 
                    $oneFlag = false;
                    continue;
                }
                $whereAnd .= ' AND '.$field.' '.$seporator.' ?'; 
            }
                
        }
                
         else {
            return '';
         }
        
         return $this -> where($fieldOne,$seporatorOne).$whereAnd;
        }

       public function remove($field){
           return $this -> delete().$this -> where($field);
       }
       public function removeAnd($fields_array){
        return $this -> delete().$this -> whereAnd($fields_array);
    }
    }



?>
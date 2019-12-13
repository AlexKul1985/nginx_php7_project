<?php
    namespace database\update; 

    class QueryUpdate{
       private $table_name = "";
    //    private $update_fields = "";
       
      
       public function __construct($table_name){
          $this -> table_name = $table_name;
       }

       public function update($update_fields){
           $update_str = "";
           
           foreach ($update_fields as $value) {
               $update_str .= $value." = ? ,";
           }
           $update_str = substr($update_str,0,-1);

           return "UPDATE ".$this -> table_name." SET ".$update_str;
        }


           
        private function where($pre,$sep = "="){
            return " WHERE ".$pre." ".$sep." ?";
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
       public function changeOne($field,$pre){
           return $this -> change([$field],$pre);
        }
           

       public function change($array_fields,$pre){
            $this -> update_fields = implode(" = ?,",$array_fields)." = ?";
            echo $this -> update().$this -> where($pre);
            return $this -> update().$this -> where($pre);
        }

        public function changeWhereAnd($update_filelds_value, $fields_array){
            return $this -> update($update_filelds_value).$this -> whereAnd($fields_array);
        }
        

    }



?>
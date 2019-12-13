<?php
namespace database\select;

    class QuerySelect{
      
       private $table_name = "";
       private $search_fields = "";
      
       public function __construct($table_name){
          $this -> table_name = $table_name;
       }

       private function select(){
           return 'SELECT '.$this -> search_fields.' FROM '.$this -> table_name;
       }

       public function all(){
          $this -> search_fields = "*";
          return $this -> select();
        }
           
        //deprecated

       public function findRow($where){
          return $this -> all()." WHERE ".$where." = ?"; 
       }



       public function find($array_fields){
            $this -> search_fields = "";
            for($i = 0; $i < count($array_fields); $i++){
                if(($i + 1) !== count($array_fields)){
                    $this -> search_fields .= $array_fields[$i].", ";
                }
                else{
                    $this -> search_fields .= $array_fields[$i];
                }
            }
            return $this -> select();
            
        }
            
       public function findWhereAnd($array_fields,$arrayWhere){
       
            return $this -> find($array_fields).$this -> whereAnd($arrayWhere);
       }

       public function findJoin($array_fields, $join_params){

            $join = "";
            
            foreach ($join_params as  $value) {
            
                [$table_name, $fields] = explode(',',$value);
                [$one, $two] = explode('=',$fields);
                $join .= $this -> join($table_name,trim($one), trim($two));

            }
            
            return $this -> find($array_fields).$join;

       }



       public function findJoinWhere($array_fields, $join_params, $where, $seporator){
           return $this -> findJoin($array_fields, $join_params).$this -> where($where, $seporator); 
       }
       
       public function findJoinWhereAnd($array_fields, $join_params,$arrayWhere){
           return $this -> findJoin($array_fields, $join_params).$this -> whereAnd($arrayWhere); 
       }
       public function groupBy($field){
           return " GROUP BY ". $field;
       }
       public function findJoinWhereGroupBy($array_fields, $join_params, $where, $seporator,$groupByField){
        return $this -> findJoinWhere($array_fields, $join_params, $where, $seporator).$this -> groupBy($groupByField); 
        }
        public function findJoinWhereAndOrderByLimit($array_fields, $join_params,$arrayWhere,$field_sort, $type_sort,$offset,$count){
            return $this -> findJoin($array_fields, $join_params).$this -> whereAnd($arrayWhere).$this -> orderBy($field_sort, $type_sort).$this -> limit($offset, $count); 
        }
       
         



       public function where($where, $seporator){
            return " WHERE ".$where." ".$seporator." ?";
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
         

       
       public function join($table_name,$one, $two){
        
           $oneArr = explode('.',$one);
           $twoArr = explode('.',$two);
           return ' INNER JOIN '.$table_name.' ON `'.$oneArr[0].'`.`'.$oneArr[1].'` = `'.$twoArr[0].'`.`'.$twoArr[1].'`';
       }

       public function findCol($field){
            $this -> search_fields = $field;
            return $this -> select();
        }
        
        
        
        public function findWhere($array_fields,$where,$sep = "="){
            return $this -> find($array_fields).$this -> where($where, $sep);
        }

        private function orderBy($field_sort, $type_sort){
            return " ORDER BY ".$field_sort." ".$type_sort;
        }

        public function findOrderBy($type_sort,$field_sort, $array_fields = []){
            return ($this -> arrayIsEmpty($array_fields) ? $this -> find($array_fields) : $this -> all()).$this -> orderBy($field_sort,$type_sort);
            
        }

        private function arrayIsEmpty($array_fields){
            return (is_array($array_fields) && !empty($array_fields));
        } 

      
        
            

        private function limit($offset, $count){
            return " LIMIT ".$offset.",".$count;
        }

        public function findLimit($offset, $count, $array_fields = []){
            return ($this -> arrayIsEmpty($array_fields) ? $this -> find($array_fields) : $this -> all()).$this -> limit($offset, $count);
        }
        
        public function findOrderByLimit($type_sort, $field_sort, $offset, $count, $array_fields = ["*"]){
            return $this -> find($array_fields).$this -> orderBy($field_sort,$type_sort).$this -> limit($offset, $count);
        }
        public function countIds(){
            $this -> search_fields = 'COUNT(`id`) AS count';
            return $this -> select();
        }
            
    }

?>

           
       
           
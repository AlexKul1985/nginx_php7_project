<?php
namespace database\select;

use database\QueryBuilder;
use database\AbstractDB;
use \PDO;

class DBSelect extends AbstractDB{

    public function all(){
        return $this -> connect->query(QueryBuilder::select($this -> table_name) -> all())->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findRow($where, $whereValue){
        
        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findRow($where));
        $stmt->execute([$whereValue]);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function findById($id,$nameId = 'id'){
        return $this -> findRow($nameId, $id);

    }

    public function find($array_fields){
        return $this -> connect->query(QueryBuilder::select($this -> table_name) -> find($array_fields))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findJoin($array_fields, $join_params){
        return $this -> connect->query(QueryBuilder::select($this -> table_name) -> findJoin($array_fields, $join_params))->fetchAll(PDO::FETCH_ASSOC);

    }

    
    public function findCol($field){
        return $this -> connect->query(QueryBuilder::select($this -> table_name) -> findCol($field))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWhere( $array_fields, $where, $whereValue){
        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findWhere($array_fields,$where));
        $stmt->execute([$whereValue]);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function nativeSqlRequest($query, $array_value = []){
        if(empty($array_value)){
            return $this -> connect->query($query)->fetchAll(PDO::FETCH_ASSOC);
        }
        $stmt = $this -> connect -> prepare($query);
        $stmt->execute($array_value);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWhereAnd($array_fields,$arrayWhere){
        $whereValue = [];
        for($i = 0; $i < count($arrayWhere); $i++){
            $whereValue[] = array_pop($arrayWhere[$i]);
        }

        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findWhereAnd($array_fields,$arrayWhere));
        
        $stmt->execute($whereValue);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

    }

    public function findJoinWhere($array_fields, $join_params, $where, $seporator, $value){
       
        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findJoinWhere($array_fields, $join_params, $where, $seporator));
        $stmt->execute([$value]);
     
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function findJoinWhereGroupBy($array_fields, $join_params, $where, $seporator,$value, $groupByField){
        
        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findJoinWhereGroupBy($array_fields, $join_params, $where, $seporator,$groupByField));
        $stmt->execute([$value]);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function findJoinWhereAndOrderByLimit($array_fields, $join_params,$arrayWhere,$field_sort,$offset,$count,$type_field = "DESC"){
        
        $whereValue = [];

        foreach($arrayWhere as $value){
            $whereValue[] = array_pop($value);
        }
        // $whereValue[] = $offset;
        // $whereValue[] = $count;
        
        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findJoinWhereAndOrderByLimit($array_fields, $join_params,$arrayWhere,$field_sort,$type_field,$offset,$count));
        
        $stmt->execute($whereValue);
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function findJoinWhereAnd($array_fields, $join_params,$arrayWhere){
        $whereValue = [];
        foreach($arrayWhere as $value){
            $whereValue[] = array_pop($value);
        }

        $stmt = $this -> connect -> prepare(QueryBuilder::select($this -> table_name) -> findJoinWhereAnd($array_fields, $join_params,$arrayWhere));
        
        $stmt->execute($whereValue);
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
        


    public function findLimit($offset, $count, $array_fields = ['*']){
        return $this -> connect -> query(QueryBuilder::select($this -> table_name) -> findLimit($offset, $count, $array_fields))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrderByAsc($field_sort, $array_fields = ['*']){
        return $this -> connect -> query(QueryBuilder::select($this -> table_name) -> findOrderBy('ASC',$field_sort, $array_fields))->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findOrderByDesc($field_sort, $array_fields = ['*']){
        return $this -> connect -> query(QueryBuilder::select($this -> table_name) -> findOrderBy('DESC',$field_sort, $array_fields))->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function findOrderByDescLimit($field_sort, $offset, $count, $array_fields = ["*"]){
        return $this -> connect -> query(QueryBuilder::select($this -> table_name) -> findOrderByLimit('DESC', $field_sort, $offset, $count, $array_fields))->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findOrderByAscLimit($field_sort, $offset, $count, $array_fields = ["*"]){
        return $this -> connect -> query(QueryBuilder::select($this -> table_name) -> findOrderByLimit('ASC', $field_sort, $offset, $count, $array_fields))->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function countIds(){
        return $this -> connect->query(QueryBuilder::select($this -> table_name) -> countIds())->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
    }
    
}

?>
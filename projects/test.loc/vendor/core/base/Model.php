<?php
namespace core\base;

use database\DB;

class Model{

   protected static $table_name = "";
    
   public function __construct(){
        if(empty(static::$table_name)){
            static::$table_name = lcfirst(str_replace('models\\','',get_called_class()))."s";
        }
   }
   public static function setTableName($table_name){
    static::$table_name = $table_name;
   }
   
   public static function all(){
       return DB::select(static::$table_name) -> all();
   }

   public static function find($array_fields){
    return DB::select(static::$table_name) -> find($array_fields);
   }

   public static function findLimit($offset, $count, $array_fields = ["*"] ){
        return DB::select(static::$table_name) -> findLimit($offset,$count, $array_fields);
   }

   public function removeById($id){
        return DB::delete(static::$table_name) -> removeById($id);
   }

   public function remove($field, $value){
    return DB::delete(static::$table_name) -> remove($field, $value);
   }

   public function addAssocValues($assoc_array){
       return DB::insert(static::$table_name) -> addAssocValues($assoc_array);
   }

        
}
       

        
    
    
    


?>
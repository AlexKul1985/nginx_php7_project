<?php
namespace core\lib;

class URI {

    private $pathString = "";
    
    private $params = [];
    private $query = [];
    private $uri = "";

    public function __construct(){
        $this -> init();
    }

    public function init(){
        $this -> uri = $_SERVER['REQUEST_URI'];
        $this -> parse();
    }
    public function setParams($params){
        $this -> params = $params;
    }
    public function getParams(){
        return $this -> params;
    }


    private function parse(){
        if(($pos = strpos($this -> uri,"?")) !== false){
            $arrURI = explode("?",$this -> uri);
            $this -> pathString = $arrURI[0];
            $this -> query = $this ->  parseQuery($arrURI[1]);
            return;
        }
        $this -> pathString = $this -> uri;
    }

    public function getPath(){
        return $this -> pathString;
    }
    public function getPathArray(){
        return explode("/",trim($this -> pathString,"/"));
    }

    private function parseQuery($query){
        if(strpos($query,"&") !== false){
            return $this -> scanQuery($query);
            
        }
        else if($pos = strpos($query,"=") !== false){
            $paramsArr = explode("=",$query);
            return [$paramsArr[0] => $paramsArr[1]];
        }
    }
        
    private function scanQuery($query){
        $arr  = [];
        $arrQueryParams = explode("&",$query);
        array_walk($arrQueryParams,function($el_str) use(&$arr){
            $params = explode("=",$el_str);
            $arr[$params[0]] = $params[1];
        });
        return $arr;
    }

    public function getQuery(){
        return $this -> query;
    }

}
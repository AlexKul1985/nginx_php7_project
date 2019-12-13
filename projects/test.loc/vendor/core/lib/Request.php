<?php

    namespace core\lib;

    class Request {

        
        private static  $data = [];
        public static $headers = [];

        
        public function __construct(){
            self::initHeaders();
            $data = [];
        //    try{
               if($this -> getMethod() !== "GET" && isset(self::$headers["Content-Type"])){
                   $input = file_get_contents('php://input');
                   if(strpos(self::$headers["Content-Type"], "application/json") !== false){
                    $data = json_decode($input, true);
                }
                
                else if(strpos(self::$headers["Content-Type"], "application/x-www-form-urlencoded") !== false){
                    $data = $this -> generateRequestData($input);
                    
                }
                else if(strpos(self::$headers["Content-Type"], "multipart/form-data") !== false){
                    // $data = $this -> generateRequestData($input);
                    // $data = json_decode($input, JSON_THROW_ON_ERROR);
                    $data = ['test' => 'Test'];

                    }
                    else{
                        // throw new \Exception('No correct Content-Type');
                    }
                       
                    
                    self::$data = array_merge(self::$data, self::xss($data));

                }
                    
                    
            
        //    } catch (\Exception  $e){
            
        //         throw $e;
        //    }
        }

        private static function initHeaders(){
           $prefix = "HTTP_";
           $server = $_SERVER; 
           foreach ($server as $key => $value) {
               if(strpos($key,$prefix) !== false ){
                   $headerName = self::convertToCameCase(substr($key,strlen($prefix)));
                   self::$headers[$headerName] = $value;
                }

            }
               
        }

        
        private static function convertToCameCase($headerName){
            return strpos($headerName,"_") !== false ? 
                implode("-",array_map([self::class,'stringLowerCaseAndUpperCase'],explode("_",$headerName))) :
                     self::stringLowerCaseAndUpperCase($headerName);

        }
        private static function stringLowerCaseAndUpperCase($el){
            return ucfirst(strtolower($el));
        }

        private function generateRequestData(string $data){
            $resArr = [];
            if(strpos($data,"&") !== false){
                $arrayData = explode("&",$data);
                for($i = 0; $i < count($arrayData); $i++){
                    $d = explode("=",$arrayData[$i]);
                    $resArr[$d[0]] = $d[1];
                }
            }
            else{
                $d = explode("=",$data);
                $resArr[$d[0]] = $d[1];
            }
            return $resArr;
        }
            


        public static function addData(array $additionalData){
            self::$data = array_merge(self::$data, self::xss($additionalData));
        }


        private static function xss($data){
            if(env('XSS_FLAG') == '1'){
                if (is_array($data)) {
                    $escaped = array();
                    foreach ($data as $key => $value) {
                        $escaped[$key] = self::xss($value);
                    }
                    return $escaped;
                }
                return trim(htmlspecialchars($data));
            }
            return $data;
            
            
        }
        
        public function getMethod(){
            return $_SERVER['REQUEST_METHOD'];
        }

        public function __get($key){
            if(array_key_exists($key,self::$data)){
                return self::$data[$key];
            }
            else{
                // throw new Exception("Нет такого свойства");
                return false;
            }
        }
    }
?>
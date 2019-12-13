<?php
     namespace core\lib;
    class Response {

        private static $sendHeadersArray = [];

        public function sendJson(array $data){
            echo json_encode($data);
        }

        
        
        
        public function setHeaders(array $headers){
            
            while ( true ) {
                $key = key($headers);
                if(null !== $key){
                    header($key.":".current($headers));
                    
                    next($headers);
                    if(null == key($headers)){
                        break;
                    }
                    
                }
            }
            
        }

        
                    
                
           
            
    }
                
                
              
             


?>
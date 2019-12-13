<?php
    namespace core\lib;

    class Router{
        
        private static $routes = [];
        private static $route = [];
        private static $routeHandlers = [];
        public static $uri = null;
        
        
     
        public static function toEvent($path,$callback){
            
            
            $getNameParams = function() use(&$path){
                $paramsName = [];
                if( strpos($path,":") !== false){
                    
                    $arr = explode("/",$path);
                    
                    foreach ($arr as $value) {
                        
                        if(($pos = strpos($value,":")) !== false){
                            $name = trim(substr($value, $pos + 1),'/?');
                            $paramsName[] = $name;
                        }
                    }
                }
                
                return $paramsName;
            };

            self::$routeHandlers[self::convertToRegExp($path)] = [$callback, $getNameParams];
        }
            

        public static function run(){
           self::$uri = new URI;
        //    debug(self::$uri -> getQuery());
        //    debug(self::$uri -> getPathArray());
           foreach (self::$routeHandlers as $pathRegExp => [$callback, $getNameParams]) {
               if(preg_match('~'.$pathRegExp.'~', self::$uri -> getPath(), $matches)){
                 
                   $countMatches = count($matches);
                   $params = array_slice($matches, $countMatches - ($countMatches - 1));

                   $paramsName = $getNameParams();
                   $countParamsName = count($paramsName);
                   $countParams = count($params);

                   if(count($paramsName) > 0){
                       $paramsName = array_slice($paramsName, 0, count($params));
                       self::$uri -> setParams(array_combine($paramsName,$params));
                    }
                   

                   if(is_string($callback)){
                       if(strpos($callback,'@') !== false && substr_count($callback,'@') == 1) {
                            [$nameController, $nameAction] = explode('@',$callback);
                            $request = new Request();
                            $response = new Response();
                            (new $nameController([])) -> $nameAction($request,$response,...$params);
                       } 
                       else{
                           throw new Exception('Should be Controller@action!');
                       }
                   }
                   else if(is_callable($callback)){
                     
                     $callback(...$params);
                   }
               
                   break;
                }
            }
            
           
        }




        public static function convertToRegExp($path){
            
            $path = "^".str_replace("/","\/?",$path);
            $pos = 0;
            $posSlash = 0;
            $offset = 0;
            $replacment = '([a-zA-Z0-9\_-]+)';

            for($i = 0; $i < strlen($path); $i++){
                $pos = strpos($path,":",$offset);
                if($pos === false) break;
                $posSlash = strpos($path,"\\",$pos);
                $end = ($posSlash !== false) ? $posSlash - $pos : strlen($path);
                $param = substr($path, $pos, $end);
                $rep = strpos($param,"?") !== false ? $replacment.'?' : $replacment;
                $len = ($posSlash !== false) ? $posSlash - $pos : strlen($path);
                $path = substr_replace($path,$rep,$pos,$len);
                $offset = $posSlash + 1;
            }

                

            return $path."\/?$";
        }




        public static function add($pattern,$route = []){
            self::$routes[$pattern] = $route;
        }

        public static function dispatch(){
            $url = $_SERVER["REQUEST_URI"];
            if(self::match($url)){
               
                $controller = ucfirst(self::$route["controller"])."Controller";
                
                $controller = "controllers\\".self::$route["prefix"]."".$controller;
               
                if(class_exists($controller)){
                    
                    $object = new $controller( self::$route);
                    $ucAction = ucfirst(self::$route["action"]);
                    $action = "action".$ucAction;
                    
                    if(method_exists($object, $action)){
                        
                        $ucAction = strpos($ucAction,'s',strlen($ucAction) - 2) ? substr($ucAction,0,-1) : $ucAction;
                        // $model = "models\\".$ucAction;
                        // if(class_exists($model)){
                        //     new $model;
                        // }
                        Request::addData([
                            'time' => time()
                        ]);
                        $request = new Request();
                        $response = new Response();
                        $object -> $action($request, $response);
                    }
                }
            }
            else{
                echo "NO".PHP_EOL;
            }

        }

        
        private static function match($url){
          
            $url = rtrim(self::removeQueryString($url),"/");
           
           
            if(!empty(self::$routes)){
                
                foreach (self::$routes as $pattern => $route) {
                  
                  
                    if(preg_match("/{$pattern}/i",$url,$match)){
                        
                        //debug($match);
                        $controller = "main";
                        $action = "index";
                        $prefix = "";
                        if(isset($route["controller"])){
                            $controller = $route["controller"];
                        }
                        else if(isset($match[1])){
                            $controller = $match[1];
                        }
                        
                        
                        $route["controller"] = $controller;
                        
                        if(isset($route["action"])){
                            $action = $route["action"];
                        }
                        else if(isset($match[2])){
                            $action = $match[2];
                        }

                       
                        $route["action"] = $action;

                        if(isset($route['prefix'])){
                            $prefix .= "\\";
                        }

                        $route["prefix"] = $prefix;

                        
                        
                        
                        
                        self::$route = $route;
                        
                        return true;
                    }
                    

                    
                }
                
            }
            return false;

        }
        private static function removeQueryString($url){

            $arr = explode("/",$url,2);
            if(($pos = strpos($arr[1],"?",0)) === false){
                
                return $url;
            }
            
            $url = substr($url,0,$pos+1);
            
            return $url;
        }

        
            
        




    }

?>
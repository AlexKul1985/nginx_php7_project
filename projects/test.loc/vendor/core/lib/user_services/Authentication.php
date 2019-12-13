<?php
namespace user_services;
    class Authentication{

        const SECRET_KEY = "asd879f87ds9fasd}saasd";

        private static $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        private static $payload = ['exp' => 0];
        private static $timeExpAT = 3600*24; 
        private static $timeExpRT = 3600*24*30; 
        
        public function __construct(){}

        public static function setExpireAT($time){
            self::$timeExpAT = $time;
        }

        public static function setExpireRT($time){
            self::$timeExpRT = $time;
        }

        public static function getExpireAT(){
            return self::$payload['exp'];
        }

        public static function setPayload($payload){
            
            if(is_array($payload)){
                self::$payload = array_merge(self::$payload, $payload);
                self::$payload['exp'] = time() + self::$timeExpAT;
            }


        }
        // public static function test(){
        //     return hash('sha256', base64_encode(serialize(self::$header)).".".base64_encode(serialize(self::$payload)).".".self::SECRET_KEY);
        // }
        public static function unserializeData($header, $payload){
            return [unserialize(base64_decode($header)), unserialize(base64_decode($payload))];
        } 
            
        
        public static function signature($header = null, $payload = null, $secret_key = null){
            if(is_null($payload) && is_null($header)){
                $payload = self::$payload;
                $header = self::$header;
            }
            if(is_null($secret_key)){
                $secret_key = self::SECRET_KEY;
            }
            return hash_hmac('sha256',base64_encode(serialize($header)).".".base64_encode(serialize($payload)),$secret_key,true); 
                
        }

                
            
            
                
        
        public static function getAccessToken(){
                self::$payload['exp'] = (time() + self::$timeExpAT);    
                return base64_encode(serialize(self::$header)).".".base64_encode(serialize(self::$payload)).".".base64_encode(self::signature());
        }

        public static function getRefreshToken($id_user){
            $payload = [
                "userId" => $id_user,
                "exp" => (time() + self::$timeExpRT)
            ];
            $secret_key = self::getKey();
            return base64_encode(serialize($payload)).".".base64_encode(self::signature($payload, $secret_key));
        }

        private static function getKey(){
            $str = "";
            $end = mt_rand(3,20);
            for($i = 0; $i < $end; $i++){
                $str .= mt_rand(1,1000);
            }
            return md5($str);
                
        }

    }

?>
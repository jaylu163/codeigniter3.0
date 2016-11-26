<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 17:02
 */

 class Base_Interface  {

        public static  $curl;

        public static $baseController ;
        public static $load;

        public static $dbInstance ;

        const TABLE = 'curl_api_logs';

        public static $status=array(
             'status' =>'no url',
             'code'   =>500,
             'data'   =>array()
         );

        public function __construct(){

            self::$load = load_class('Loader','core');
            static::$dbInstance =self::$load->database('log',true);
        }

        protected static function micTime(){

            list($usec, $sec) = explode(" ", microtime());
            return ((float)$usec + (float)$sec);
        }
     /**
      * 调用baseController get方法
      * @param $url
      * @param array $params
      * @return array
      */
        public static function curlGet($url,$params=array()){
            if(empty($url)){
                return self::$status;
            }
            $startTime =self::micTime();
            $result = self::$baseController->httpCurlGet($url,$params);
            $endTime = self::micTime();
            $sysTime = round(($endTime - $startTime),3);

            self::writeDBLog($url,$params,'get',$sysTime);

            return $result;
        }

     /**
      * 调用baseController post方法请求
      * @param $url
      * @param array $params
      * @return array
      */
        public static function curlPost($url,$params=array()){
            if(empty($url)){
                return self::$status;
            }

            $startTime = self::micTime();
            $result  = self::$baseController->httpCurlPost($url,$params);
            $endTime = self::micTime();
            $sysTime = round(($endTime - $startTime),3);
            self::writeDBLog($url,$params,'get',$sysTime);

            return $result;
        }

     /**
      * 调用libaries库curl请求
      * @param $url
      * @param array $params
      * @param string $method
      * @return array|bool|mixed|string
      */
        public static function libCurl($url,$params=array(),$method= 'get'){
            if(empty($url)){
                return self::$status;
            }

            $fileCurl = APPPATH.'libraries/Curl.php';
            if(file_exists($fileCurl)){
                include(APPPATH.'libraries/Curl.php');
                self::$curl = new Curl();
            }
            $startTime = self::micTime();
            $result = self::$curl->_simple_call($method,$url,array());
            $endTime = self::micTime();
            $sysTime = round(($endTime - $startTime),3);
            self::writeDBLog($url,$params,$method,$sysTime);

            return $result;
        }

     /**
      * 记录数据库日志
      * @param $url
      * @param $params
      * @param string $method
      * @param $time
      * @return mixed
      */
        protected static function  writeDBLog($url,$params,$method= 'get',$time){
            $params =json_encode($params);

            $data = array(
                'url' => $url,
                'params' => $params,
                'remote_ip' => $_SERVER['REMOTE_ADDR'],
                'method'    => $method,
                'total_time'=> $time,
                'create_time'=> date('Y-m-d H:i:s'),
                'update_time'=> date('Y-m-d H:i:s')
            );

            $result =static::$dbInstance->insert(self::TABLE,$data);
            return $result;
        }

     /**
      * 记录文件cache
      * @param $url
      * @param $params
      * @param string $method
      * @param $time
      * @return mixed
      */
        protected static function writeCacheLog($url,$params,$method= 'get',$time){

            $data = array(
                'url' => $url,
                'params' => $params,
                'remote_ip' => $_SERVER['REMOTE_ADDR'],
                'method'    => $method,
                'total_time'=> $time,
                'create_time'=> date('Y-m-d H:i:s'),
                'update_time'=> date('Y-m-d H:i:s')
            );
            $data = json_encode($data);
            $redis = new Redis();
            $result =$redis ->lpush('keys',$data);
            return $result;
        }


 }
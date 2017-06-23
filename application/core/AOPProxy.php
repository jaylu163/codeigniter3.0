<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2017/5/26
 * Time: 11:35
 */


class AOPProxy {

    public static $appInstance ;

    public static $httpUrl;
    public static $httpParams;
    public static $httpResponse;

    public  function __construct($instance){
        self::$appInstance= $instance;

    }

    public function __call($method, $arguments){

        if(! method_exists(self::$appInstance,$method)){
            throw  new Exception('Call undefinded method '.get_class(self::$appInstance).'->'.$method);
        }
        self::before($method, $arguments);

        $result = call_user_func_array(array(self::$appInstance,$method),$arguments);
        $className =get_class(self::$appInstance);
        self::after($className,$method, $arguments);
        return $result;
    }

    public static function __callStatic($method, $arguments){

        if(method_exists(self::$appInstance,$method) != true){
            throw  new Exception('Call undefinded method '.get_class(self::$appInstance).'::'.$method);
        }

        //var_dump($method,$arguments);die;
        self::before($method, $arguments);
        $className =get_class(self::$appInstance);
        $result = call_user_func_array(array(self::$appInstance,$method),$arguments);
        //var_dump('__callStatic');
        self::after($className,$method, $arguments);
        return $result;
    }

    public static function before($method, $arguments){

        // getTranceId();
        if(isset($GLOBALS[TRANCEID])){
            $GLOBALS[TRANCEID] = $GLOBALS[TRANCEID].'.1';
        }

        if(is_array($arguments)){
            $dataSize =mb_strlen(json_encode($arguments),'utf-8');
        }else{
            $dataSize =mb_strlen($arguments,'utf-8');
        }
        $tranceId   = TRANCEID;
        $remoteIp   = $_SERVER['REMOTE_ADDR'];
        $accessTime = self::micTime();
        $handleIP   = $_SERVER['SERVER_ADDR'];
        $serverNamespace = get_class(self::$appInstance);
        $serverMethod = $method;

        // datasize
        $dataType = 1 ;// 响应为2
        $accessCode = '';
        $httpMethod ='';
        $httpUrl    = self::$httpUrl? self::$httpUrl:'';
        $httpParams = is_array(self::$httpParams)? json_encode(self::$httpParams):self::$httpParams;
        $httpResponse = self::$httpResponse? self::$httpResponse:'';
        $userId       ='';
        $version      ='';
        if($httpUrl){
            $httpMethod = $method;
        }
        $startMes =  TRANCEID.'|'.$GLOBALS[TRANCEID].'|'.$remoteIp.'|'.$accessTime.'|'.$handleIP.'|'.$serverNamespace.'|'.$serverMethod.'|'.$dataSize.'|'.$dataType.'|'.$accessCode.'|'.$httpMethod.'|'.$httpUrl.'|'.$httpParams.'|'.$httpResponse.'|'.$userId.'|'.$version.'|';

        Monolog::logWrite($startMes);

    }

    public static function after($className,$method, $arguments){

        if(isset($GLOBALS[TRANCEID])){

            if( !in_array($method,array('httpCurlPost','httpCurlGet'))){

                $GLOBALS[TRANCEID] = substr($GLOBALS[TRANCEID],0,-2);
            }

        }

        //
        if(is_array($arguments)){
            $dataSize =mb_strlen(json_encode($arguments),'utf-8');
        }else{
            $dataSize =mb_strlen($arguments,'utf-8');
        }
        $tranceId   = TRANCEID;
        $remoteIp   = $_SERVER['REMOTE_ADDR'];
        $accessTime = self::micTime();
        $handleIP   = $_SERVER['SERVER_ADDR'];
        $serverNamespace = $className;
        $serverMethod = $method;
        // datasize
        $dataType = 2 ;// 响应为2

        $accessCode = '';
        $httpMethod =$method;
        $httpUrl    = self::$httpUrl? self::$httpUrl:'';
        $httpParams = is_array(self::$httpParams)? json_encode(self::$httpParams):self::$httpParams;
        $httpResponse = self::$httpResponse? self::$httpResponse:'';
        $userId       ='';
        $version      ='';

       // log_message('debug','httpResponse-------------'.json_encode(self::$httpResponse));
        $endMes =  TRANCEID.'|'.$GLOBALS[TRANCEID].'|'.$remoteIp.'|'.$accessTime.'|'.$handleIP.'|'.$serverNamespace.'|'.$serverMethod.'|'.$dataSize.'|'.$dataType.'|'.$accessCode.'|'.$httpMethod.'|'.$httpUrl.'|'.$httpParams.'|'.$httpResponse.'|'.$userId.'|'.$version.'|';

        Monolog::logWrite($endMes);

    }

    protected static function micTime(){

        list($usec, $sec) = explode(" ", microtime());
        return (float)sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000);
    }
}


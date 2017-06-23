<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 17:02
 */

class Base_Interface  {

    public static $curl;

    public static $baseController ;
    public static $load;

    public static $dbInstance ;
    public static $appInstance;

    public static $status=array(
        'status' =>'no url',
        'code'   =>500,
        'data'   =>array()
    );

    protected static $redis ;

    public function __construct(){

        self::$load = load_class('Loader','core');

    }

    public static function __callStatic($method, $arguments){

        if(method_exists(get_called_class(),$method) != true){
            throw  new Exception('Call undefinded method '.get_called_class().'::'.$method);
        }

        self::before($method, $arguments);
        $result = call_user_func_array(array(get_called_class(),$method),$arguments);

        self::after($method, $arguments);
        return $result;
    }

    protected static function before($method, $arguments){

        if(isset($GLOBALS[TRANCEID])){
            $GLOBALS[TRANCEID] = $GLOBALS[TRANCEID].'.1';
        }

        if(is_array($arguments)){
            $dataSize =mb_strlen(json_encode($arguments),'utf-8');
        }else{
            $dataSize =mb_strlen($arguments,'utf-8');
        }

        $remoteIp   = $_SERVER['REMOTE_ADDR'];
        $accessTime = self::micTime();
        $handleIP   = $_SERVER['SERVER_ADDR'];
        $serverNamespace = get_class(self::$appInstance);
        $serverMethod = $method;
        // datasize
        $dataType   = 1 ;// 响应为2
        $accessCode = 200;
        $httpMethod = $method;
        $httpUrl    = $_SERVER['SERVER_NAME'];
        $httpParams = json_encode($arguments);
        $httpResponse ='';
        $userId       ='';
        $version      ='';

        $startMes =  TRANCEID.'|'.$GLOBALS[TRANCEID].'|'.$remoteIp.'|'.$accessTime.'|'.$handleIP.'|'.$serverNamespace.'|'.$serverMethod.'|'.$dataSize.'|'.$dataType.'|'.$accessCode.'|'.$httpMethod.'|'.$httpUrl.'|'.$httpParams.'|'.$httpResponse.'|'.$userId.'|'.$version.'|';

        Monolog::logWrite($startMes);

    }

    protected static function after($method, $arguments){

        if( !in_array($method,array('httpCurlPost','httpCurlGet'))){

            $GLOBALS[TRANCEID] = substr($GLOBALS[TRANCEID],0,-2);

        }

        if(is_array($arguments)){
            $dataSize =mb_strlen(json_encode($arguments),'utf-8');
        }else{
            $dataSize =mb_strlen($arguments,'utf-8');
        }

        $remoteIp   = $_SERVER['REMOTE_ADDR'];
        $accessTime = self::micTime();
        $handleIP   = $_SERVER['SERVER_ADDR'];
        $serverNamespace = get_class(static::$appInstance);
        $serverMethod = $method;
        // datasize
        $dataType = 2 ;// 响应为2
        $accessCode = 200;
        $httpMethod = $method;
        $httpUrl    = $_SERVER['SERVER_NAME'];
        $httpParams = json_encode($arguments);
        $userId       ='';
        $version      ='';

        $endMes =  TRANCEID.'|'.$GLOBALS[TRANCEID].'|'.$remoteIp.'|'.$accessTime.'|'.$handleIP.'|'.$serverNamespace.'|'.$serverMethod.'|'.$dataSize.'|'.$dataType.'|'.$accessCode.'|'.$httpMethod.'|'.$httpUrl.'|'.$httpParams.'|'.$httpResponse.'|'.$userId.'|'.$version.'|';

        Monolog::logWrite($endMes);

    }


    protected static function micTime(){

        list($usec, $sec) = explode(" ", microtime());
        return (float)sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000);
    }
    /**
     * 调用baseController get方法
     * @param $url
     * @param array $params
     * @return array
     */
    private static function curlGet($url,$params=array(),$connectTimeout=5,$curlTimeout=20){
        if(empty($url)){
            return self::$status;
        }
        $proxy = new AOPProxy(new self::$baseController());
        $proxy::$httpUrl    = $url;
        $proxy::$httpParams = $params;
        $result  = $proxy->httpCurlGet($url,$params,$connectTimeout,$curlTimeout);
        //$startTime =self::micTime();
        //$result = self::$baseController->httpCurlGet($url,$params,$connectTimeout,$curlTimeout);
        //$endTime = self::micTime();
        //$sysTime = round(($endTime - $startTime),3);
        //self::setLogMessage($url,$params,$result,'get',$sysTime);
        $proxy::$httpResponse = $result;

        return $result;
    }

    /**
     * 调用baseController post方法请求
     * @param $url
     * @param array $params
     * @return array
     */
    private static function curlPost($url,$params=array(),$connectTimeout=5,$curlTimeout=20){
        if(empty($url)){
            return self::$status;
        }

       // $startTime = self::micTime();
        $proxy = new AOPProxy(new self::$baseController());
        $proxy::$httpUrl    = $url;
        $proxy::$httpParams = $params;

        //var_dump(new self::$baseController());die;
        $result  = $proxy->httpCurlPost($url,$params,$connectTimeout,$curlTimeout);
       // $endTime = self::micTime();
       // $sysTime = round(($endTime - $startTime),3);
       // self::setLogMessage($url,$params,$result,'post',$sysTime);

        $proxy::$httpResponse = $result;

        return $result;
    }

    /**
     * 调用libaries库curl请求
     * @param $url
     * @param array $params
     * @param string $method
     * @return array|bool|mixed|string
     */
    private static function libCurl($url,$params=array(),$method= 'get'){
        if(empty($url)){
            return self::$status;
        }

        $fileCurl = APPPATH.'libraries/Curl.php';
        if(file_exists($fileCurl)){
            include(APPPATH.'libraries/Curl.php');
            self::$curl = new Curl();
        }
        $startTime = self::micTime();
        $result = self::$curl->_simple_call($method,$url,$params);
        $endTime = self::micTime();
        $sysTime = round(($endTime - $startTime),3);

        self::setLogMessage($url,$params,$result,$method,$sysTime);

        return $result;
    }

    /**
     * @param $url
     * @param $params
     * @param $result
     * @param $method
     * @param $sysTime
     */
    protected static function setLogMessage($url,$params,$result,$method,$sysTime){

        //self::fscokPost($url,$params,$result,$method,$sysTime);
 /*       log_message('debug',TRANCEID.'|request_url:' . $url);
        log_message('debug',TRANCEID.'|params :' . var_export($params, true));
        log_message('debug',TRANCEID.'|method:' . $method);
        log_message('debug',TRANCEID.'|response ' . var_export($result, true));
        log_message('debug',TRANCEID.'|response_time:' .$sysTime);*/
    }

    public static function fscokPost($url,$params,$result,$method,$sysTime){
        $serverHost= config_item('server_host');
        $fscockUrl = $serverHost.'/demo/fwriteLog';
        $urlInfo = parse_url($fscockUrl);
        $host = $urlInfo['host'];
        $path = $urlInfo['path'];
        $port = 80;
        $errno = '';
        $errstr = '';
        $timeout = 30;
        $params =json_encode($params);
        if(is_null(json_decode($result)) !=false){
            $result =json_encode($result);
        }

        $data = array(
            'url'    =>$url,
            'params' =>$params,
            'result' =>$result,
            'method' =>$method,
            'systime'=>$sysTime,
            'request_uid'=>STATIC_HTTP_UUID
        );

        $data = http_build_query($data);
        // create connect
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);

        if(!$fp){
            return false;
        }

        // send request
        $out  = "POST ${path} HTTP/1.1\r\n";
        $out .= "Host:${host}\r\n";
        $out .= "Content-type:application/x-www-form-urlencoded\r\n";
        $out .= "Content-length:".strlen($data)."\r\n";
        $out .= "Connection:close\r\n\r\n";
        $out .= "${data}";

        fwrite($fp, $out);
        usleep(20000); //fwrite之后马上执行fclose，nginx会直接返回499

        fclose($fp);
    }

    public static function fscokGet($url,$params,$result,$method,$sysTime){
        $serverHost= config_item('server_host');
        $fscockUrl = $serverHost.'/demo/fwriteLog';
        $urlinfo   = parse_url($fscockUrl);
        $host      = $urlinfo['host'];
        //$path = $urlinfo['path'];
        $port = 80;
        $errno = '';
        $errstr = '';
        $timeout = 30;

        $params =json_encode($params);
        if(is_null(json_decode($result)) !=false){
            $result =json_encode($result);
        }

        $data = array(
            'url'    =>$url,
            'params' =>$params,
            'result' =>$result,
            'method' =>$method,
            'systime'=>$sysTime,
            'request_uid'=>STATIC_HTTP_UUID
        );

        $fscockUrl = $fscockUrl.'?'.http_build_query($data);
        // create connect
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);

        if(!$fp){
            return false;
        }

        // send request
        $out  = "GET " . $fscockUrl . " HTTP/1.1\r\n";
        $out .= "Host:${host}\r\n";
        $out .= "Connection:close\r\n\r\n";

        fwrite($fp, $out);

           if(false){
                $ret = '';
                while (!feof($fp)) {
                    $ret .= fgets($fp, 128);
                }
            }

        usleep(20000); //fwrite之后马上执行fclose，nginx会直接返回499
        fclose($fp);
    }


    /**
     * 记录数据库日志
     * @param $url
     * @param $params
     * @param string $method
     * @param $time
     * @return mixed
     */
    protected static function  writeDBLog($url,$params,$result,$method= 'get',$time){
        $params =json_encode($params);

        if(is_null(json_decode($result)) !=false){
            $result =json_encode($result);
        }

        $data = array(
            'url' => $url,
            'params' => $params,
            'remote_ip' => $_SERVER['REMOTE_ADDR'],
            'method'    => $method,
            'response'  => $result,
            'total_time'=> $time,
            'create_time'=> date('Y-m-d H:i:s'),
            'update_time'=> date('Y-m-d H:i:s')
        );

        if(static::$dbInstance){

            $tables =static::$dbInstance->list_tables();

            if(in_array(static::$table,$tables)){
                $result =static::$dbInstance->insert(static::$table,$data);
                return $result;
            }
            return array();
        }
        return array();

    }

    /**
     * 记录文件cache
     * @param $url
     * @param $params
     * @param string $method
     * @param $time
     * @return mixed
     */
    protected static function writeCacheLog($url,$params,$result,$method= 'get',$time){

        $data = array(
            'url' => $url,
            'params' => json_encode($params),
            'remote_ip' => $_SERVER['REMOTE_ADDR'],
            'method'    => $method,
            'response'    =>$result,
            'total_time'=> $time,
            'create_time'=> date('Y-m-d H:i:s'),
            'update_time'=> date('Y-m-d H:i:s')
        );
        $data = json_encode($data);

        $result =static::$redis ->lPush(static::$table,$data);

        return $result;
    }

    protected static function loadRedis(){

        $redis = new Redis();
        static::$load->config(ENVIRONMENT.'/redis');
        $config=get_instance()->config->config;

        $db   =  $config['redisdb'];
        $host =  $config['redishost'];
        $port =  $config['redisport'];
        $auth =  $config['redisauth'];
        $timeout = $config['redistimeout'];
        $redis->connect($host,$port,$timeout);
        $redis->auth($auth);
        $redis->select($db);
        return $redis;

    }

}
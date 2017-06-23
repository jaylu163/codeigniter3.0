<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 10:24
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    protected $model;
    public  $baseHelper;      // 基础助手
    public  $baseInterface;   // 基础接口

    public function __construct(){

        parent::__construct();
        self::loadLogicClassName('Base_Interface','core');  //加载interface 类
        Base_Interface::$baseController = $this;
        self::loadLogicClassName('AOPProxy','core');  //加载interface 类

    }

    public function __destruct(){

         $this->setLog();

    }

    protected function isLoaded(){

        $loaded = is_loaded();
        if(in_array('Base_Interface',$loaded)){
            self::loadInterface('Curl','libraries');
            Base_Interface::$curl         = new Curl();
        }
    }
    /**
     * 加载助手基类
     * @return Base_comhelper
     */
     public function getBaseHelper(){

         self::loadLogicClassName('Base_comhelper','core');
         $helperInstance = new Base_comhelper();
         return $helperInstance;

     }


    /**
     * 返回代理类
     * @param $instance
     * @return AOPProxy
     */
     public function proxy($instance){

         return new AOPProxy($instance);
     }

     public  function setLog($name='Base_Logprofiles',$segment='writeLog'){

        self::loadLogicClassName('Base_Logprofiles','core');
        $logprofiles = new Base_Logprofiles();

        return   call_user_func_array(array($logprofiles,'writeLog'),array('INFO'));
     }


     /**
     * 找不到视图会报错
     * @param string $page
     */
     public function view($page = 'home',$data){
        if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
     }

    /**
     * 加载单个文件
     * @param $class  【类名】
     * @param string $directory 【应用程序目录名】
     */
    public static function loadLogicClassName($class ,$directory='logic'){

        $path = str_replace('\\', '/', APPPATH);

        if (file_exists($path.$directory.'/'.$class.'.php')){

            if (class_exists($class, FALSE) === false) {
                require_once($path . $directory .'/'. $class . '.php');
            }
        }

    }



    /**
     * 加载一个实例
     * @param $class
     * @param string $directory
     * @return mixed
     */
    public  function loadInterface($class ,$directory='interface'){

        self::loadLogicClassName($class,$directory);
        $instance = self::getInstance($class,$directory);
        //$instance = self::setCurl($instance,true);
        return $instance;
    }

    /**
     * 给一个实例添加curl和BaseController属性
     * @param $instance
     * @param bool $object
     * @return mixed
     */
    protected  function setCurl($instance,$object =true){
        $this->load->library('Curl');
        if($object){
            $instance::$curl = $this->curl;
            $instance::$baseController =$this;
        }else{
            $instance->curl = $this->curl;
            $instance->baseController = $this;
        }

        return $instance;
    }


    protected  function getInstance($class ,$object=true){
        if($object){
            $instance = new $class();
        }else{
            $instance = $class;
        }

        return $instance;

    }
    /**
     * 返回网页头描述信息
     * @param string $title  [网页标题]
     * @param string $content [网页内容]
     * @param string $description[网页描述]
     */
    public function head($title='',$content='',$description=''){

        $data = array(
            'title'=>$title,
            'content' =>$content,
            'description' =>$description
        );
        $this->load->view('head',$data);
    }

    /**
     * json 格式化输出
     * @param array $array
     */
    public function jsonFormat($code,$data =array(),$msg =''){

        try{
            if(is_array($data) ==false){
                 throw new Exception('不是一个合法的数组');
            }
            $array = array(
                'code' => $code,
                'data' => $data,
                'msg'  => $msg
            );

            $result =$this->output->set_content_type('application/json')->set_output(json_encode($array));

        }catch (Exception $exception){

            die($exception->getMessage());
        }

    }

    /**
     * @param string $json
     */
    public function jsonToArray($json=''){
        try{

          return   json_decode($json,true);

        }catch (Exception $exception){

            die($exception->getMessage());
        }
    }

    /**
     * 设置头消息
     */
    public function setHeader(){

        $this->output->set_header('HTTP/1.0 200 OK');
        $this->output->set_header('HTTP/1.1 200 OK');
        //$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

    }




    /**
     * @param $url [请求远程的地址]
     * @param $params[请求参数]
     * @param int $connectTimeout[请求远程连接时长]
     * @param int $curlTimeout[请求执行时间长]
     * @return mixed [返回结果]
     */
    public function httpCurlGet($url,$params=array(),$connectTimeout=30,$curlTimeout=60){
        if(empty($url)){
            throw new Exception('url empty');
        }
        $queryStr =http_build_query($params);
        $url = $queryStr ? $url.'?'.$queryStr : $url;

        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$connectTimeout);
        curl_setopt($ch,CURLOPT_TIMEOUT,$curlTimeout);
        $result = curl_exec($ch);
        // 失败重试一次
        $httpCode =curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // 失败重试一次
        if ($httpCode !== 200) {
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            return array(
                'code' =>$httpCode,
                'data' =>$result,
                'msg'  =>$info
            );
        }

        if($result === false){
            $error = curl_error($ch);
            $result=array(
                'Curl error'=>$error,
                'code'=>$httpCode,
                'msg'=>'服务器异常'
            );
            //throw new Exception('Curl error: ' .$error);
        }

        curl_close($ch);
        return $result;
    }

    /**
     * @param $url [请求远程服务地址]
     * @param array $params[请求时要传入的参数]
     * @param int $connectTimeout[请求地址]
     * @param int $curlTimeout
     * @return mixed
     */
    public function httpCurlPost($url,$params=array(),$connectTimeout=30,$curlTimeout=60){

        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_HEADER, 0); // 加快效率
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$connectTimeout);
        curl_setopt($ch,CURLOPT_TIMEOUT,$curlTimeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        $result = curl_exec($ch);

        // 失败重试一次
        $httpCode =curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // 失败重试一次
        if ($httpCode !== 200) {
            $result = curl_exec($ch);
            $info   = curl_getinfo($ch);
            return array(
                'code' =>$httpCode,
                'data' =>$result,
                'msg'  =>$info
            );
        }

        if($result === false){
            $error = curl_error($ch);
            $result=array(
                'Curl error'=>$error,
                'code'=>$httpCode,
                'msg'=>'服务器异常'
            );
            //throw new Exception('Curl error: ' .$error);
        }
        curl_close($ch);

        return $result;
    }

    /**
     * 多个服务资源并发处理
     * @param array $params  二维数组 .[$params[['url'=>'','params'=>'']]]
     * @param $method
     * @return array
     */
    protected function httpMutilCurl($params=array(), $method){
        $mh = curl_multi_init();  // 初始化一个curl_multi句柄
        $handles = array();
        foreach($params as $key=>$param){
            $ch   = curl_init();  // 初始化一个curl句柄
            $url  = $param["url"];
            $data = $param["params"];
            if(strtolower($method)==="get"){ //根据method参数判断是post还是get方式提交数据
                $url = $url.'?' . http_build_query( $data );
            }else{
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $data ); //post方式
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_multi_add_handle($mh, $ch);
            $handles[$ch] = $key;
            //handles数组用来记录curl句柄对应的key,供后面使用，以保证返回的数据不乱序。
        }
        $running = 0;
        $curls = array(); //curl数组用来记录各个curl句柄的返回值
        do {  //发起curl请求，并循环等等1/100秒，直到引用参数"$running"为0
            usleep(10000);
            curl_multi_exec($mh, $running);
            while( ( $ret = curl_multi_info_read( $mh ) ) !== false ){
                //循环读取curl返回，并根据其句柄对应的key一起记录到$curls数组中,保证返回的数据不乱序
                $curls[$handles[$ret["handle"]]] = $ret;
            }
        } while ( $running > 0 );

        foreach($curls as $key=>&$val){
            $val["content"] = curl_multi_getcontent($val["handle"]);
            curl_multi_remove_handle($mh, $val["handle"]); //移除curl句柄
        }
        curl_multi_close($mh); //关闭curl_multi句柄
        ksort($curls);
        return $curls;
    }
    /*g公共头部*/
    public function common_head($status=null){
        return $this->load->view('common/header');
    }

    /*
     * 公共底部
     * 此公共底部是为了全局公共文件.js.统计，弹窗提示等
     * data 为array()
	 * $this->load->view('common/footer',$data);
     */
    public function common_footer($status=null){
        $this->load->view('common/footer');
    }

    /**
     *
     */
    public function fwriteLog(){

        $url    = $this->input->post('url');
        $params = $this->input->post('params');
        $result = $this->input->post('result');
        $method = $this->input->post('method');
        $sysTime= $this->input->post('systime');
        $requestUid = $this->input->post('request_uid');
        $requestUidStr = 'request_uid:'.$requestUid.':';

        log_message('debug',$requestUidStr.'request_url:' . $url);
        log_message('debug',$requestUidStr.'params :' . var_export($params, true));
        log_message('debug',$requestUidStr.'method:' . $method);
        log_message('debug',$requestUidStr.'response ' . var_export($result, true));
        log_message('debug',$requestUidStr.'response_time:' .$sysTime);

    }

}
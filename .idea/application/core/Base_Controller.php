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

    protected $commHelper;

    public function __construct(){
        parent::__construct();

        //self::loadCoreCommonHelper();// 加载类

    }

    public function __destruct(){

        $this->setLog();
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
    public function view($page = 'home'){
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
    public static function loadLogicClassName($class ,$directory=''){

        $path = str_replace('\\', '/', APPPATH);

        if (file_exists($path.$directory.'/'.$class.'.php')){

            if (class_exists($class, FALSE) === false) {
                require_once($path . $directory .'/'. $class . '.php');
            }
        }

    }

    /**
     * 加载配置类
     */
    public function loadCoreCommonHelper(){

        // 加载 配置助手类
        self::loadLogicClassName('Base_Commonhelper','core');
        $this->commHelper = new Base_Commonhelper();
        $this->commHelper->load = $this->load;

    }


    /**
     * 加载接口类方法
     * @param string $interface
     * @param string $directory
     * @param bool $object
     * @return string
     */
    public function loadInterface($interface ='Group_interface',$directory='interface',$object=true){

        // 加载 配置助手类
        self::loadLogicClassName($interface,$directory);

        if($object){

            $instance = $interface;

        }else {

            $instance = strtolower(new $interface);
        }
        $this->setCurl($instance,$object);
        return $instance;
    }

    /**
     * 设置url
     * @param $instance
     * @param $object
     */
    public function setCurl($instance,$object){
        $this->load->library('curl');
        if($object){
            $instance::$curl= $this->curl;
            $instance::$baseController = $this;
        }else{
            $instance->curl = $this->curl;
            $instance->baseController = $this;
        }

        return $instance;
    }
    /**
     * 发邮件功能
     * @param string $message
     */
    public  function sendEmail($message =''){

        $this->load->library('plugin/phpmailer/PHPMailer');
        $this->load->library('Mail');
        $this->load->config('email',true);
        $email =$this->config->config['email'];
        $this->mail->sendEmail($this->phpmailer,$email,$message);
    }
    /**
     * 返回网页头描述信息
     * @param string $title  [网页标题]
     * @param string $content [网页内容]
     * @param string $description[网页描述]
     */
    public function head($title='',$content='',$description=''){

        $data = [
            'title'=>$title,
            'content' =>$content,
            'description' =>$description
        ];
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
        $url =$url.'?'.$queryStr;
        $url =urldecode($url);

        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$connectTimeout);
        curl_setopt($ch,CURLOPT_TIMEOUT,$curlTimeout);
        $result = curl_exec($ch);

        if($result === false){
            $error = curl_error($ch);
            die('Curl error: ' .$error);
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
    protected function httpCurlPost($url,$params=array(),$connectTimeout=30,$curlTimeout=60){

        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_HEADER, 0); // 加快效率
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$connectTimeout);
        curl_setopt($ch,CURLOPT_TIMEOUT,$curlTimeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        $result = curl_exec($ch);

        if($result === false){
            $error = curl_error($ch);
            die('Curl error: ' .$error);
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

}
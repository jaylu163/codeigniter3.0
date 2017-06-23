<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/25
 * Time: 11:17
 */

class  Base_comhelper  extends CI_Controller {


    public function sendMail($title='',$to='',$message =''){

        $this->load->library('plugin/phpmailer/PHPMailer');
        $this->load->library('Mail');
        $this->load->library('Curl');
        $this->load->config('email',true);
        $emailConfig =$this->config->config['email'];

        $this->mail->sendEmail($this->phpmailer,$emailConfig,$title,$to,$message);
    }

    public function sendSms(){


    }

    /**
     * 把文件异步写入log中
     */
    public function writeMailLog(){



    }



    /**
     * 加载单个文件
     * @param $class  【类名】
     * @param string $directory 【应用程序目录名】
     */
    public static function loadAppClass($class ,$directory='interface'){

        $path = str_replace('\\', '/', APPPATH);

        if (file_exists($path.$directory.'/'.$class.'.php')){

            if (class_exists($class, FALSE) === false) {
                require_once($path . $directory .'/'. $class . '.php');
            }
        }

    }

    /**
     * 判断浏览器类型
     * @return string
     */
    public function getMobileBrowse(){
            // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
            if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
                return true;
            }
            // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
            if (isset ($_SERVER['HTTP_VIA'])) {
                // 找不到为flase,否则为true
                return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
            }
            // 脑残法，判断手机发送的客户端标志,兼容性有待提高
            if (isset ($_SERVER['HTTP_USER_AGENT'])) {
                $clientkeywords = array ('nokia',
                    'sony',
                    'ericsson',
                    'mot',
                    'samsung',
                    'htc',
                    'sgh',
                    'lg',
                    'sharp',
                    'sie-',
                    'philips',
                    'panasonic',
                    'alcatel',
                    'lenovo',
                    'iphone',
                    'ipod',
                    'blackberry',
                    'meizu',
                    'android',
                    'netfront',
                    'symbian',
                    'ucweb',
                    'windowsce',
                    'palm',
                    'operamini',
                    'operamobi',
                    'openwave',
                    'nexusone',
                    'cldc',
                    'midp',
                    'wap',
                    'mobile'
                );
                // 从HTTP_USER_AGENT中查找手机浏览器的关键字
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
                {
                    return true;
                }
            }
            // 协议法，因为有可能不准确，放到最后判断
            if (isset ($_SERVER['HTTP_ACCEPT'])) {
                // 如果只支持wml并且不支持html那一定是移动设备
                // 如果支持wml和html但是wml在html之前则是移动设备
                if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @param $tableKey
         * @param $data
         * @return int
         */
        public function writeCacheLog($tableKey ,$data){

            if(is_null(json_decode($data)) !=false){
                $data =json_encode($data);
            }

            try{

                $redis  = $this  ->loadRedis();
                $result = $redis ->lPush($tableKey,$data);

            }catch (Exception $exception){

                $result =array(
                    'code'     =>$exception->getCode(),
                    'exception'=>$exception->getMessage(),
                    'line'     =>$exception->getFile()
                );
            }

            return $result;

        }

        /**
         * @return Redis
         */
        protected  function loadRedis(){

            $redis = new Redis();
            $this->load->config(ENVIRONMENT.'/redis');
            $config = get_instance()->config->config;

            $host =  $config['redis_cluster_host'];
            $port =  $config['redis_cluster_port'];
            $timeout = $config['redis_cluster_timeout'];
            $redis->connect($host,$port,$timeout);
            return $redis;

        }
        
}
<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 10:19
 */

class Demo extends Base_Controller {

    protected $model;


    public function __construct(){

        parent::__construct();
        $instance =$this->loadInterface();// 用到哪个掊口，加载哪个方法

    }

    /**
     * json 格式化输出数据结果
     */
    public function json(){
        $result = $this->jsonFormat(200,['a'=>'A','b'=>'B']);

        return $result;
    }

    /**
     * 发功能邮件
     */
    public function sendMail(){

        $this->sendEmail('aaaaaaaaaaaaaa');

    }
    /**
     * 读取配置文件内容
     */
    public function loadConfig(){

         $this->config->load('email',true);
         $config = $this->config->item('subject','email');
        var_dump($config);die;
    }

    /**
     * 通过id返回用户信息
     * @param $id
     */
    public function getUserInfoById($id=1){
         //$this->load->driver('cache');

         $result = $this->users_model->getInfoById($id);
         print_r($result);
    }

    /**
     * demo
     * @param $url
     */
    public function httpGet(){
        $url = 'http://172.16.37.180:8180/openapi/dept/salelist.do?deptcode=D1602181800156853E&jobcode=J160218171314922SF';
        $result = $this->httpCurlGet($url);

        print_r($result);
    }

    /**
     * demo
     */
    public function httpPost(){
        $url ='http://172.16.37.180:8180/openapi/dept/salelist.do';
        $params = array(
            'deptcode'=>'D1602181800156853E',
            'jobcode' =>'J160218171314922SF'
        );
        $result = $this->httpCurlPost($url,$params);
        print_r($result);
    }

    public function keySearch()
    {
        $pagesize = 6;
        $keywords = $this->input->get_post('keywords');

        parent::loadLogicClassName('Search_logic', 'logic');

        //$api_url = config_item('FUSION_URL').'merge arch.do';
        $data = array(
            'source_id' =>'caissa_lines,caissa_cruise,team_list,zyx_product',
            'team_status'=>'STATE01',
            'channel'    =>'',
            'ordertype'  =>'insert_time:asc'

        );
        $api_data = array(
            'source_id' => 'caissa_lines,caissa_cruise,team_list,zyx_product',
            'team_status' => 'STATE01',
            'lowest_price' => '(359,667),(307,719),(256,770)',
            'querylogic_term' => '(country|continent)',
            'querylogic_value' => '(lowest_price)',
            'use_or_querylogic' => 1,
        );

        $api_url = 'http://172.16.37.180:8180/openapi/merge/search.do';
        $result = $this->httpCurlGet($api_url,$api_data);
        print_r($result);die;

    }
    /**
     * 生成签名
     * @return string 签名字符串
     */
    public function creatSign(){
        $this->load->library('Sign');
        echo $this->sign->makeSign();
    }
    public function Signcheck(){
        //先生成签名字符串,用于检验
        $this->load->library('Sign');
        $signStr = $this->sign->makeSign();
        //传参
        $result = $this->sign->checkSign(time(),$signStr);//以下2种方式也可以
        // $result = $this->sign->checkSign(array('_time'=>time(),'_sign'=>$signStr));
        // $result = $this->sign->checkSign(array(time(),$signStr));
        echo $signStr;
        var_dump($result);die;
    }


}
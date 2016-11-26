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

    }

    /**
     * json 格式化输出数据结果
     */
    public function json(){
        $result = $this->jsonFormat(200,array('a'=>'A','b'=>'B'));

        return $result;
    }

    /**
     * 发功能邮件
     */
    public function email(){

    $this->getBaseHelper()->sendMail('test,test','320211697@qq.com','hahahahahahahahaah');

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

        parent::loadLogicClassName('User_logic');
        $userLogic =new user_logic();
        $data = $userLogic->getInterface();
        var_dump($data);
        $this->load->model('users_model');
        $users_model = new users_model();
        
        $result = $users_model->getInfoById($id);
        print_r($result);
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


    public function logic(){

        parent::loadLogicClassName('User_logic');
        $result = User_logic::$name;
        var_dump($result);die;
    }

    public function logicInterface(){
        parent::loadLogicClassName('User_logic');
        //(new User_logic())->getInterface();
    }

    public function page(){

        parent::loadLogicClassName('User_logic');
        $userLogic = new User_logic();
        $userLogic->getInterface();
        $this->load->library('pagination');
        $pagination = load_class('pagination');
        $this->load->config('pagination',true); // 引进文件，同时想要修改样式，pagination.php 中的class="pagination"
        $config = $this->config->config['pagination'];

        $this->load->helper('url');
        $config['base_url'] =$config['base_url'].'/page';

        $config['total_rows'] = 200;  // 后端接口或是数据库的数据条数。
        $config['per_page'] = 20;    //每一页显示的数据条数
        $pagination->initialize($config);
        echo $pagination->create_links();
    }


}
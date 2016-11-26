<?php
/**
 * 用户管理
 */
class Home extends Base_Controller
{
    public $checkAccess = true;
    public $errList = array();
    public $msg;
    public $userInfo;
    //每页行数
    public $prePage = 2;
    
    public function __construct(){
        parent::__construct();
        
        // 使用REQUEST_TIME可减少重新取得当前时间的开销
        $this->now = date('Y-m-d H:i:s', $this->input->server('REQUEST_TIME'));
    }
    /**
     * 登录页面
     */
    public function index(){
        //echo '<h2>拼命开发中...</h2>';

        $this->common_head();

        $data =array('listInfo'=>'<h2>拼命开发中...</h2>');
        $this->load->view('home/index',$data);

    }
}
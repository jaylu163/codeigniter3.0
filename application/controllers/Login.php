<?php
/**
 * 用户管理
 */
class Login extends Base_Controller
{
    public $checkAccess = true;
    public $errList = array();
    public $msg;
    public $userInfo;
    //每页行数
    public $prePage = 2;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session', array('cookie_lifetime' => 0));
        
        // 使用REQUEST_TIME可减少重新取得当前时间的开销
        $this->now = date('Y-m-d H:i:s', $this->input->server('REQUEST_TIME'));
    }
    /**
     * 登录页面
     */
    public function index(){
        
        $this->load->view('login');
    }
    /**
     * 登录方法
     */
    public function login(){
        if (!empty($this->userInfo['id'])) {
            //已经登录
            $result = array('success' => true, 'msg' => '恭喜，登陆成功~');
        } else {
            $name = $this->input->post('name', true);
            $password = $this->input->post('password', true);
            $captcha = $this->input->post('captcha', true);
            $remember = $this->input->post('remember', true);
            
            $result = $this->checkInput(array('name' => $name, 'password' => $password, 'captcha' => $captcha, 'remember' => $remember));
        }
        return $this->jsonFormat($this->checkAccess ? 200 : 201, $result);
    }
    /**
     * 登录时验证输入
     */
    public function checkInput($data){
        $result = array(
            'success' => false,
            'errList' => &$this->errList,
            'msg' => &$this->msg
        );
        $this->checkAccess = true;
        $this->errList = array();
        //用户名
        $this->userInfo = $this->user_model->getUserByWhere(array('a.username' => $data['name']));
        if (empty($data['name'])) {
            return $this->setFieldErr('name', '用户名不能为空');
        } else if (empty($this->userInfo)) {
            return $this->setFieldErr('name', '用户不存在');
        }
        //密码
        if (empty($data['password'])) {
            return $this->setFieldErr('password', '密码不能为空');
        }
        //验证码
        if ($this->checkNeedCaptcha()) {
            if (empty($data['captcha'])) {
                return $this->setFieldErr('captcha', '验证码不能为空');
            }
            if (strtoupper($data['captcha']) != strtoupper($this->session->captcha)) {
                return $this->setFieldErr('captcha', '验证码错误');
            }
        }
        
        //密码
        if (!empty($data['name']) && !empty($this->userInfo) && !empty($data['password'])) {
            //密码正确
            if (md5($data['password']) == $this->userInfo['password']) {
                if ($this->userInfo['supplier_status'] == 1) {
                    $this->setFieldErr('user', '供应商已被禁用');
                } else if ($this->userInfo['status'] == 2) {
                    $this->setFieldErr('user', '用户已被禁用');
                } else {
                    $remember = $data['remember'] ? 7 * 24 * 3600 : false;
                    if ($this->setUserInfo($remember)) {
                        $result['success'] = true;
                        $result['msg'] = '恭喜，登陆成功~';
                    }
                }
            } else {
                //增加错误次数
                $this->loginError();
                return $this->setFieldErr('password', '密码错误');
            }
        }
            
        return $result;
    }
    /**
     * 设置字符串错误
     */
    public function setFieldErr($field, $msg = ''){
        $this->checkAccess = false;
        $this->errList[$field]['success'] = false;
        $this->errList[$field]['msg'] = $msg;
        $this->msg = $msg;
        return array(
            'success' => false,
            'errList' => $this->errList,
            'msg' => $this->msg
        );
    }
    /**
     * 退出登录
     */
    public function logout(){
        $this->input->set_cookie(config_item('COOKIE_USERINFO_NAME'), '', '');
        $this->session->unset_userdata(config_item('SESSION_USERINFO_NAME'));
        $this->load->helper('url');
        redirect(config_item('STATIC_HOST') . 'login/');
    }
    /**
     * 加密字符串
     * @param $str 待加密字符串
     * @param $decrypt 解密
     */
    public function encrypt($str, $decrypt = false){
        $this->load->library('encryption');
        $this->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => config_item('RANDOM_SECRET')
            )
        );
        //解密
        if ($decrypt) {
            return $this->encryption->decrypt($str);
        }
        //加密
        return $this->encryption->encrypt($str);
    }
    /**
     * 生成验证码
     */
    public function captcha(){
        $this->load->helper('captcha');
        $vals = array(
            'word' => '',
            'img_path' => FCPATH . 'static/captcha/',
            'img_url' => '/static/captcha/',
            'font_path' => FCPATH . 'static/font/simhei.ttf',
            'img_width' => '90',
            'img_height' => '38',
            'expiration' => 7200,
            'word_length' => 4,
            'font_size' => 16,
            'img_id' => 'Imageid',
            'pool' => '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ',
        
            // White background and border, black text and red grid
            'colors'    => array(
                'background' => array(221, 221, 221),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(0, 58, 142)
            )
        );
        
        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);
        echo json_encode($cap);
    }
    /**
     * 登录失败
     */
    public function loginError(){
        $time = time();
        $errList = array($time);
        //记录当前登录失败的时间
        if (!$this->session->has_userdata('loginErr')) {
            $loginErr = $errList;
        } else {
            $loginErr = $this->session->userdata('loginErr');
            array_push($loginErr, $time);
            if (count($loginErr) > 3) {
                $loginErr = array_slice($loginErr, -3);
            }
        }
        $this->session->set_userdata('loginErr', $loginErr);
    }
    /**
     * 验证是否需要显示验证码
     */
    public function checkNeedCaptcha(){
        $flag = false;
        //不存在session
        if ($this->session->has_userdata('loginErr')) {
            $loginErr = $this->session->userdata('loginErr');
            
            if (count($loginErr) >= 3 && $loginErr[0] - time() < 60 * 60) {
                $flag = true;
            }
        }
        return $this->jsonFormat(200, array('result' => $flag));
    }
}
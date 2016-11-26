<?php
/**
 * 用户管理
 */
class User extends Base_Controller
{
    public $checkAccess = true;
    public $errList = array();
    public $msg;
    //每页行数
    public $prePage = 5;
    
    public function __construct(){
        parent::__construct();
        $this->checkLogin();
        $this->load->model('user_model');
        
        // 使用REQUEST_TIME可减少重新取得当前时间的开销
        $this->now = date('Y-m-d H:i:s', $this->input->server('REQUEST_TIME'));
    }
    
    public function showPage($url, $total, $cur_page){
        $this->load->library('pagination');
        $config = array(
            'base_url' => '',
            'total_rows' => $total,
            'per_page' => $this->prePage,
            'page_query_string' => false,
            'cur_page' => $cur_page,
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    /**
     * 用户管理页
     */
    public function index(){
        //公共头部
        $seoTitle = '用户管理';
        $seoKeywords = '用户管理';
        $seoDescription = '用户管理';
        $this->head($seoTitle, $seoKeywords, $seoDescription);
        $this->common_head();//header头部文件
        
        $data = $this->search(true);
        $this->load->view('user/list', $data);
        
        $this->common_footer();//footer尾部文件
    }
    /**
     * 新增用户页
     */
    public function add(){
        //公共头部
        $seoTitle = '新增用户';
        $seoKeywords = '新增用户';
        $seoDescription = '新增用户';
        $this->head($seoTitle, $seoKeywords, $seoDescription);
        $this->common_head();//header头部文件
        $this->load->view('user/add');
        $this->common_footer();//footer尾部文件
    }
    /**
     * 取得用户列表
     */
    public function search($return = false){
        //当前页数
        $page = $this->input->get_post('page', true);
        if (!$page) $page = 1;
        $limit = array(($page-1) * $this->prePage, $this->prePage);
        //筛选条件
        $name = $this->input->get_post('name', true);
        $trueName = $this->input->get_post('true_name', true);
        $where = array();
        if (!empty($name)) {
            $where['name'] = $name;
        }
        if (!empty($trueName)) {
            $where['true_name'] = $trueName;
        }
        //执行查询
        $data = $this->user_model->search($where, $limit);
        //循环一下解析当前状态为汉字
        if (isset($data['data'])) {
            foreach ($data['data'] as &$val) {
                //解析状态
                $val['status_name'] = '';
                if ($val['status'] == 1) {
                    $val['status_name'] = '启用';
                } else if ($val['status'] == 2) {
                    $val['status_name'] = '禁用';
                }
            }
        }
        //生成分页
        $pageLink = $this->showPage('/user', $data['total'], $page);
        if ($return) {
            return array('list' => $data['data'], 'pageLink' => $pageLink);
        }
        return $this->jsonFormat(200, array('list' => $data['data'], 'pageLink' => $pageLink));
    }
    /**
     * 添加用户信息
     */
    public function addSubmit(){
        $result = array(
            'success' => false,
            'errList' => &$this->errList,
            'msg' => '输入错误，请查证'
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            $this->checkInput($data);
            //通过验证
            if ($this->checkAccess) {
                $insert = array(
                    'username' => isset($data['name']) ? $data['name'] : '',
                    'true_name' => isset($data['true_name']) ? $data['true_name'] : '',
                    'telephone' => isset($data['telephone']) ? $data['telephone'] : '',
                    'password' => isset($data['password']) ? md5($data['password']) : '',
                    'status' => 1,
                    'role_id' => 2,
                    'creator_id' => $this->userInfo['id'], //TODO
                    'operator_id' => $this->userInfo['id'], //TODO
                    'operator_name' => $this->userInfo['true_name'], //TODO
                    'createtime' => $this->now,
                    'updatetime' => $this->now,
                );
                if ($this->user_model->add($insert)) {
                    $result['success'] = true;
                    $result['msg'] = '恭喜，新增成功啦~';
                } else {
                    $result['msg'] = '系统偷懒，提交失败啦~';
                }
                return $this->jsonFormat(200, $result);
            } else {
                return $this->jsonFormat(201, $result);
            }
            
        }
    }
    /**
     * 修改用户信息
     */
    public function edit(){
        $result = array(
            'success' => false,
            'errList' => &$this->errList,
            'msg' => &$this->msg
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            $this->checkInput($data);
            //通过验证
            if (isset($data['id']) && $this->checkAccess) {
                $beforeUpdate = $this->user_model->getUserByWhere(array('a.id' => $data['id'], 'a.updatetime' => $data['updatetime']));
                if (empty($beforeUpdate)) {
                    $result['msg'] = '数据已经被修改，请刷新后重试';
                    return $this->jsonFormat(201, $result);
                }
                $update = array(
                    'true_name' => isset($data['true_name']) ? $data['true_name'] : '',
                    'telephone' => isset($data['telephone']) ? $data['telephone'] : '',
                    'operator_id' => $this->userInfo['id'], //TODO
                    'operator_name' => $this->userInfo['true_name'], //TODO
                    'updatetime' => $this->now,
                );
                if ($this->user_model->edit(array('id' => $data['id']), $update)) {
                    $result['success'] = true;
                    $result['msg'] = '资料修改成功，如下：<br>';
                    $result['msg'] .= "用户名：{$data['name']}<br>";
                    $result['msg'] .= "姓名：{$data['true_name']}<br>";
                    $result['msg'] .= "联系电话：{$data['telephone']}";
                } else {
                    $result['msg'] = '系统偷懒，提交失败啦~';
                }
                return $this->jsonFormat(200, $result);
            } else {
                return $this->jsonFormat(201, $result);
            }
            
        }
    }
    /**
     * 禁用用户
     */
    public function statusTo2(){
        $result = array(
            'success' => false,
            'msg' => '修改错误'
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            //通过验证
            if (isset($data['id'])) {
                $beforeUpdate = $this->user_model->getUserByWhere(array('a.id' => $data['id'], 'a.updatetime' => $data['updatetime']));
                if (empty($beforeUpdate)) {
                    $result['msg'] = '数据已经被修改，请刷新后重试';
                    return $this->jsonFormat(201, $result);
                }
                $update = array(
                    'status' => 2,
                    'operator_id' => $this->userInfo['id'], //TODO
                    'operator_name' => $this->userInfo['true_name'], //TODO
                    'updatetime' => $this->now,
                );
                if ($this->user_model->edit(array('id' => $data['id']), $update)) {
                    $result['success'] = true;
                    $result['msg'] = '恭喜，禁用成功啦~';
                } else {
                    $result['msg'] = '系统偷懒，提交失败啦~';
                }
                return $this->jsonFormat(200, $result);
            } else {
                return $this->jsonFormat(201, $result);
            }
            
        }
    }
    /**
     * 启用用户
     */
    public function statusTo1(){
        $result = array(
            'success' => false,
            'msg' => '修改错误'
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            //通过验证
            if (isset($data['id'])) {
                $beforeUpdate = $this->user_model->getUserByWhere(array('a.id' => $data['id'], 'a.updatetime' => $data['updatetime']));
                if (empty($beforeUpdate)) {
                    $result['msg'] = '数据已经被修改，请刷新后重试';
                    return $this->jsonFormat(201, $result);
                }
                $update = array(
                    'status' => 1,
                    'operator_id' => $this->userInfo['id'], //TODO
                    'operator_name' => $this->userInfo['true_name'], //TODO
                    'updatetime' => $this->now,
                );
                if ($this->user_model->edit(array('id' => $data['id']), $update)) {
                    $result['success'] = true;
                    $result['msg'] = '恭喜，启用成功啦~';
                } else {
                    $result['msg'] = '系统偷懒，提交失败啦~';
                }
                return $this->jsonFormat(200, $result);
            } else {
                return $this->jsonFormat(201, $result);
            }
        }
    }
    /**
     * 重置用户密码
     */
    public function editPassword(){
        $result = array(
            'success' => false,
            'msg' => &$this->msg
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            $this->checkInput($data);
            //通过验证
            if (isset($data['id']) && $this->checkAccess) {
                $beforeUpdate = $this->user_model->getUserByWhere(array('a.id' => $data['id'], 'a.updatetime' => $data['updatetime']));
                if (empty($beforeUpdate)) {
                    $result['msg'] = '数据已经被修改，请刷新后重试';
                    return $this->jsonFormat(201, $result);
                }
                $update = array(
                    'password' => isset($data['password']) ? md5($data['password']) : '',
                    'operator_id' => $this->userInfo['id'], //TODO
                    'operator_name' => $this->userInfo['true_name'], //TODO
                    'updatetime' => $this->now,
                );
                if ($this->user_model->edit(array('id' => $data['id']), $update)) {
                    $result['success'] = true;
                    $result['msg'] = '恭喜，密码修改成功';
                } else {
                    $result['msg'] = '系统偷懒，提交失败啦~';
                }
                return $this->jsonFormat(200, $result);
            } else {
                return $this->jsonFormat(201, $result);
            }
        }
    }
    /**
     * 验证输入是否正确
     */
    public function checkInput($data){
        $this->checkAccess = true;
        $this->errList = array();
        //用户名
        if (isset($data['name'])) {
            if (empty($data['name'])) {
                $this->setFieldErr('name', '用户名不能为空');
            } else if (!preg_match('/^[0-9a-zA-Z]{4,14}$/', $data['name'])) {
                $this->setFieldErr('name', '支持4-14字符的数字及英文');
            } else if ($this->checkExist(array('name' => $data['name'], 'id' => $data['id']))) {
                $this->setFieldErr('name', '用户名已存在');
            }
        }
        
        //姓名
        if (isset($data['true_name'])) {
            if (empty($data['true_name'])) {
                $this->setFieldErr('true_name', '姓名不能为空');
            } else if (!preg_match('/^[a-zA-Z'.chr(0x80).'-'.chr(0xff).']+[a-zA-Z \/\.'.chr(0x80).'-'.chr(0xff).']*$/', $data['true_name']) || mb_strlen($data['true_name']) > 50) {
                $this->setFieldErr('true_name', '仅支持小于50字符的中文、英文、空格、斜杠、点。需以中文或英文开头。');
            }
        }
        //手机号
        if (isset($data['telephone'])) {
            if (empty($data['telephone'])) {
            } else if (!preg_match('/^[0-9]{11}$/', $data['telephone'])) {
                $this->setFieldErr('telephone', '格式有误，请重新输入');
            }
        }
        //密码
        if (isset($data['password'])) {
            if (empty($data['password'])) {
                $this->setFieldErr('password', '密码不能为空');
            } else {
                //包含数字
                $hasnum = preg_match('/(?=.*d).*/', $data['password']);
                //包含字母
                $hasabc = preg_match('/(?=.*[a-zA-Z]).*/', $data['password']);
                //包含字符
                $hasstr = preg_match('/(?=.*[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"]).*/', $data['password']);
                
                if (strlen($data['password']) >= 6 && strlen($data['password']) <= 14 &&
                (($hasnum && $hasabc) || ($hasnum && $hasstr) || ($hasabc && $hasstr))) {
                } else {
                    $this->setFieldErr('password', '支持6-14位数字、英文或字符，至少两种组合');
                }
            }
        }
        //确认密码
        if (isset($data['password2'])) {
            if (empty($data['password2'])) {
                $this->setFieldErr('password2', '确认密码不能为空');
            } else if ($data['password2'] != $data['password']) {
                $this->setFieldErr('password2', '两次密码输入不一致，请重新输入');
            }
        }
        return $data;
    }
    /**
     * 验证数据是否已经存在
     */
    public function checkExist($data){
        $where = array();
        if (!empty($data['name'])) {
            $where['a.username'] = $data['name'];
        }
        if (!empty($data['true_name'])) {
            $where['a.true_name'] = $data['true_name'];
        }
        if (!empty($data['id'])) {
            $where['a.id !='] = $data['id'];
        }
        $data = $this->user_model->getUserByWhere($where);
        if (!empty($data)) {
            return $data;
        }
        return false;
    }
    /**
     * 设置字符串错误
     */
    public function setFieldErr($field, $msg = ''){
        $kv = array(
            'name' => '用户名',
            'true_name' => '姓名',
            'telephone' => '手机号',
            'password' => '密码',
            'password2' => '确认密码',
        );
        $this->checkAccess = false;
        $this->errList[$field]['success'] = false;
        $this->errList[$field]['msg'] = $msg;
        $this->msg = $kv[$field] . $msg;
    }
}

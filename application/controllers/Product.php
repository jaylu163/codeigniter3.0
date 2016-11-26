<?php

/**
 * 产品类
 * @author liuzhi
 * @since 2016-11-21
 */

class Product extends Base_Controller
{
    public $checkAccess = true;
    public $errList = array();
    public $msg;
    //每页行数
    public $prePage = 5;
    
    public function __construct(){
        parent::__construct();
        $this->checkLogin();
        
        $this->load->model('product_model');
        // 使用REQUEST_TIME可减少重新取得当前时间的开销
        $this->now = date('Y-m-d H:i:s', $this->input->server('REQUEST_TIME'));
    }
    
    /**
     * 产品管理页面
     */
    public function index(){
        //公共头部
        $seoTitle = '产品管理';
        $seoKeywords = '产品管理';
        $seoDescription = '产品管理';
        $this->head($seoTitle, $seoKeywords, $seoDescription);
        $this->common_head();//header头部文件
        
        $data = $this->search(true);
        $this->load->view('product/list', $data);
        
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
        $where = array();
        $where['product_name'] = $this->input->get_post('product_name', true);
        $where['product_code'] = $this->input->get_post('product_code', true);
        $where['caissa_product_code'] = $this->input->get_post('caissa_product_code', true);
        $where['des_area_name'] = $this->input->get_post('des_area_name', true);
        $where['createtime'] = $this->input->get_post('createtime', true);
        
        //执行查询
        $data = $this->product_model->search($where, $limit);
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
     * 生成ajax分页
     */
    public function showPage($url, $total, $cur_page){
        $this->load->library('pagination');
        $config = array(
            'base_url' => $url,
            'total_rows' => $total,
            'per_page' => $this->prePage,
            'page_query_string' => false,
            'cur_page' => $cur_page,
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    /**
     * 产品添加页面
     */
    public function add(){
        //公共头部
        $seoTitle = '新增产品';
        $seoKeywords = '新增产品';
        $seoDescription = '新增产品';
        $this->head($seoTitle, $seoKeywords, $seoDescription);
        $this->common_head();//header头部文件
        
        $data = array();
        $data['tourType'] = $this->product_model->getTourType();
        $data['traffic'] = $this->product_model->getTraffic();
        $data['desArea'] = $this->product_model->getDesArea();
        $data['productLevel'] = $this->product_model->getProductLevel();
        $data['productSeries'] = $this->product_model->getProductSeries();
        $data['productTheme'] = $this->product_model->getProductTheme();
        $data['kidsStandard'] = $this->product_model->getKidsStandard();
        $data['hotelLevel'] = $this->product_model->getHotelLevel();
        $data['isEdit'] = 0;
        
        $this->load->view('product/add', $data);
        $this->common_footer();//footer尾部文件
    }
    /**
     * 产品编辑页面
     */
    public function edit(){
        $id = $this->input->get_post('id', true);
        if (!$id) {
            return show_404();
        }
        //公共头部
        $seoTitle = '查看产品';
        $seoKeywords = '查看产品';
        $seoDescription = '查看产品';
        $this->head($seoTitle, $seoKeywords, $seoDescription);
        $this->common_head();//header头部文件
        
        $data = array();
        $data['tourType'] = $this->product_model->getTourType();
        $data['traffic'] = $this->product_model->getTraffic();
        $data['desArea'] = $this->product_model->getDesArea();
        $data['productLevel'] = $this->product_model->getProductLevel();
        $data['productSeries'] = $this->product_model->getProductSeries();
        $data['productTheme'] = $this->product_model->getProductTheme();
        $data['kidsStandard'] = $this->product_model->getKidsStandard();
        $data['hotelLevel'] = $this->product_model->getHotelLevel();
        $data['isEdit'] = 1;
        $data['info'] = $this->product_model->getProductById($id);
        
        if (!empty($data['info'])) {
            if ($data['info']['status'] > 0) {
                $data['isEdit'] = 2;//禁用编辑
            }
        } else {
            show_404();
        }
        
        $this->load->view('product/add', $data);
        $this->common_footer();//footer尾部文件
    }
    /**
     * 取得出发城市列表
     */
    public function getStartCity(){
        $word = $this->input->get_post('word', true);
        
        //加载逻辑层
        parent::loadLogicClassName('Product_logic', 'logic');
        $logic = new Product_logic();
        $result = $logic->getStartCity(array('w' => $word));
        return $this->jsonFormat(200, $result);
    }
    /**
     * 取得出发城市列表
     */
    public function getDesCountry(){
        $word = $this->input->get_post('word', true);
        
        //加载逻辑层
        parent::loadLogicClassName('Product_logic', 'logic');
        $logic = new Product_logic();
        $result = $logic->getDesCountry(array('w' => $word));
        return $this->jsonFormat(200, $result);
    }
    /**
     * 文件上传
     */
    public function fileUpload(){
        $result = array(
            'success' => false,
            'msg' => &$this->msg
        );
        if ($this->input->method() == 'post') {
            $inputName = $this->input->post('input_name', true);
            $type = $this->input->post('type', true);
            //$token = $this->input->post('token', true);
            //$verifyToken = md5(config_item('RANDOM_SECRET') . $this->now);
            $conf = $this->checkInputFile($inputName);
            if ($conf && $this->checkAccess) {
                //上传路径
                $config['upload_path'] = config_item('UPLOAD_PATH');
                $config['upload_path'] .= stripos($type, 'image') === false ? 'file/' : 'image/';
                $config['upload_path'] .= date('Ymd');
                if (!file_exists($config['upload_path'])) @mkdir($config['upload_path']);
                //允许的后缀
                if (isset($conf['suffix'])) {
                    $config['allowed_types'] = implode('|', $conf['suffix']);
                }
                //允许大小
                if (isset($conf['maxSize'])) {
                    $config['max_size'] = $conf['maxSize'];
                }
                $this->load->library('upload', $config);
                //执行上传
                if (!$this->upload->do_upload($inputName)) {
                    $result['msg'] = $this->upload->display_errors('', '');
                } else {
                    $result['success'] = true;
                    $result['data'] = $this->upload->data();
                }
                return $this->jsonFormat(200, $result);
            }
        }
        return $this->jsonFormat(201, $result);
    }
    /**
     * 文件删除
     */
    public function fileRemove(){
        $result = array(
            'success' => false,
            'msg' => &$this->msg
        );
        if ($this->input->method() == 'post') {
            $fileUrl = $this->input->post('file_url', true);
            if (!$fileUrl || (file_exists($fileUrl) && @unlink($fileUrl))) {
                $result['success'] = true;
                $result['msg'] = '删除成功';
                return $this->jsonFormat(200, $result);
            } else {
                $result['msg'] = '删除失败';
            }
        }
        return $this->jsonFormat(201, $result);
    }
    /**
     * 提交上传
     */
    public function addSubmit(){
        $result = array(
            'success' => false,
            'errList' => &$this->errList,
            'msg' => '输入错误，请查证'
        );
        
        if ($this->input->method() == 'post') {
            $data = $this->input->post();
            $data = $this->checkInput($data);
            //通过验证
            if ($this->checkAccess) {
                $insert = array(
                    'product_code' => isset($data['product_code']) ? $data['product_code'] : '',
                    'tour_type' => isset($data['tour_type']) ? $data['tour_type'] : '',
                    'tour_type_name' => isset($data['tour_type_name']) ? $data['tour_type_name'] : '',
                    'delay_date_day' => isset($data['delay_date_day']) ? $data['delay_date_day'] : '',
                    'delay_date_night' => isset($data['delay_date_night']) ? $data['delay_date_night'] : '',
                    'start_city_id' => isset($data['start_city_id']) ? $data['start_city_id'] : '',//TODO
                    'start_city_name' => isset($data['start_city_name']) ? $data['start_city_name'] : '',//TODO
                    'product_name' => isset($data['product_name']) ? $data['product_name'] : '',
                    'product_feature' => isset($data['product_feature']) ? $data['product_feature'] : '',
                    'sub_name' => isset($data['sub_name']) ? $data['sub_name'] : '',
                    'des_area_id' => isset($data['des_area_id']) ? $data['des_area_id'] : '',
                    'des_area_name' => isset($data['des_area_name']) ? $data['des_area_name'] : '',
                    'traffic_id' => isset($data['traffic_id']) ? $data['traffic_id'] : '',
                    'traffic_name' => isset($data['traffic_name']) ? $data['traffic_name'] : '',
                    'hotel_level' => isset($data['hotel_level']) ? $data['hotel_level'] : '',
                    'des_country' => isset($data['des_country']) ? $data['des_country'] : '',//TODO
                    'product_level_id' => isset($data['product_level_id']) ? $data['product_level_id'] : '',
                    'product_level_name' => isset($data['product_level_name']) ? $data['product_level_name'] : '',
                    'product_series_id' => isset($data['product_series_id']) ? $data['product_series_id'] : '',
                    'product_series_name' => isset($data['product_series_name']) ? $data['product_series_name'] : '',
                    'product_theme' => isset($data['product_theme']) ? $data['product_theme'] : '',
                    'kids_standard_id' => isset($data['kids_standard_id']) ? $data['kids_standard_id'] : '',
                    'kids_standard_name' => isset($data['kids_standard_name']) ? $data['kids_standard_name'] : '',
                    'product_images' => isset($data['product_images']) ? $data['product_images'] : '',
                    'xingcheng_gaiyao_text' => isset($data['xingcheng_gaiyao_text']) ? $data['xingcheng_gaiyao_text'] : '',
                    'xingcheng_gaiyao_file' => isset($data['xingcheng_gaiyao_file']) ? $data['xingcheng_gaiyao_file'] : '',
                    'other_description' => isset($data['other_description']) ? $data['other_description'] : '',
                    'visa_description' => isset($data['visa_description']) ? $data['visa_description'] : '',
                    'visa_file' => isset($data['visa_file']) ? $data['visa_file'] : '',
                    'status' => 0,
                    'supplier_id' => $this->userInfo['supplier_id'],
                    'op' => $this->userInfo['id'],
                    'createtime' => $this->now,
                    'updatetime' => $this->now,
                );
                if ($this->product_model->add($insert)) {
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
     * 验证输入是否正确
     */
    public function checkInput($data){
        $this->checkAccess = true;
        $this->errList = array();
        //出入境类型
        if (isset($data['tour_type'])) {
            if (empty($data['tour_type'])) {
                $this->setFieldErr('tour_type', '请输入出入境类型');
            }
        }
        //行程天数
        if (isset($data['delay_date_day']) && isset($data['delay_date_night'])) {
            if (empty($data['delay_date_day']) || empty($data['delay_date_night'])) {
                $this->setFieldErr('delay_date', '请输入行程天数');
            } else if (!preg_match('/^[1-9]+$/', $data['delay_date_day']) || !preg_match('/^[1-9]+$/', $data['delay_date_night'])) {
                $this->setFieldErr('delay_date', '输入无效');
            }
        }
        //出发城市
        if (isset($data['start_city_id'])) {
            if (empty($data['start_city_id'])) {
                $this->setFieldErr('start_city_id', '请输入出发城市');
            }
        }
        //产品名称
        if (isset($data['product_name'])) {
            if (empty($data['product_name'])) {
                $this->setFieldErr('product_name', '请输入产品名称');
            } else if (mb_strlen($data['product_name']) > 32) {
                $this->setFieldErr('product_name', '最多可输入32个汉字');
            } else if (!preg_match('/^[0-9a-zA-Z '.chr(0x80).'-'.chr(0xff).'！!；;：:‘’“”"\'\(\)（）【】\[\]，,。\.\+_-—\|｜]+$/', $data['product_name'])) {
                $this->setFieldErr('product_name', '含非法字符');
            }
        }
        //产品特色
        if (isset($data['product_feature'])) {
            if (empty($data['product_feature'])) {
                $this->setFieldErr('product_feature', '请输入产品特色');
            } else if (mb_strlen($data['product_feature']) > 32) {
                $this->setFieldErr('product_feature', '最多可输入32个汉字');
            }
        }
        //副标题
        if (isset($data['sub_name'])) {
            if (empty($data['sub_name'])) {
                $this->setFieldErr('sub_name', '请输入副标题');
            } else if (mb_strlen($data['sub_name']) > 16) {
                $this->setFieldErr('sub_name', '最多可输入16个汉字');
            }
        }
        //目的地分区
        if (isset($data['des_area_id'])) {
            if (empty($data['des_area_id'])) {
                $this->setFieldErr('des_area_id', '请选择目的地分区');
            }
        }
        //交通方式
        if (isset($data['traffic_id'])) {
            if (empty($data['traffic_id'])) {
                $this->setFieldErr('traffic_id', '请选择交通方式');
            }
        }
        //目的地国家
        if (isset($data['des_country']) && $des_country = json_decode($data['des_country'], true)) {
            if (empty($des_country['value'])) {
                $this->setFieldErr('des_country', '请输入目的地国家');
            } else {
                $data['des_country'] = json_encode(array('country_id' => $des_country['value'], 'country_name' => $des_country['name']));
            }
        }
        //产品等级
        if (isset($data['product_level_id'])) {
            if (empty($data['product_level_id'])) {
                $this->setFieldErr('product_level_id', '请选择产品等级');
            }
        }
        //产品系列
        if (isset($data['product_series_id'])) {
            if (empty($data['product_series_id'])) {
                $this->setFieldErr('product_series_id', '请选择产品系列');
            }
        }
        //产品主题
        if (isset($data['product_theme']) && $product_theme = json_decode($data['product_theme'], true)) {
            if (empty($product_theme['value'])) {
                $this->setFieldErr('product_theme', '请选择产品主题');
            } else {
                $data['product_theme'] = json_encode(array('theme_id' => $product_theme['value'], 'theme_name' => $product_theme['name']));
            }
        }
        //儿童价标准
        if (isset($data['kids_standard_id'])) {
            if (empty($data['kids_standard_id'])) {
                $this->setFieldErr('kids_standard_id', '请选择儿童价标准');
            }
        }
        //酒店等级
        if (isset($data['hotel_level']) && $hotel_level = json_decode($data['hotel_level'], true)) {
            if (empty($hotel_level['value'])) {
                $this->setFieldErr('hotel_level', '请选择酒店等级');
            } else {
                $data['hotel_level'] = json_encode(array('hotellevel_id' => $hotel_level['value'], 'hotellevel_name' => $hotel_level['name']));
            }
        }
        //产品图片
        if (isset($data['product_images'])) {
            $product_images = json_decode($data['product_images'], true);
            if (empty($product_images)) {
                $this->setFieldErr('product_images', '请上传产品图片');
            } else {
                //$this->checkInputFile('product_images');
            }
        }
        //行程概要
        if (isset($data['xingcheng_gaiyao_text']) || isset($data['xingcheng_gaiyao_file'])) {
            $xingcheng_gaiyao_file = json_decode($data['xingcheng_gaiyao_file'], true);
            if (empty($data['xingcheng_gaiyao_text']) && empty($xingcheng_gaiyao_file)) {
                $this->setFieldErr('xingcheng_gaiyao', '请输入或上传相关行程概要');
            } else {
                //$this->checkInputFile('xingcheng_gaiyao_file', 'xingcheng_gaiyao');
            }
        }
        //签证及面签说明
        if (isset($data['visa_description'])) {
            if (empty($data['visa_description'])) {
                $this->setFieldErr('visa_description', '请输入签证及面签说明');
            }
        }
        //签证及面签说明附件
        if (isset($data['visa_file'])) {
            //$this->checkInputFile('visa_file');
        }
        //其他说明
        if (isset($data['other_description'])) {
        }
        return $data;
    }
    /**
     * 验证文件类型
     */
    public function checkInputFile($name, $errName = ''){
        !$errName and $errName = $name;
        $kv = array(
            'xingcheng_gaiyao_file' => array('suffix' => array('pdf'), 'maxSize' => 5 * 1024 * 1024, 'maxFile' => 1),
            'visa_file' => array('suffix' => array('doc', 'docx', 'wps', 'xls', 'xlsx', 'pdf', 'jpg', 'zip', 'rar', '7z'), 'maxSize' => 5 * 1024 * 1024),
            'product_images' => array('suffix' => array('jpg', 'png', 'gif')),
        );
        if (isset($_FILES[$name]) && isset($kv[$name])) {
            $file = $_FILES[$name];
            if ($file['error'] === UPLOAD_ERR_OK) {
                //如果不是有多个文件
                if (!is_array($file['name'])) {
                    if (isset($kv[$name]['suffix'])) {
                        $suffix = explode('.', $file['name']);
                        if (!in_array(array_pop($suffix), $kv[$name]['suffix'])) {
                            return $this->setFieldErr($errName, '文件类型不正确');
                        }
                    }
                    if (isset($kv[$name]['maxSize']) && $file['size'] > $kv[$name]['maxSize']) {
                        return $this->setFieldErr($errName, '文件大小超过最大限制');
                    }
                    
                } else if (isset($kv[$name]['maxFile']) && count($file['name']) > $kv[$name]['maxFile']) {
                    return $this->setFieldErr($errName, '文件超过最大上传个数');
                }
            } else {
                switch ($file['error']) {
                    case UPLOAD_ERR_INI_SIZE :
                        $this->setFieldErr($errName, '文件大小超过服务器最大设置');
                        break;
                    case UPLOAD_ERR_FORM_SIZE :
                        $this->setFieldErr($errName, '文件大小超过表单最大设置');
                        break;
                    case UPLOAD_ERR_PARTIAL :
                        $this->setFieldErr($errName, '文件只有部分被上传');
                        break;
                    case UPLOAD_ERR_NO_FILE :
                        $this->setFieldErr($errName, '文件没有被上传');
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR :
                        $this->setFieldErr($errName, '找不到临时文件夹');
                        break;
                    case UPLOAD_ERR_CANT_WRITE :
                        $this->setFieldErr($errName, '文件写入失败');
                        break;
                    
                }
            }
            return $kv[$name];
        }
        return false;
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
        $data = $this->product_model->getUserByWhere($where);
        if (!empty($data)) {
            return $data;
        }
        return false;
    }
    /**
     * 设置字符串错误
     */
    public function setFieldErr($field, $msg = ''){
        $this->checkAccess = false;
        $this->errList[$field]['success'] = false;
        $this->errList[$field]['msg'] = $msg;
        $this->msg = $msg;
    }
}

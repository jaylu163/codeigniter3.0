<?php

/**
 * 用户模板类
 */
class Product_model extends Base_Model {

    protected $table = 'group_product';

    public function __construct()
    {
        parent::__construct();
        $this->load->database('caissa_supplier', false, true);
        $this->table_name_user = 'supplier_user';
        $this->table_name_supplier = 'supplier_info';
        
    }
    /**
     * 取得产品列表
     */
    public function search($where, $limit, $fields = ''){
        $fields = $fields
            ? $fields
            : 'a.*, b.true_name op_name';
        $this->db->select($fields);
        //设置where条件
        $this->setWhere($where);
        //设置order
        $this->db->order_by('createtime', 'DESC');
        //设置limit
        $this->db->limit($limit[1], $limit[0]);
        //执行
        $data = $this->db->get()->result_array();
        //计算总数
        $this->db->select('count(1) count');
        $total = $this->setWhere($where)->get()->row_array();
        return array(
            'total' => $total['count'],
            'data' => $data
        );
    }
    /**
     * 提取设置where方法，取得总数和分页是公用
     */
    public function setWhere($where){
        //设置from
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_name_user . ' b', 'b.id = a.op', 'left');
        //设置where条件
        if (!empty($where['product_name'])) {
            $this->db->like('a.product_name', $where['product_name']);
        }
        if (!empty($where['product_code'])) {
            $this->db->like('a.product_code', $where['product_code']);
        }
        if (!empty($where['caissa_product_code'])) {
            $this->db->like('a.caissa_product_code', $where['caissa_product_code']);
        }
        if (!empty($where['des_area_name'])) {
            $this->db->like('a.des_area_name', $where['des_area_name']);
        }
        if (!empty($where['createtime'])) {//TODO
            $this->db->like('createtime', $where['createtime']);
        }
        return $this->db;
    }
    /**
     * 添加用户到数据库
     */
    public function add($data){
        if (!empty($data)) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
        return false;
    }
    /**
     * 编辑用户到数据库
     */
    public function edit($where, $data){
        if (!empty($where)) {
            $this->db->update($this->table, $data, $where);
            return $this->db->affected_rows();
        }
        return false;
    }
    /**
     * 取得出入境类型
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getTourType($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'BUS004', 'name' => '出国'),
            '2' => array('id' => '2', 'code' => 'BUS001', 'name' => '出境'),
            '4' => array('id' => '4', 'code' => 'BUS002', 'name' => '入境'),
            '3' => array('id' => '3', 'code' => 'BUS003', 'name' => '国内'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得交通方式
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getTraffic($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'TRA003', 'name' => '大巴'),
            '2' => array('id' => '2', 'code' => 'TRA002', 'name' => '火车'),
            '3' => array('id' => '3', 'code' => 'TRA001', 'name' => '飞机'),
            '7' => array('id' => '7', 'code' => 'TRA006', 'name' => '转机'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得目的地分区
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getDesArea($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'DESTIN06', 'name' => '欧洲'),
            '2' => array('id' => '2', 'code' => 'DESTIN15', 'name' => '北美'),
            '3' => array('id' => '3', 'code' => 'DESTIN30', 'name' => '拉美'),
            '4' => array('id' => '4', 'code' => 'DESTIN31', 'name' => '南美'),
            '5' => array('id' => '5', 'code' => 'DESTIN11', 'name' => '大洋洲-澳新'),
            '6' => array('id' => '6', 'code' => 'DESTIN32', 'name' => '大洋洲-南太'),
            '7' => array('id' => '7', 'code' => 'DESTIN07', 'name' => '非洲观光'),
            '8' => array('id' => '8', 'code' => 'DESTIN14', 'name' => '非洲度假'),
            '9' => array('id' => '9', 'code' => 'DESTIN33', 'name' => '日本北海道'),
            '10' => array('id' => '10', 'code' => 'DESTIN34', 'name' => '日本本州'),
            '11' => array('id' => '11', 'code' => 'DESTIN38', 'name' => '日本九州'),
            '12' => array('id' => '12', 'code' => 'DESTIN12', 'name' => '日本冲绳'),
            '13' => array('id' => '13', 'code' => 'DESTIN04', 'name' => '韩国'),
            '14' => array('id' => '14', 'code' => 'DESTIN35', 'name' => '朝鲜'),
            '15' => array('id' => '15', 'code' => 'DESTIN05', 'name' => '国内'),
            '16' => array('id' => '16', 'code' => 'DESTIN13', 'name' => '西亚'),
            '17' => array('id' => '17', 'code' => 'DESTIN39', 'name' => '中亚'),
            '18' => array('id' => '18', 'code' => 'DESTIN01', 'name' => '东南亚'),
            '19' => array('id' => '19', 'code' => 'DESTIN36', 'name' => '南亚'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得产品等级
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getProductLevel($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'PLEV01', 'name' => '大众'),
            '2' => array('id' => '2', 'code' => 'PLEV02', 'name' => '精选'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得产品系列
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getProductSeries($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'SERI01', 'name' => '观光型'),
            '2' => array('id' => '2', 'code' => 'SERI02', 'name' => '度假型'),
            '3' => array('id' => '3', 'code' => 'SERI03', 'name' => '主题型'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得产品主题
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getProductTheme($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'THEM001', 'name' => '蜜月'),
            '2' => array('id' => '2', 'code' => 'THEM002', 'name' => '亲子'),
            '3' => array('id' => '3', 'code' => 'THEM003', 'name' => '婚礼'),
//          '4' => array('id' => '4', 'code' => 'THEM004', 'name' => '音乐'),
//          '5' => array('id' => '5', 'code' => 'THEM005', 'name' => '美食'),
//          '6' => array('id' => '6', 'code' => 'THEM006', 'name' => '艺术'),
            '7' => array('id' => '7', 'code' => 'THEM007', 'name' => '目的地节庆'),
            '8' => array('id' => '8', 'code' => 'THEM008', 'name' => '文化遗产'),
            '9' => array('id' => '9', 'code' => 'THEM009', 'name' => '走遍'),
            '10' => array('id' => '10', 'code' => 'THEM010', 'name' => '健康体检'),
            '11' => array('id' => '11', 'code' => 'THEM011', 'name' => '夕阳红'),
            '12' => array('id' => '12', 'code' => 'THEM012', 'name' => '暑期'),
            '13' => array('id' => '13', 'code' => 'THEM013', 'name' => '徒步'),
            '14' => array('id' => '14', 'code' => 'THEM014', 'name' => '露营'),
            '15' => array('id' => '15', 'code' => 'THEM015', 'name' => '骑行'),
            '16' => array('id' => '16', 'code' => 'THEM016', 'name' => '马拉松'),
            '17' => array('id' => '17', 'code' => 'THEM017', 'name' => '观赛'),
            '18' => array('id' => '18', 'code' => 'THEM018', 'name' => '体验季'),
            '19' => array('id' => '19', 'code' => 'THEM019', 'name' => '海外婚礼'),
            '20' => array('id' => '20', 'code' => 'THEM020', 'name' => '海外过大年'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得儿童类型
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getKidsStandard($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'CHDAGE01', 'name' => '0-6岁不占床'),
            '2' => array('id' => '2', 'code' => 'CHDAGE02', 'name' => '0-6岁不含6岁不占床'),
            '3' => array('id' => '3', 'code' => 'CHDAGE03', 'name' => '0-12岁不含12岁不占床'),
            '4' => array('id' => '4', 'code' => 'CHDAGE04', 'name' => '2-6岁不含6岁不占床'),
            '5' => array('id' => '5', 'code' => 'CHDAGE05', 'name' => '2-6岁不占床'),
            '6' => array('id' => '6', 'code' => 'CHDAGE06', 'name' => '2-9岁不占床'),
            '7' => array('id' => '7', 'code' => 'CHDAGE07', 'name' => '2-11岁不占床'),
            '8' => array('id' => '8', 'code' => 'CHDAGE08', 'name' => '2-12岁不占床'),
            '9' => array('id' => '9', 'code' => 'CHDAGE09', 'name' => '2-9岁不含9岁不占床'),
            '10' => array('id' => '10', 'code' => 'CHDAGE10', 'name' => '2-11岁不含11岁不占床'),
            '11' => array('id' => '11', 'code' => 'CHDAGE11', 'name' => '2-12岁不含12岁不占床'),
            '12' => array('id' => '12', 'code' => 'CHDAGE12', 'name' => '儿童'),
            '13' => array('id' => '13', 'code' => 'CHDAGE13', 'name' => '无儿童价'),
            '14' => array('id' => '14', 'code' => 'CHDAGE14', 'name' => '其他（需线下沟通）'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }
    /**
     * 取得酒店等级
     * @author liuzhi
     * @since 2016-11-21
     */
    public function getHotelLevel($id = ''){
        $list = array(
            '1' => array('id' => '1', 'code' => 'HOTEL05', 'name' => '五星或同级'),
            '2' => array('id' => '2', 'code' => 'HOTEL04', 'name' => '四星或同级'),
            '3' => array('id' => '3', 'code' => 'HOTEL03', 'name' => '三星或同级'),
            '4' => array('id' => '4', 'code' => 'HOTEL02', 'name' => '二星及以下/经济'),
            '5' => array('id' => '5', 'code' => 'HOTEL06', 'name' => '农庄'),
            '6' => array('id' => '6', 'code' => 'HOTEL07', 'name' => '特色民宿'),
            '7' => array('id' => '7', 'code' => 'HOTEL08', 'name' => '特色酒店'),
        );
        if ($id === '') {
            return $list;
        } else if (isset($list[$id])) {
            return $list[$id]['name'];
        } else {
            return false;
        }
    }

    /**
     * 查询caissa dbid
     * @param $productCode
     * @return array
     */
    public function getdbidByProductCode($productCode,$supplierId){

        if(empty($supplierId) || empty($productCode)){
            return array('product_code,supplier_id empty');
        }
        if($productCode && $supplierId){
            $result = $this->db->from($this->table)->select('id,caissa_product_dbid')->where('product_code',$productCode)->where('supplier_id',$supplierId)->get()->row_array();

            return $result;
        }
        return array();
    }
    /**
     * 按ID取得产品的信息
     * @author liuzhi
     * @since 2016-10-13
     */
    public function getProductById($id, $fields = ''){
        if (!empty($id)) {
            $fields = $fields 
                ? $fields
                : 'a.*, b.true_name op_name';
            $this->db->select($fields);
            $this->db->from($this->table . ' a');
            $this->db->join($this->table_name_user . ' b', 'b.id = a.op', 'left');
            $this->db->where('a.id', $id);
            $info = $this->db->get()->row_array();
            //防止json影响前端数据
            $info['hotel_level'] = str_replace('"', '\"', $info['hotel_level']);
            $info['des_country'] = str_replace('"', '\"', $info['des_country']);
            $info['product_theme'] = str_replace('"', '\"', $info['product_theme']);
            $info['product_images'] = str_replace('"', '\"', $info['product_images']);
            $info['xingcheng_gaiyao_text'] = str_replace('"', '\"', $info['xingcheng_gaiyao_text']);
            $info['xingcheng_gaiyao_file'] = str_replace('"', '\"', $info['xingcheng_gaiyao_file']);
            $info['visa_file'] = str_replace('"', '\"', $info['visa_file']);
            
            return $info;
        }
        return false;
    }

    /**
     * 通过产品bdid返回产品名称
     * @param $dbid
     * @return array
     */
    public function getProductNameAndStartCity($dbid){
        if(empty($dbid)){
            return array('caissa_product_dbid empty');
        }
        $result = $this->db->from($this->table)->select('id,product_name,start_city_name')->where('caissa_product_dbid',$dbid)->get()->row_array();

        return $result;
    }

    /**
     * 产品code码
     * @param $dbid
     * @return array
     */
    public function getProductCodeBydbid($dbid){
        if(empty($dbid)){
            return array('caissa_product_dbid empty');
        }
        $result = $this->db->from($this->table)->select('id,product_code')->where('caissa_product_dbid',$dbid)->get()->row_array();

        return $result;
    }

    /**
     * @param $supplierId
     * @return array
     */
    public function getProductInfoBySupplierId($supplierId){
        if(empty($supplierId)){
            return array('supplier_id empty');
        }
        $result = $this->db->from($this->table)->select('id,createtime,caissa_product_dbid')->where('supplier_id',$supplierId)->get()->row_array();

        return $result;
    }
}
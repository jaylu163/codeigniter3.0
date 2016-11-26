<?php

/**
 * 用户模板类
 */
class User_model extends Base_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('caissa_supplier', false, true);
        $this->table_name_user = 'supplier_user';
        $this->table_name_supplier = 'supplier_info';
        
    }
    /**
     * 取得用户列表
     */
    public function search($where, $limit, $fields = ''){
        $fields = $fields
            ? $fields
            : 'id, username name, true_name, telephone, status, updatetime';
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
        $this->db->from($this->table_name_user);
        //设置where条件
        if (!empty($where['name'])) {
            $this->db->like('username', $where['name']);
        }
        if (!empty($where['true_name'])) {
            $this->db->like('true_name', $where['true_name']);
        }
        return $this->db;
    }
    /**
     * 添加用户到数据库
     */
    public function add($data){
        if (!empty($data)) {
            $this->db->insert($this->table_name_user, $data);
            return $this->db->insert_id();
        }
        return false;
    }
    /**
     * 编辑用户到数据库
     */
    public function edit($where, $data){
        if (!empty($where)) {
            $this->db->update($this->table_name_user, $data, $where);
            return $this->db->affected_rows();
        }
        return false;
    }
    /**
     * 验证数据是否已经存在
     */
    public function getUserByWhere($where, $fields = ''){
        $fields = $fields
            ? $fields
            : 'a.id, a.username name, a.true_name, a.password, a.status, a.updatetime,
            b.id supplier_id, b.supplier_name, b.status supplier_status';
        $this->db->select($fields);
        $this->db->from($this->table_name_user . ' a');
        $this->db->join($this->table_name_supplier . ' b', 'b.id = a.supplier_id', 'left');
        //设置where条件
        if (!empty($where)) {
            $this->db->where($where);
        } else {
            $this->db->where('1 = 0');
        }
        $data = $this->db->get()->row_array();
        return $data;
    }
}
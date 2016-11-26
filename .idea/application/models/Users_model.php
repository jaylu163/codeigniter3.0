<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/7
 * Time: 19:01
 */
class Users_model extends Base_Model {

    public $title;
    public $content;
    public $date;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getInfoById($id){
        $result = $this->db->select('*')->from('zyx_product')->where('product_id',$id)->get()->row_array();
        // result_array(),查多条
        return $result;
    }

}
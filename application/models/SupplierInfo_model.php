<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/25
 * Time: 14:50
 */
class SupplierInfo_model extends Base_Model{


     protected $table ='supplier_info';

    /**
     * 查供用商信息
     * @param $id
     * @return array
     */
     public function getSupplierById($id){

         if(empty($id)){
             return array('id empty');
         }
         $result = $this->db->from($this->table)->select('id,supplier_dbid')->where('id',$id)->get()->row_array();
         return $result;
     }
}
<?php

class Order_model extends Base_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * 下单日志记录
     */
    public function insertLog($arr){
    	$db = $this->load->database('log',TRUE);
    	$result = $db->insert('group_order_log', $arr);
       
        return $result;
    }

}
<?php
/**
 *发票
 */

class Invoice extends Base_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public  function addInvoice(){
        $user_id = $this->input->get_post('user_id');//userid不能为空
        $orderNumber=       $this->input->get_post('orderNumber');
        $orderDbid=         $this->input->get_post('orderDbid');
        $invoiceType=       $this->input->get_post('invoiceType');
        $invoiceHead=       $this->input->get_post('invoiceHead');
        $invoiceMoney=      $this->input->get_post('invoiceMoney');
        $insertDeptName=    $this->input->get_post('insertDeptName');
        $insertUserName=    $this->input->get_post('insertUserName');
        $insertDeptCode=    $this->input->get_post('insertDeptCode');
        $custInvoiceInfo=   $this->input->get_post('custInvoiceInfos');
            if(!$user_id)
                return $this->jsonFormat(201, array(), '用户申请人ID不能为空');
            if(!$orderNumber)
                return $this->jsonFormat(202, array(), '用户订单编号不能为空');
            if(!$invoiceType)
                return $this->jsonFormat(203, array(), '发票类型不能为空');
            if(!$invoiceHead)
                return $this->jsonFormat(204, array(), '发票抬头不能为空');
            if(!$invoiceMoney)
                return $this->jsonFormat(205, array(), '金额不能为空');
            if(!$insertDeptName)
                return $this->jsonFormat(206, array(), '申请部门名称不能为空');
            if(!$insertDeptCode)
                return $this->jsonFormat(207, array(), '销售部门code不能为空');
            if(!$custInvoiceInfo)
                return $this->jsonFormat(208, array(), '金额明细不能为空');
            $custInvoiceInfo=json_decode($custInvoiceInfo);
            if(!empty($custInvoiceInfo)){
                foreach ($custInvoiceInfo as $key=>$v){
                   echo  $custInvoiceInfo.$key=$v;
                }
            }
        //调用接口
        $api_url = config_item('MUMBER_CENTER_URL').'order/team/saveinvoice.do';
        $api_data = array(
            'invoiceType' =>$invoiceType,
            'orderNumber'=>$orderNumber,
            'InvoiceMoney'=>$invoiceMoney,
            'orderDbid'=>$orderDbid,
            'invoiceHead'=>$invoiceHead,
            'insertDeptName'=>$insertDeptName,
            'insertUserName'=>$insertUserName,
            'insertDeptCode'=>$insertDeptCode,
            'custInvoiceInfo'=>$custInvoiceInfo,
        );
       /* $data=array(
            'user_id'=>$user_id,
            'add_time'=>time(),
            'status'=>1,
            'type'=>'2',
            'log_name'=>'申请发票',
        );*/

        $return = $this->httpCurlPost($api_url,$api_data);
        $return = json_decode($return,true);
        if(!$return)
            return $this->jsonFormat(202, array(), '接口调用失败');
       /* if($return)
            $this->db->insert('log', $data);*/
        return $this->jsonFormat(200, $return, 'ok');
    }
}

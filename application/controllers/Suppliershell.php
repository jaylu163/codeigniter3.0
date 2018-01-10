<?php

/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 10:19
 */


class Suppliershell extends Base_Controller {

    private $action_logs       = 'supplier_operate_log';
    private $product_team      = 'group_product_team';
    private $productName       ='group_product';
    protected $consumer        ;

    protected  $client         ;
    public function __construct(){

        parent::__construct();
        $this->load->database('caissa_supplier', false, true);
        parent::loadLogicClassName('Supplieruser_logic', 'logic');
        $this->loadInterface('Supplier_interface','interface');

        $this->load->library('ClientKafka');
        $this->client  = new ClientKafka();

        set_time_limit(0);
    }

    /**
     * @return \Kafka\Consumer
     */
    protected function getConsumer(){

        $hostList = config_item('zookeeper_host_list');

        //$topic= 'caissatpd_teaminfo_searchengine';
        $consumer = $this->client->getConsumerInstance($hostList);

        return $consumer;

    }
    /**
     * 修改caissa 计调
     * [setProductTeam description]
     */
    public function setProductTeam($topic){

        $this->load->library('ClientKafka');
        $this->load->model('Productteam_model');
        $product = new Productteam_model();
        $group= 'supplier';
        $consumer = $this->getConsumer();

        while (true) {

            $result = $this->client ->getConsumerMsg($consumer,$group,$topic);
           
            if(is_array($result) || is_object($result)){

                foreach ($result as $topicName => $partition) {
                    if (is_array($partition) || is_object($partition)) {
                        foreach ($partition as $partId => $messageSet) {

                            foreach ($messageSet as $message) {
                                log_message('debug', '修改计调-原格式消息' . (string)$message);
                                $message = (array)$message;

                                $value = json_decode($message["\0Kafka\Protocol\Fetch\Message\0value"], true);
                                
                                // 把数据写到对应的数据库中
                                if (is_array($value)) {
                                    if (isset($value['changeType'])) {
                                        if ($value['changeType'] == 'TEAM_OPERATOR_CHANGE') {
                                            log_message('debug', '修改计调-IN' . var_export($value, true));
                                            $product->updateData($value);
                                        }
                                    }

                                    sleep(1);
                                }

                            }

                        }
                    } else {
                        log_message('debug','kafka partition message...'.var_export($partition,true));
                    }
                }
            }
            var_dump(date("Y-m-d H:i:s"));
            sleep(1);
        }


    }
    /**
     * 修改团销售状态
     * [setProductTeam description]
     */
    public function setSaleStatus($topic){

        $this->load->library('ClientKafka');
        $this->load->model('Productteam_model');
        $product = new Productteam_model();
        $group= 'supplier';
        $consumer = $this->getConsumer();

        while (true) {

            $result = $this->client ->getConsumerMsg($consumer,$group,$topic);

            if(is_array($result) || is_object($result)){

                foreach ($result as $topicName => $partition) {
                    if (is_array($partition) || is_object($partition)) {
                        foreach ($partition as $partId => $messageSet) {

                            foreach ($messageSet as $message) {
                                log_message('debug', '修改销售状态-原格式消息' . (string)$message);
                                $message = (array)$message;

                                $value = json_decode($message["\0Kafka\Protocol\Fetch\Message\0value"], true);
                                // 把数据写到对应的数据库中
                                if (is_array($value)) {
                                    if (isset($value['changeType'])) {
                                        if ($value['changeType'] == 'GROUP_CONTROL_CHANGE') {
                                            log_message('debug', '修改销售状态-IN' . var_export($value, true));
                                            $product->updateTeamStatus($value);
                                        }
                                    }
                                    sleep(1);
                                }
                            }
                        }
                    } else {
                        log_message('debug','kafka partition message...'.var_export($partition,true));
                    }
                }
            }
            var_dump(date("Y-m-d H:i:s"));
            sleep(1);
        }
    }


    /**
     * 订单消息通知
     * [setOrderUpdate description]
     */
    public function setOrderUpdate($topic){


        $this->load->model('Notice_model');
        $notice = new Notice_model();

        //$hostList =config_item('zookeeper_host_list');
        $group    = 'supplier';
        $consumer = $this->getConsumer();

        while (true) {
           
            $result = $this->client ->getConsumerMsg($consumer,$group,$topic);

            if(is_array($result) || is_object($result)){

                foreach ($result as $topicName => $partition) {
                    
                    if (is_array($partition) || is_object($partition)) {
                        foreach ($partition as $partId => $messageSet) {

                            foreach ($messageSet as $message) {

                                $message =(array)$message;
                                $value =json_decode($message["\0Kafka\Protocol\Fetch\Message\0value"],true);

                                log_message('debug','kafka message...'.var_export($value,true));
                                $data = $this->_logicData($value);
                                // 把数据写到对应的数据库中
                                if(is_array($data)){
                                    $result = $notice->insert($data);
                                    $this->insertLog($message["\0Kafka\Protocol\Fetch\Message\0value"]);
                                }
                                sleep(1);
                            }

                        }
                    } else {
                        log_message('debug','kafka partition message...'.var_export($partition,true));
                    }
                }

            }
            var_dump(date('Y-m-d H:i:s'));
            sleep(1);
        }


    }

    private function _logicData($data){
        $arr=array();

        if(is_array($data)){

            $this->load->model('Productteam_model');
            $this->load->model('Product_model');
            $product = new Product_model();
            $Productteam_model = new Productteam_model();
            if(isset($data['changeDetail']['productId'])){
                $productId = $data['changeDetail']['productId'];
                $teamDbId  = isset($data['changeDetail']['teamDbId'])?($data['changeDetail']['teamDbId']):'';
                $teamProductInfo =$Productteam_model->getProductIdByTeamId($teamDbId);
                $productRow = $product->getProductInfoByProductDbId($teamProductInfo['product_id']);

                // caissa 编码
                $productCode= $productRow['caissa_product_code'];

                $teamResult = $Productteam_model->getStartDate($teamDbId);
                // 出团时间
                $startDate =isset($teamResult['start_date'])?$teamResult['start_date']:'';

                // 产品名称
                $productName =isset($productRow['product_name_preview'])?$productRow['product_name_preview']:'';

                if(isset($productRow['op'])){
                    $arr['user_id'] = $productRow['op'];
                }else{
                    $arr['user_id'] =100000;
                }

            }


            $arr['url']  = json_encode(array("id"=>$data['orderNumber']));

            if($data['changeDetail']['controlType'] ==1 ){
                $arr['title']       ='订单号：'.$data['orderNumber'].'，预订'.$data['changeDetail']['number'].'人，出发日期：'.$startDate.'，预订产品：'.$productName ;
                //库存
                $stock=-$data['changeDetail']['number'];
                $signupnum = $data['changeDetail']['number'];// 报名人数
                $arr['message_type'] = 1;
            }

            if($data['changeDetail']['controlType'] ==2 ){
                $arr['title']       ='订单号：'.$data['orderNumber'].'，退订'.$data['changeDetail']['number'].'人，出发日期：'.$startDate.'，退订产品：'.$productName ;
                //库存
                $stock=$data['changeDetail']['number'];
                $signupnum = -$data['changeDetail']['number'];// 退报人数
                $arr['message_type'] = 6;
            }
            //var_dump('stock message erp:'.$stock);  关闭调试信息
            //var_dump('signupnum message erp:'.$signupnum);  关闭调试信息

            $arr['message_time'] = date('Y-m-d H:i:s');
            if(isset($data['changeDetail']['updateDate'])){
                $arr['message_time'] =date('Y-m-d H:i:s',substr($data['changeDetail']['updateDate'],0,-3));
            }

            $arr['createtime']   = date('Y-m-d H:i:s');
        }

        $orderId =$data['orderNumber']; // 订单号
        $orderType =$data['changeDetail']['controlType'];
        if(ENVIRONMENT =='production'){
            // 逻辑层发送短信功能.......
            $supplierlogic = new Supplieruser_logic();
            $result = $supplierlogic->getSupplierInfoByDbId($teamDbId,$orderId,$productName,$startDate,abs($signupnum),$orderType);
        }
        // 退团不修改产品表字段
        if($signupnum >0){
            // 修改产品表订单人数
            $sql ='update '.$this->productName.' set signupnum= signupnum+'.$signupnum.' where caissa_product_dbid='.'"'. $productId.'"';
            $this->db->query($sql);
        }

        if($teamDbId){
            $row = $this->db->from($this->product_team)->select('stock,signupnum')->where('caissa_team_dbid',$teamDbId)->limit(1)->get()->row_array();
            if(isset($row['stock'])){
                $stock = $row['stock']+$stock;// 库存
                $signupnum = $row['signupnum'] +$signupnum; // 报名人数

                if($stock<0 || $signupnum <0){
                    $stock =0;
                    $signupnum =0;
                }
            }else{
                $stock =0;
                $signupnum =0;
            }
            //var_dump($arr,$row['stock'],$row['signupnum']);
            // 修改库存
            $sql ='update '.$this->product_team.' set stock= '.$stock.',signupnum='.$signupnum.' where caissa_team_dbid='.'"'. $teamDbId.'"';
            $query =$this->db->query($sql);

            return $arr;
        }

    }

    /**
     * 操作日志
     * [insertLog description]
     * @param  [type] $logMessage [description]
     * @return [type]             [description]
     */
    public function insertLog($logMessage){

        // 记录log
        $log =array(
            'operate_id' =>'phpshell',
            'operate_name' =>'sysytem',
            'message' =>$logMessage,
            'createtime' =>date('Y-m-d H:i:s'),
            'action'     =>'phpshell update',
            'ip'         =>$_SERVER['SCRIPT_FILENAME'],
            'createtime' =>date('Y-m-d H:i:s')
        );

        $this->db->insert($this->action_logs,$log);
    }




}
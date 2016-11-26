<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/23
 * Time: 10:19
 */

class Order extends Base_Controller {

    private $product;
    private $order;
    public function __construct(){

        parent::__construct();
        $this->loadInterface('Supplier_interface','interface'); // 供应商订单类
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->product = new Product_model();
        $this->order   = new Order_model();
        $this->checkLogin();
    }
    public function orderList (){

        $supplierId = isset($this->userInfo['supplier_id'])?$this->userInfo['supplier_id']:0;

        $listInfo =array();
        $this->common_head();//

        if(empty($supplierId)){
           throw new Exception('还没有分配供用商');
        }
        $this->load->model('SupplierInfo_model');
        $supplier = new SupplierInfo_model();
        $supplierInfo = $supplier->getSupplierById($supplierId);

        $search = $this->input->post('search',true);
        if(isset($search)){
            $params =array(
                'order_id',
                'product_code',
                'product_name',
                'startOrderDate',
                'endOrderDate',
                'startOutDate',
                'endOutDate'
            );
            $params = $this->input->post($params,true);
            $productCode = isset($params['product_code'])?$params['product_code']:''; // 查出产品id

            if($productCode){
                $result = $this->product->getdbidByProductCode($productCode,$supplierId);
                $caissaProductbdid = isset($result['caissa_product_dbid'])?$result['caissa_product_dbid']:'';
                $params['productIds'] =$caissaProductbdid;
            }

        }else{
            // 没有搜索,展示订单列表
            $params['supplierDbId'] = $supplierInfo['supplier_dbid'];
            $product = $this->product->getProductInfoBySupplierId($supplierId);
            $params['productIds']   = array_column($product,'caissa_product_dbid');
            $params['startOrderDateStr'] = urlencode('2016-11-20 10:00:00');
            $params['endOrderDateStr']   = urlencode(date('Y-m-d H:i:s'));
        }
        // 搜索调用接口去查订单数据
        $orderList = Supplier_interface::getOrderListInfo($params);
        $orderList = $this->jsonToArray($orderList);

        $action='order/orderList';

        $this->load->library('pagination');
        $config = array(
            'total_rows' => isset($orderList['totalRows'])?$orderList['totalRows']:0,
            'per_page' => 1,
        );
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        $data =array('list'=>$orderList,'pagination'=>$pagination);

        $this->load->view('order/list',$data);

        $this->common_footer();//footer尾部文件


    }

    /**
     * 订单详情
     */
    public function detail(){
        $orderId= $this->input->get('id');
        $data =  array();
        $this->common_head();
        $money = 0;
        if($orderId){
            $params =array('orderNumber'=>$orderId);
            // 调用接口展示数据
            $orderInfo = Supplier_interface::getOrderInfo($params);
            $orderInfo = $this->jsonToArray($orderInfo);

            if(isset($orderInfo['orderBase']) && $orderInfo['orderBase']){
                $dbid = $orderInfo['orderBase']['productId'];
                // 产品名称
                $product = $this->product->getProductNameAndStartCity($dbid);
                $productName = $product['start_city_name'].' :'.$product['product_name'];
                // 供用商编号
                $productCode = $this->product->getProductCodeBydbid($dbid);
                $productCode = isset($productCode['product_code'])?$productCode['product_code']:'';

            }
            if(isset($orderInfo['paymentDetails']) && $orderInfo['paymentDetails']){
                foreach ($orderInfo['paymentDetails'] as $detail){
                    $money += $detail['fundMoney'];
                }
            }
            $order= $this->order;

            $data = compact('orderInfo','productName','productCode','order','money');
            //var_dump($data);
        }

        $this->load->view('order/detail',$data);
        $this->common_footer();
    }



}
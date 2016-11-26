<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 16:27
 */

class Inter extends Base_Controller {


    public function __construct(){

        parent::__construct();
        $this->loadInterface('Group_interface','interface'); // 用哪个加载哪个类

    }

    public function demo(){

        $result = Group_interface::getProductInfo(array(124343));
        var_dump($result);die;
    }

    public function getLibCurl(){
        $params =array(
            'couponCode'=>'100105302232',
            'secret'    =>'b41c071c89d41a22896198d73e46fbd8',
            'stamp'     =>'1476842557',
            'uid'       =>'1565947'
        );
        $result = Group_interface::cancelOrder($params);
        var_dump(json_decode($result,true));
    }

    public function getSaleList(){

        $result = Group_interface::saleList(array('id'=>12345));
        $this->load->library('pagination');
        $this->load->config('pagination',true); // 引进文件，同时想要修改样式，pagination.php 中的class="pagination"
        $config = $this->config->config['pagination'];

        $this->load->helper('url');
        $config['base_url'] =$config['base_url'].'/page';

        $config['total_rows'] = 200;  // 后端接口或是数据库的数据条数。
        $config['per_page'] = 20;    //每一页显示的数据条数

        $this->pagination->initialize($config);
        var_dump($result);
        echo $this->pagination->create_links();

    }
}
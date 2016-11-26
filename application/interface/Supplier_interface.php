<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/23
 * Time: 16:58
 */

class Supplier_interface extends Base_Interface
{


    /**
     * 返回订单内容
     * @param $url
     * @param array $params
     * @return mixed
     */
    public static function getOrderListInfo($params = array())
    {

        $url = config_item('supplier_order_url');// 一个完整的URL
        $queryStr = http_build_query($params);
        $url = $url.'?'.urldecode($queryStr);

        $result = self::curlGet($url);
        return $result;

    }

    public static function getOrderInfo($params){

        $url = config_item('supplier_order_detail');// 一个完整的URL
        //var_dump($url,$params);die;
        $result = self::curlGet($url, $params);

        return $result;
    }

}
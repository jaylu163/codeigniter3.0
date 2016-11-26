<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 16:15
 */
 class Group_interface extends Base_Interface{

      //public $url;

      //public static $curl;
      //public static $uriInterface = array();
      //public static $baseController = array();

     /**
      * 返回详情内容
      * @param $url
      * @param array $params
      * @return mixed
      */
      public static function getProductInfo($params=array()){

          $url = config_item('center_url');// 一个完整的URL
          //var_dump($url,$params);die;
          $result = self::libCurl($url,$params);
          return $result;

      }

     /**
      * 添加订单
      * @param $url
      * @param array $params
      */
      public static function addOrder($params=array()){
          $url = config_item('MUMBER_CENTER_URL');
          $result = self::curlPost($url,$params);
          return $result;
      }

     /**
      * 取消订单
      * @param $url
      * @param array $params
      */
      public static function cancelOrder($params=array()){

          $url = 'groupapi.caissa.com.cn/demo/json';

          $result = self::libCurl($url,$params,'get');
          return $result;
      }

      public static function saleList($params=array()){
          $url = 'http://172.16.37.180:8180/openapi/group/search.do?channel_id=5316659b5d4f4996aa4eebc0d60c8471&show_type=1&product_db_id=1f8fe86d7682406caa8587fcfca9343f';

          $result = self::curlGet($url,$params);
          return $result;
      }
    /**
     * 通过接口查询出发城市
     */
    public static function getStartCity($params = array()){
        $baseParam = array(
            'port' => '55888',
            'owner' => 'caissa',
            'p' => 'k10100',
            'searchnum' => '1',
            'sclass' => '1',
            'wclassnum' => '1'
        );
        $params = array_merge($baseParam, $params);
        //获取接口地址
        $api_url = config_item('SEARCH_API_HOST');
        $result = self::curlGet($api_url, $params);
        return $result;
    }
    /**
     * 通过接口查询目的国家
     */
    public static function getDesCountry($params = array()){
        $baseParam = array(
            'port' => '55888',
            'owner' => 'caissa',
            'p' => 'country',
            'searchnum' => '1',
            'sclass' => '1',
            'wclassnum' => '1'
        );
        $params = array_merge($baseParam, $params);
        //获取接口地址
        $api_url = config_item('SEARCH_API_HOST');
        $result = self::curlGet($api_url, $params);
        return $result;
    }

}
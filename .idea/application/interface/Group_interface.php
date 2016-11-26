<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 13:08
 */
 class Group_interface {

      public $url ;

      public $params ;

      public static $curl ;

      public static $baseController;


      public static $interfaceUrl =array(
          'tuituan' => '',    // 退团url
          'xiadingdan' =>'', //  下订单

      );

      public static  function  productInfo($url='http://www.interface.com',$params){

         $result = self::$baseController->httpCurlGet($url,$params);


      }

      public static function  addOrder($url='',$params){

      }

      public static function   cancelOrder($params){



      }



 }

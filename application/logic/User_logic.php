<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 11:07
 */

 class User_logic {

     public static $name ='userLogic';

     public static $comHelper;

     public function __construct(){

         include (APPPATH.'core/Base_comhelper.php');
         self::$comHelper = new Base_comhelper();

     }
     public static function getName(){

         return self::$name;
     }



     public  function getInterface(){
         self::$comHelper->loadAppClass('Group_interface');

         $params =array(33333);
         $result = Group_interface::getProductInfo($params);
         return $result;
     }


 }
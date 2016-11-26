<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/24
 * Time: 18:10
 */
 class Order_model extends Base_Model {

     // 客人报名状态
     public $customerStatus =array(
         3     =>'扣位',
         4     =>'实排',
         5     =>'系统销位',
         6     =>'退团申请',
         7     =>'已退团',
         8     =>'网站销位',
         9     =>'客人销位',
         10    =>'订调销位',

     );

     public $sex =array(
          1    =>'男',
          2    =>'女'
     );
     // 客户类型
     public $customerType= array(
         '01'   =>'成人',
         '02'   =>'儿童',
         '03'   =>'婴儿'
     );
 }
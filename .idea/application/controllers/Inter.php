<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/10/24
 * Time: 13:42
 */
class Inter extends Base_Controller{

    protected $model;

    protected $groupInstance;

    public function __construct(){

        parent::__construct();
        $this->loadInterface('Group_interface');// 用到哪个掊口，加载哪个方法

    }

    public function demo(){

        $result = Group_interface::productInfo($params=array(222));
        var_dump($result);
    }

    public function demo1(){


    }
}
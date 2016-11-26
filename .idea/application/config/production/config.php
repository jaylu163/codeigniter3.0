<?php


//自定义静态文件域名
$config['STATIC_HOST'] = 'http://imgs.caissa.com.cn/';
//签证校验
$config['check_sign'] = true;//是否开启验签
$config['timeout'] = 10;//验签超时时间,单位秒
$config['sign_key'] = '7F43F527E0966C5B4A7E1285AB7ED44A';//验签盐值
//日志级别
/*
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
 */
$config['log_threshold']  = 2;
//sql日志
$config['sql_log']   = false;
$config['email_user_list'] = array('guoyonghua@caissa.com.cn','anyongbin@caissa.com.cn','luhuajun@caissa.com.cn');//报警邮件专用地址
/***erp相关接口start***/


//会员中心接口地址
//$config['MUMBER_CENTER_URL'] = 'http://172.16.37.93:8080/user-common/webservice/v1_0_0';
$config['MUMBER_CENTER_URL'] = 'http://cis.caissa.me/openapi/';
$config['SEARCH_API_URL'] = 'http://www.searchapi.com';//搜索API
$config['MUMBER_DOMAINS'] = array(
    'http://bbs.caissa.com.cn/member.php?mod=logging&action=api_mlogin&loginbykey=',
    'http://www.caissayl.com/ws/login.ashx?action=loginbykey&key=',
    'http://dj.caissa.com.cn/passclient/index.php?key=',
);
$config['MUMBER_LOGINOUT_DOMAINS'] = array(
    'http://dj.caissa.com.cn/passclient/index.php?act=loginout',
    'http://bbs1.caissa.com.cn/member.php?mod=logging&action=api_logout',
    'http://www.caissayl.com/ws/login.ashx?action=loginout',
);

$config['ERP_ORDER_IS_PAY'] = $erp_new_host.'/freeline/servlet/v1/OrderServlet?method=createFreelineOrder';

//官网手机注册接口
//$config['USER_REGISTER_URL'] = 'http://80.66.40.99:8010/usermobile.ashx?action=register';
$config['USER_REGISTER_URL'] = 'http://caissawebapi.caissa.com.cn:8010/usermobile.ashx?action=register';

//ERP接口地址
$config['ERP_INTERFACE_URL'] = $erp_new_host.'/freeline/servlet/';
//主库配置
$config['CENTRAL_MYSQL_HOST'] = '10.0.8.186';
$config['CENTRAL_MYSQL_PORT'] = '3306';
$config['CENTRAL_MYSQL_DB'] = 'zyx_main';
$config['CENTRAL_MYSQL_USER'] = MYSQL_USER;
$config['CENTRAL_MYSQL_PASSWORD'] = MYSQL_PASSWORD;


//从数据库
$config['SLAVE_MYSQL_HOST'] = '10.0.8.175';
$config['SLAVE_MYSQL_PORT'] = '3306';
$config['SLAVE_MYSQL_DB'] = 'zyx_main';
$config['SLAVE_MYSQL_USER'] = MYSQL_USER;
$config['SLAVE_MYSQL_PASSWORD'] = MYSQL_PASSWORD;

//队列库
$config['QUEUE_MYSQL_HOST'] = '10.0.8.186';
$config['QUEUE_MYSQL_PORT'] = '3306';
$config['QUEUE_MYSQL_DB'] = 'zyx_queue';
$config['QUEUE_MYSQL_USER'] = MYSQL_USER;
$config['QUEUE_MYSQL_PASSWORD'] = MYSQL_PASSWORD;

//order主库配置
$config['ORDER_MYSQL_HOST'] = '10.0.8.186';
$config['ORDER_MYSQL_PORT'] = '3306';
$config['ORDER_MYSQL_DB'] = 'zyx_order';
$config['ORDER_MYSQL_USER'] = MYSQL_USER;
$config['ORDER_MYSQL_PASSWORD'] = MYSQL_PASSWORD;


//order从数据库
$config['SORDER_MYSQL_HOST'] = '10.0.8.175';
$config['SORDER_MYSQL_PORT'] = '3306';
$config['SORDER_MYSQL_DB'] = 'zyx_order';
$config['SORDER_MYSQL_USER'] = MYSQL_USER;
$config['SORDER_MYSQL_PASSWORD'] = MYSQL_PASSWORD;


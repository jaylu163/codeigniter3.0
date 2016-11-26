<?php
//自定义静态文件域名
$config['STATIC_HOST'] = 'http://groupapi.caissa.com.cn/';
//签证校验
$config['check_sign'] = false;//是否开启验签
$config['timeout'] = 10;//验签超时时间,单位秒
$config['sign_key'] = '70E25424897D881997554C1A1F0CC909';//验签盐值
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
$config['sql_log']   = true;
/*$config['email_user_list'] = array(
			'zhangcunchao@caissa.com.cn',
			'baihuina@rayootech.com',
			'anyongbin@caissa.com.cn'
);*///报警邮件专用地址
/***erp相关接口start***/

$config['ERP_ORDER_IS_PAY'] = 'http://172.16.37.166:8080/freeline/servlet/v1/OrderServlet?method=createFreelineOrder';

//官网手机注册接口
//$config['USER_REGISTER_URL'] = 'http://80.66.40.99:8010/usermobile.ashx?action=register';
$config['USER_REGISTER_URL'] = 'http://caissawebapi.caissa.com.cn:8010/usermobile.ashx?action=register';

//新参团接口
//$config['GROUP_DETAIL_URL'] = 'http://172.16.37.180:8180/openapi/';//开发环境
$config['GROUP_DETAIL_URL'] = 'http://172.16.37.119:8180/openapi/';//测试环境

//会员中心接口地址
//$config['MUMBER_CENTER_URL'] = 'http://172.16.37.93:8080/user-common/webservice/v1_0_0';
$config['MUMBER_CENTER_URL'] = 'http://172.16.37.180:8180/openapi/';
$config['MUMBER_CENTER_URL_OLD']='http://172.16.37.113:8180/caissa-api/';
$config['SEARCH_API_URL'] = 'http://www.searchapi.com';//搜索API
$config['MUMBER_DOMAINS'] = array(
    'http://djtest.caissa.com.cn:90/passclient/index.php?key=',
    'http://bbs1.caissa.com.cn/member.php?mod=logging&action=api_mlogin&loginbykey=',
    'http://www.caissayl.com/ws/login.ashx?action=loginbykey&key=',
);
$config['MUMBER_LOGINOUT_DOMAINS'] = array(
    'http://djtest.caissa.com.cn:90/passclient/index.php?act=loginout',
    'http://bbs1.caissa.com.cn/member.php?mod=logging&action=api_logout',
    'http://www.caissayl.com/ws/login.ashx?action=loginout',
);

$config['CENTRAL_MYSQL_HOST'] = '127.0.0.1';
$config['CENTRAL_MYSQL_PORT'] = '3306';
$config['CENTRAL_MYSQL_DB'] = 'zyx_main';
$config['CENTRAL_MYSQL_USER'] = 'root';
$config['CENTRAL_MYSQL_PASSWORD'] = "";

//zyx_logs库
$config['LOG_MYSQL_HOST'] = '172.16.19.232';
$config['LOG_MYSQL_PORT'] = '3306';
$config['LOG_MYSQL_DB'] = 'zyx_logs';
$config['LOG_MYSQL_USER'] = MYSQL_USER;
$config['LOG_MYSQL_PASSWORD'] = MYSQL_PASSWORD;


/*
//主库配置
$config['CENTRAL_MYSQL_HOST'] = '172.16.19.232';
$config['CENTRAL_MYSQL_PORT'] = '3306';
$config['CENTRAL_MYSQL_DB'] = 'zyx_main';
$config['CENTRAL_MYSQL_USER'] = MYSQL_USER;
$config['CENTRAL_MYSQL_PASSWORD'] = MYSQL_PASSWORD;
//从数据库
$config['SLAVE_MYSQL_HOST'] = '172.16.19.232';
$config['SLAVE_MYSQL_PORT'] = '3306';
$config['SLAVE_MYSQL_DB'] = 'zyx_main';
$config['SLAVE_MYSQL_USER'] = MYSQL_USER;
$config['SLAVE_MYSQL_PASSWORD'] = MYSQL_PASSWORD;

//队列库
$config['QUEUE_MYSQL_HOST'] = '172.16.19.232';
$config['QUEUE_MYSQL_PORT'] = '3306';
$config['QUEUE_MYSQL_DB'] = 'zyx_queue';
$config['QUEUE_MYSQL_USER'] = MYSQL_USER;
$config['QUEUE_MYSQL_PASSWORD'] = MYSQL_PASSWORD;

//order主库配置
$config['ORDER_MYSQL_HOST'] = '172.16.19.232';
$config['ORDER_MYSQL_PORT'] = '3306';
$config['ORDER_MYSQL_DB'] = 'zyx_order';
$config['ORDER_MYSQL_USER'] = MYSQL_USER;
$config['ORDER_MYSQL_PASSWORD'] = MYSQL_PASSWORD;


//order从数据库
$config['SORDER_MYSQL_HOST'] = '172.16.19.232';
$config['SORDER_MYSQL_PORT'] = '3306';
$config['SORDER_MYSQL_DB'] = 'zyx_order';
$config['SORDER_MYSQL_USER'] = MYSQL_USER;
$config['SORDER_MYSQL_PASSWORD'] = MYSQL_PASSWORD;*/

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|   reids:172.16.19.232:6379?auth=zyxadmin&prefix=jptb_sess:&database=2&timeout=0
|   memcached:172.16.19.232:11211:1,linux下可用
|
 */
//session库配置
//$config['SESSION_MYSQL_HOST'] = '127.0.0.1';
//$config['SESSION_MYSQL_PORT'] = '3306';
//$config['SESSION_MYSQL_DB'] = 'zyx_main';
//$config['SESSION_MYSQL_USER'] = 'root';
//$config['SESSION_MYSQL_PASSWORD'] = '';

//session配置选项
$config['sess_driver'] = 'redis';
$config['sess_cookie_name'] = 'jptb_session';
$config['sess_expiration'] = 3600;
//$config['sess_save_path'] ='ci_sessions';
//$config['sess_database'] ='session';
//$config['sess_save_path'] = '172.16.19.232:11211:1';
$config['sess_save_path'] = 'tcp://172.16.19.232:6379?auth=zyxadmin&prefix=jptb_sess:&database=2&timeout=0';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

//微信相关
$config['sell_app_id'] = 'wxba9dfc8b27f69798';//卖家版应用ID
$config['sell_app_secret'] = '2f2de0c12e17a613de2ef3421e767252';//卖家版应用密钥

$config['buy_app_id'] = 'wx1df8c2446ad2e1d1';//买家版应用ID
$config['buy_app_secret'] = '990ae97168de2ad9afcf755838502e06';//买家版应用密钥

//ERP接口
$config['ERP_INTERFACE_URL'] = 'http://172.16.37.166:8080/freeline/servlet/';

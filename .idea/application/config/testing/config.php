<?php

//自定义静态文件域名
$config['STATIC_HOST'] = 'http://groupapi.caissa.com.cn/';
$config['IMG_STATIC_HOST'] = 'http://172.16.19.232/';
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
$config['log_threshold']   = 2;
$config['orderPagesize']  = 10;
$config['jporderPagesize']  = 9;
//$config['wechatkey'] = 'wechat1.0'
//sql日志
$config['sql_log']   = false;
$config['email_user_list'] = array('zhangcunchao@caissa.com.cn','haixiad@rayootech.com','fulongl@rayootech.com','baihuina@rayootech.com','niuzhenxiang@rayootech.com');
$api_host = 'http://172.16.37.91:8082/api/v1';//不带反斜线
$config['API_HOST'] = $api_host;

$config['MUMBER_CENTER_URL'] = 'http://172.16.37.180:8180/openapi/';
$config['SEARCH_API_URL'] = 'http://www.searchapi.com';//搜索API
$config['DJ_URL'] = 'http://172.16.19.232:90/';

$config['SEARCH_INT_URL'] = 'http://172.16.37.119:8180/';//搜索接口 
//新参团接口
//$config['GROUP_DETAIL_URL'] = 'http://172.16.37.180:8180/openapi/';//开发环境
$config['GROUP_DETAIL_URL'] = 'http://172.16.37.119:8180/openapi/';//测试环境

// 重置密码
$config['GET_UID_URL'] = 'http://ws.caissa.com.cn/usermobile.ashx?action=checkuser&username=';
$config['UPDATE_PASS_URL'] = 'http://ws.caissa.com.cn/3gUser.ashx?action=updatepwd&';

$config['TMP_UP_PIC'] = '/tmp/tmp_upload_files/';	//未处理临时存放
$config['COMPRESS_PIC'] = '/tmp/compress_pic_files/';     //压缩处理过的
//产品库存校验接口 例子:
//$config['CHECK_PRODUCT_CACHE']     = $api_host.'/check_product_cache';


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

//session配置选项
$config['sess_driver'] = 'redis';
$config['sess_cookie_name'] = 'wap_sess';
$config['sess_expiration'] = 3600;
//$config['sess_save_path'] ='/data/log/wap/ci_sessions';
//$config['sess_database'] ='session';
//$config['sess_save_path'] = '172.16.19.232:11211:1';
$config['sess_save_path'] = 'tcp://172.16.19.232:6379?auth=zyxadmin&prefix=wap_sess:&database=5&timeout=20';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;


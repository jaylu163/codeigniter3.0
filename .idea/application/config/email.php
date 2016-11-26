<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/6
 * Time: 15:39
 */

$config['subject']   = '邮件标题';

$config['host']      = 'smtp.caissa.com.cn';    // 邮件服务器

$config['username']  = 'system_zyx@caissa.com.cn';  // 用户名 system_zyx@caissa.com.cn

$config['password']  = 'CaiSsa!Zqp*NSy8h'; // 密码

$config['port']      = 25;                 // 端口;

$config['auth']      = true;  // 邮件发送开启认证

$config['from']      = 'system_zyx@caissa.com.cn';  // 发件地址 system_zyx@caissa.com.cn

$config['fromname']  = 'group';  // 发件名字

$config['to']        = 'luhuajun@caissa.com.cn';  // 多个人可以逗号分隔或者是放在一个数组中

$config['protocol']  = 'sendmail';

$config['mailpath']  = '/usr/sbin/sendmail';

$config['charset']   = 'utf-8';

$config['wordwrap']  = 80;  // 设置每行字符串的长度;

$config['is_html'] = true;  // html文件内容支持

$config['attachment'] = '';// 附件 服务器文件路径

$config['is_send_mail'] = true; // 是否发邮件


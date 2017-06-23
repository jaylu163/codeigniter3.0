<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// 系统执行的早期调用

$hook['pre_system']=array(
    'class'    => 'GlobalTranceHandler',
    'function' => 'SetTranceHandler',
    'filename' => 'GlobalTranceHandler.php',
    'filepath' => 'hooks',

);

// 控制器调用之前执行

$hook['pre_controller'][] = array(
    'class'    => 'ExceptionHook',
    'function' => 'SetExceptionHandler',
    'filename' => 'ExceptionHook.php',
    'filepath' => 'hooks'
);

$hook['pre_controller'][] = array(
    'class'    => 'SyntaxHook',
    'function' => 'SetSyntaxHandler',
    'filename' => 'SyntaxHook.php',
    'filepath' => 'hooks',

);

// 控制器实例化之后执行
$hook['post_controller_constructor'] = array(
    'class'    => 'ManageHook',
    'function' => 'SetHandler',
    'filename' => 'ManageHook.php',
    'filepath' => 'hooks',

);

//在控制器完全运行结束时执行
$hook['post_controller'] =array(
    'class'    => 'ManageHook',
    'function' => 'SetFinalHandler',
    'filename' => 'ManageHook.php',
    'filepath' => 'hooks',
);

// 最终的页面发送到浏览器之后、在系统的最后期被调用
$hook['post_system'] =array(
    'class'    => 'ManageHook',
    'function' => 'SetFinalBrowserHandler',
    'filename' => 'ManageHook.php',
    'filepath' => 'hooks',
);


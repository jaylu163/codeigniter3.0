<?php
//redis缓存设置
$config['redis_cache'] = array(
    'socket_type' => 'tcp',
    'host' => '172.16.19.232',
    'password' => 'zyxadmin',
    'port' => 6379,
    'db'   => 11,
    'timeout' => 300
);
$config['memcached_cache'] = array(
    'default' => array(
        'hostname' => '172.16.19.232',
        'port'     => '11211',
        'weight'   => '1',
    ),
);
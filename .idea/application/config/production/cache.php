<?php
//redis缓存设置
$config['redis_cache'] = array(
    'socket_type' => 'tcp',
    'host' => '10.0.8.214',
    'password' => 'caissa',
    'port' => 6379,
    'db'   => 11,
    'timeout' => 0
);
$config['memcached_cache'] = array(
    'default' => array(
        'hostname' => '80.66.40.140',
        'port'     => '11211',
        'weight'   => '1',
    ),
);
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
//$active_group = 'default';
//$query_builder = TRUE;

$active_group = 'main';
$active_record = TRUE;

$_master_slave_relation = array(
    'main'    => array('main_slave'),
    'queue'   => array('queue'),
    'order'   => array('order_slave'),
    'cache'   => array('cache_slave'),
    'log'     => array('log_slave'),
    'session' => array('session'),
    'hd'      => array('hd_slave'),
    'wechat'  => array('slave_wechat'),
    'st'      => array('st_slave'),
);
//主库
$db['main'] = array(
	'dsn'	=> '',
	'hostname' => config_item('CENTRAL_MYSQL_HOST'),
	'username' => config_item('CENTRAL_MYSQL_USER'),
	'password' => config_item('CENTRAL_MYSQL_PASSWORD'),
	'database' => config_item('CENTRAL_MYSQL_DB'),
    'port'     => config_item('CENTRAL_MYSQL_PORT'),
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
//从库
$db['main_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SLAVE_MYSQL_HOST'),
    'username' => config_item('SLAVE_MYSQL_USER'),
    'password' => config_item('SLAVE_MYSQL_PASSWORD'),
    'database' => config_item('CENTRAL_MYSQL_DB'),
    'port'     => config_item('SLAVE_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//cache主库
$db['cache'] = array(
    'dsn'	=> '',
    'hostname' => config_item('CACHE_MYSQL_HOST'),
    'username' => config_item('CACHE_MYSQL_USER'),
    'password' => config_item('CACHE_MYSQL_PASSWORD'),
    'database' => config_item('CACHE_MYSQL_DB'),
    'port'     => config_item('CACHE_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
//cache从库
$db['cache_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SCACHE_MYSQL_HOST'),
    'username' => config_item('SCACHE_MYSQL_USER'),
    'password' => config_item('SCACHE_MYSQL_PASSWORD'),
    'database' => config_item('SCACHE_MYSQL_DB'),
    'port'     => config_item('SCACHE_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//队列库
$db['queue'] = array(
    'dsn'	=> '',
    'hostname' => config_item('QUEUE_MYSQL_HOST'),
    'username' => config_item('QUEUE_MYSQL_USER'),
    'password' => config_item('QUEUE_MYSQL_PASSWORD'),
    'database' => config_item('QUEUE_MYSQL_DB'),
    'port'     => config_item('QUEUE_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//session库
$db['session'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SESSION_MYSQL_HOST'),
    'username' => config_item('SESSION_MYSQL_USER'),
    'password' => config_item('SESSION_MYSQL_PASSWORD'),
    'database' => config_item('SESSION_MYSQL_DB'),
    'port'     => config_item('SESSION_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//order主库
$db['order'] = array(
    'dsn'	=> '',
    'hostname' => config_item('ORDER_MYSQL_HOST'),
    'username' => config_item('ORDER_MYSQL_USER'),
    'password' => config_item('ORDER_MYSQL_PASSWORD'),
    'database' => config_item('ORDER_MYSQL_DB'),
    'port'     => config_item('ORDER_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
//ORDER从库
$db['order_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SORDER_MYSQL_HOST'),
    'username' => config_item('SORDER_MYSQL_USER'),
    'password' => config_item('SORDER_MYSQL_PASSWORD'),
    'database' => config_item('SORDER_MYSQL_DB'),
    'port'     => config_item('SORDER_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//cache主库
$db['log'] = array(
    'dsn'	=> '',
    'hostname' => config_item('LOG_MYSQL_HOST'),
    'username' => config_item('LOG_MYSQL_USER'),
    'password' => config_item('LOG_MYSQL_PASSWORD'),
    'database' => config_item('LOG_MYSQL_DB'),
    'port'     => config_item('LOG_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
//cache从库
$db['log_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SLOG_MYSQL_HOST'),
    'username' => config_item('SLOG_MYSQL_USER'),
    'password' => config_item('SLOG_MYSQL_PASSWORD'),
    'database' => config_item('SLOG_MYSQL_DB'),
    'port'     => config_item('SLOG_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//cache主库
$db['hd'] = array(
    'dsn'	=> '',
    'hostname' => config_item('HD_MYSQL_HOST'),
    'username' => config_item('HD_MYSQL_USER'),
    'password' => config_item('HD_MYSQL_PASSWORD'),
    'database' => config_item('HD_MYSQL_DB'),
    'port'     => config_item('HD_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
//cache从库
$db['hd_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SHD_MYSQL_HOST'),
    'username' => config_item('SHD_MYSQL_USER'),
    'password' => config_item('SHD_MYSQL_PASSWORD'),
    'database' => config_item('SHD_MYSQL_DB'),
    'port'     => config_item('SHD_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

// st_platform 三体主库
$db['st'] = array(
    'dsn'	=> '',
    'hostname' => config_item('ST_MYSQL_HOST'),
    'username' => config_item('ST_MYSQL_USER'),
    'password' => config_item('ST_MYSQL_PASSWORD'),
    'database' => config_item('ST_MYSQL_DB'),
    'port'     => config_item('ST_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
//st_platform 三体从库
$db['st_slave'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SST_MYSQL_HOST'),
    'username' => config_item('SST_MYSQL_USER'),
    'password' => config_item('SST_MYSQL_PASSWORD'),
    'database' => config_item('SST_MYSQL_DB'),
    'port'     => config_item('SST_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//微商主库
$db['wechat'] = array(
    'dsn'	=> '',
    'hostname' => config_item('WS_MYSQL_HOST'),
    'username' => config_item('WS_MYSQL_USER'),
    'password' => config_item('WS_MYSQL_PASSWORD'),
    'database' => config_item('WS_MYSQL_DB'),
    'port'     => config_item('WS_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

//微商从库
$db['slave_wechat'] = array(
    'dsn'	=> '',
    'hostname' => config_item('SLAVE_WS_MYSQL_HOST'),
    'username' => config_item('SLAVE_WS_MYSQL_USER'),
    'password' => config_item('SLAVE_WS_MYSQL_PASSWORD'),
    'database' => config_item('SLAVE_WS_MYSQL_DB'),
    'port'     => config_item('SLAVE_WS_MYSQL_PORT'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
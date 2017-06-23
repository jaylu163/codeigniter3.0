<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2017/6/14
 * Time: 17:30
 */
require __DIR__.'/plugin/monolog/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Monolog {

        public static function logWrite($message){
            $log = new Logger('trance_monolog');
            $serverName = $_SERVER['SERVER_NAME'];
            $tranceLogName= '/data/log/'.$serverName.'/trance_'.date('Y-m-d').'.log';
            //var_dump($tranceLogName);die;
            $log->pushHandler(new StreamHandler($tranceLogName, Logger::INFO));
            $log->info($message);

        }
}
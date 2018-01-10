<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2017/4/15
 * Time: 16:02
 */

class Redislogshell extends Base_Controller{


    protected $redis;
    protected $database;
    public function __construct(){

        parent::__construct();

        $this->redis = $this->loadRedis();

    }


    public function insertDbLog($table,$database=''){
        $database = $this->getDatabase($database);
        //while (true){
            $result =$this->redis->rpop($table);
            if(!empty($result)){
                $data = json_decode($result,true);
                $database->insert($table,$data);
            }else{
                print_r('current  redis '.$table.' is null '."\n");
                sleep(3);
            }

       // }

    }

    /**
     * @param $db int
     * @return Redis
     */
    protected  function loadRedis(){

        $redis = new Redis();
        $this->load->config(ENVIRONMENT.'/redis');
        $config=get_instance()->config->config;

        $host =  $config['redis_cluster_host'];
        $port =  $config['redis_cluster_port'];
        $timeout = $config['redis_cluster_timeout'];
        $redis->connect($host,$port,$timeout);

        return $redis;

    }

    /**
     * @param $database
     */
    protected function getDatabase($database){
        if($database){
            $database = $this->load->database($database,true);
        }else{
            $database = $this->load->database('log',true);
        }

        return $database;
    }
}
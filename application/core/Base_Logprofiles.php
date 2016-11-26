<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/9/8
 * Time: 9:30
 */

$includedFiles = get_included_files();
$modelFile =BASEPATH .'core'.DIRECTORY_SEPARATOR.'Model.php';
if(array_search($modelFile,$includedFiles) ==false){
    include BASEPATH .'core/Model.php';
}

class Base_Logprofiles extends CI_Model {

    protected $levels = array(
        '1'=>'ERROR' ,
        '2' => 'DEBUG',
        '3'=> 'INFO',
        '4'=>'ALL'
    );

    /**
     * 组合log要用的数据
     * @return array
     */
    protected   function getInfo(){

        $querySql  = isset($this->db)?($this->db->queries): ' ';  // sql 语句;
        $queryTime = isset($this->db)?($this->db->query_times): ' '; // 加载时间;
        $uri = $this->uri->uri_string;
        $params =$this->uri->segments;
        $baseUrl = $this->config->config['base_url'];
        $logTh = $this->config->config['log_threshold'];
        $marker = $this->benchmark->marker;
        $message = array(
            'querySql' =>$querySql,
            'queryTime' =>$queryTime,
            'uri'       =>$uri,
            'params'    =>$params,
            'baseUrl'   =>$baseUrl,
            'logLevel'  =>$logTh,
            'marker'    =>$marker
        );
        return $message;
    }

    /**
     * @return mixed
     */
    public function writeLog($level=''){

        $message = $this->getInfo();
        if(! empty($level)){
            $level   =isset($this->levels[$message['logLevel']])?$this->levels[$message['logLevel']]:'';
        }
        $message =json_encode($message);

       return  $this->log->write_log($level,$message);
    }

    public function writeRedis($message){

        // 写redis;
    }
}
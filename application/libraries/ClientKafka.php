<?php
/**
 * Created by PhpStorm.
 * User: luhuajun
 * Date: 2016/11/23
 * Time: 13:02
 */

$flag = require 'plugin/kafka-php/autoloader.php';


class LogWriter {
    public function log($message, $level) {
        echo $message, PHP_EOL;
    }
}

$log = new LogWriter;
//\Kafka\Log::setLog($log);

//$zookeeperList = getenv('ZOOKEEPER_LIST');
//$consumer = \Kafka\Consumer::getInstance($zookeeperList);

use \Kafka\Consumer as clientConsumer;
use \Kafka\Produce  as clientProduce;

class ClientKafka {

    private $consumer=null;

    public function __construct(){



    }


    /**
     * 取消息
     * @param $consumer
     * @param string $group
     * @param string $topic
     * @param $hostList
     * @return array| object
     */
    public function getConsumerMsg(clientConsumer $consumer ,$group= 'test',$topic='test'){

        if(empty($consumer)){

            return array(
                'msg'=>'kafka instance null ',
                'code' =>303
            );
        }
        try{
            //$consumer = \Kafka\Consumer::getInstance($hostList);

            $consumer->setGroup($group);
            $consumer->setFromOffset(true);
            $consumer->setTopic($topic);
            $consumer->setMaxBytes(102400);
            $result = $consumer->fetch();

            return $result;

        }catch (Exception $e) {

            return array(
                'code'=>$e->getCode(),
                'mes'=>'数据异常',
                'exception'=>$e->getMessage(),
                'line'    =>$e->getLine(),
                'file'    =>$e->getFile()
            );

        }

    }


    /**
     * 发送消息
     * @param $produce
     * @param $topic
     * @param $message
     * @param $hostList
     * @return array
     */
    public function setProduce (clientProduce $produce ,$topic,$message){

        try {
            // $produce = \Kafka\Produce::getInstance($hostList);
            $produce->setRequireAck(-1);

            $produce->setMessages($topic, 0, array($message));

            $result = $produce->send();

            return $result;

        } catch (Exception $e) {

            return array(

                'code'=>506,
                'mes'=>'数据异常',
                'exception'=>$e->getMessage()
            );
        }


    }

    /**
     * 取得 zookeeper 单例
     * @param $hostList
     * @return \Kafka\Consumer
     */
    public function getConsumerInstance($hostList){

        $consumer = clientConsumer::getInstance($hostList);

        return $consumer;

    }

    /**
     * 设置 zookeeper 单例
     * @param $hostList
     * @param $timeout
     * @return clientProduce
     */
    public function setProduceInstance($hostList,$timeout){

        $produce = clientProduce::getInstance($hostList,$timeout);

        return $produce;
    }

}

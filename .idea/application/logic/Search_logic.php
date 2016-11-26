<?php
/**
 * Created by Search
 * User: Gyh
 * Date: 2016/9/20
 * Time: 16:24
 */
Class Search_logic {
    public $curl ;
    //构造函数
    public function __construct($curl){

        $this->curl =$curl;

    }

    public  function curl_api($api_url,$_data=array()){
        $rs  = trim($this->curl->simple_post($api_url,$_data));
        $rs  = json_decode($rs,true);
        if(!empty($rs)){
            return $rs;
        }else{
            $mes  = '接口地址：'.$api_url;
            $mes .= '<br>上行参数：'.var_export($_data,true);
            $mes .='<br>下行参数：'.$rs;
            //waring_email('接口错误',$mes);
            return false;
        }

    }

    public  function KeywordsSearch($keywords,$pagesize){

        $api_url = config_item('FUSION_URL').'merge/search.do';

        $_data = array(
            'keyword'   => $keywords,
            'pagesize'  => $pagesize?$pagesize:15,
        );
        $result =  $this->curl_api($api_url,$_data);

        return $result;
    }
}
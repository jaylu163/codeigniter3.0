<?php
/**
 * 新参团详情页api
 * aouthor Gyh
 */
Class Detail extends Base_Controller{
    public function __construct(){
        parent::__construct();
    }

	/**
	 * 新参团详情页基础信息api
	 * param db_id 团ID
	 * param channel_id 渠道ID
	 */
    public function DetailInfo()
    {
        $db_id		= $this->input->get_post('db_id');//dc15d93703734a8297f4d05b55bdbf27
        $channel_id = $this->input->get_post('channel_id');//d2be22379bd0494b8ca97b4e94cbc42f
		if(!$db_id)
		{
			return $this->jsonFormat(203,array(),'团号为空');
		}
		if(!$channel_id)
		{
			return $this->jsonFormat(204,array(),'渠道号为空');
		}
		parent::loadLogicClassName('Detail_logic', 'logic');
        $detail_logic = new Detail_logic();
        $api_url = config_item('GROUP_DETAIL_URL').'group/info.do';
		$param = array(
			'db_id'   => $db_id,
			'channel_id'  => $channel_id,
		);

		$result = $this->httpCurlGet($api_url,$param);

	    $r_data = $detail_logic->Detail_Info_Logic($result);
		foreach($r_data['params']['attributes']['daily_schedule'] as $k=>$v)
		{
			if(isset($v['schedule_shop']))
			{
				foreach($v['schedule_shop'] as $ks=>$vs)
				{
					if('3' == $vs['resource_type'])
					{
						$rdata = $this->Find_resources($vs['resource_db_id']);
						$rdata = json_decode($rdata,true);
						$r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop']['attractions'][] = $rdata['data']['params'];
						unset($r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop'][$ks]);
					}
					elseif('2' == $vs['resource_type'])
					{
						$rdata = $this->Find_resources($vs['resource_db_id']);
						$rdata = json_decode($rdata,true);
						$r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop']['duty_free'][] = $rdata['data']['params'];
						unset($r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop'][$ks]);
					}
					elseif('1' == $vs['resource_type'])
					{
						$rdata = $this->Find_resources($vs['resource_db_id']);
						$rdata = json_decode($rdata,true);
						$r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop']['buy_shop'][] = $rdata['data']['params'];
						unset($r_data['params']['attributes']['daily_schedule'][$k]['schedule_shop'][$ks]);
					}
				}
			}
		}
		
        return $this->jsonFormat(200,$r_data,$r_data['error']);
    }
	/**
	 * 新参团详情页日历接口
	 */
    public function Calendar()
    {
		$product_db_id		= $this->input->get_post('product_db_id');//bcc8e4fc30bc4c0f903341442e08c272
		$channel_id			= $this->input->get_post('channel_id');//
		$schedule_days		= $this->input->get_post('schedule_days');//4
		$schedule_nights	= $this->input->get_post('schedule_nights');//4
		$departure			= $this->input->get_post('departure');//101001000
		if(!$product_db_id)
		{
			return $this->jsonFormat(203,array(),'产品ID为空');
		}
		if(!$channel_id)
		{
			return $this->jsonFormat(204,array(),'渠道号为空');
		}
		if(!$schedule_days)
		{
			return $this->jsonFormat(205,array(),'团计划天数为空');
		}
		if(!$schedule_nights)
		{
			return $this->jsonFormat(206,array(),'团计划晚数为空');
		}
		if(!$schedule_nights)
		{
			return $this->jsonFormat(207,array(),'出发城市为空');
		}
		parent::loadLogicClassName('Detail_logic', 'logic');
        $detail_logic = new Detail_logic();
        $api_url = config_item('GROUP_DETAIL_URL').'group/calendar.do';
		$param = array(
			'product_db_id'	=> $product_db_id,
			'schedule_days'	=> $schedule_days,
			'schedule_nights'	=> $schedule_nights,
			'departure'  => $departure,
			'show_type'  => '1',
		);
		$result = $this->httpCurlGet($api_url,$param);
	    $r_data = $detail_logic->Detail_Calendar_Logic($result);
        return $this->jsonFormat(200,$r_data,$r_data['error']);
    }
	/**
	 * 新参团详情页资源查询接口
	 */
	 public function Find_resources($dbid = '')
	 {
		 $db_id	= $dbid?$dbid:$this->input->get_post('db_id');
		 if(!$db_id)
		 {
			 return $this->jsonFormat(201,array(),'资源ID为空');
		 }
		parent::loadLogicClassName('Detail_logic', 'logic');
        $detail_logic = new Detail_logic();
		//$api_url = config_item('GROUP_DETAIL_URL').'resource/merge_search.do';
		$api_url = 'http://172.16.37.180:8180/openapi/resource/merge_search.do';
		$param = array(
			'db_id'	=> $db_id,
		);
		$result = $this->httpCurlGet($api_url,$param);
		$r_data = $detail_logic->Detail_Resources_Logic($result);
		//$arr = $this->jsonFormat(200,$r_data,$r_data['error']);
		$msg = array(
			'code'=>'200',
			'data'=>$r_data,
			'msg'=>$r_data['error'],
		);
		return json_encode($msg);
	 }
	/**
	 * 新参团详情页库存报价接口
	 */
	 public function Instructions()
	 {
		 $teamNumber = $this->input->get_post('teamNumber')?$this->input->get_post('teamNumber'):'CAI16-PEK0110-1008076';
		 $channel_id = $this->input->get_post('channel_id');//'d2be22379bd0494b8ca97b4e94cbc42f';
		 $pagesize	 = '2';//$this->input->get_post('pagesize')?$this->input->get_post('pagesize'):'2';
		 if(!$teamNumber)
		 {
			 return $this->jsonFormat(201,array(),'资源ID为空');
		 }
		parent::loadLogicClassName('Detail_logic', 'logic');
        $detail_logic = new Detail_logic();
		$api_url = config_item('GROUP_DETAIL_URL').'/group/priceticket.do';
		//$api_url = 'http://172.16.37.180:8180/openapi/group/priceticket.do';
		$param = array(
			'teamNumber'	=> $teamNumber,
			'chanelCodes'	=> $channel_id,
		);
		$result = $this->httpCurlGet($api_url,$param);
		$r_data = $detail_logic->Detail_Instructions_Logic($result,$pagesize);
		
		return $this->jsonFormat(200,$r_data,$r_data['error']);
	 }
}
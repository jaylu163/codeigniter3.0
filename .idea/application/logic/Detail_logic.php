<?php
/**
 * Created by PhpStorm.
 * User: gyh
 * Date: 2016/9/26
 * Time: 18:41
 */

 class Detail_logic {

     public static $name ='detailLogic';

/**
 *参团接口详情页
 */
	public static function Detail_Info_Logic($data=array())
	{
		 $_data = json_decode($data,true);
		 
		 $fights = '[
    {
        "insert_date": "2016-08-12 11:17:37",
        "insert_user_id": "lvs",
        "turn_add_day": "0",
        "del_flag": "0",
        "arrive_add_day": "0",
        "out_time": "2016-08-19 08:00:00",
        "update_date": "2016-08-12 11:17:37",
        "airline_name": "大韩航空",
        "insert_user_code": "lvs",
        "team_db_id": "dfb450fecaed48f4a6675c2b7e3e222c",
        "flight_number": "KE850",
        "cabin_info": "TEST",
        "ticket_resource_id": "57FB56B7DCB548398FAB285652D1DC86",
        "db_id": "10D1389E2C994CEAB661CFA6301CF481",
        "begin_flight_date": "2016-08-19 00:00:00",
        "dept_code": "D160218174549440G4",
        "departure_airport_code": "PEK",
        "update_user_id": "lvs",
        "flight_type": "0",
        "arrive_airport_code": "ICN",
        "departure_airport_name": "首都机场",
        "flight_order": "0",
        "end_flight_date": "2016-08-19 00:00:00",
        "update_user_code": "lvs",
        "arrive_airport_name": "仁川国际机场",
        "arrive_time": "2016-08-19 11:00:00",
        "airline_code": "KE"
    },
    {
        "insert_date": "2016-08-12 11:17:37",
        "insert_user_id": "lvs",
        "turn_add_day": "0",
        "del_flag": "0",
        "arrive_add_day": "0",
        "out_time": "2016-08-20 09:00:00",
        "update_date": "2016-08-12 11:17:37",
        "airline_name": "大韩航空",
        "insert_user_code": "lvs",
        "team_db_id": "dfb450fecaed48f4a6675c2b7e3e222c",
        "flight_number": "KE851",
        "cabin_info": "TEST",
        "ticket_resource_id": "57FB56B7DCB548398FAB285652D1DC86",
        "db_id": "B21B3C62A3B14ADAB30320D102A93D91",
        "begin_flight_date": "2016-08-20 00:00:00",
        "dept_code": "D160218174549440G4",
        "departure_airport_code": "ICN",
        "update_user_id": "lvs",
        "flight_type": "1",
        "arrive_airport_code": "PEK",
        "departure_airport_name": "仁川国际机场",
        "flight_order": "1",
        "end_flight_date": "2016-08-20 00:00:00",
        "update_user_code": "lvs",
        "arrive_airport_name": "首都机场",
        "arrive_time": "2016-08-20 11:00:00",
        "airline_code": "KE"
    }
]';
		 
		 $a = json_decode($fights,true);
		 if(-1 == $_data['status'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>$_data['error']);
		 }
		 elseif(0 == $_data['status'] && !$_data['matches'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>'接口返回为空');
		 }
		 else
		 {
			 //产品亮点
			 $datas['product_rating_name'] = $_data['matches']['0']['product_rating_name'];//产品等级
			 $datas['season_name']       = $_data['matches']['0']['season_name'];//季节分类
			 $datas['product_theme']       = $_data['matches']['0']['product_theme']['name'];//产品主题
			 $datas['wifi']       = $_data['matches']['0']['wifi'];//免费wifi
			 //亮点end
			 $datas['product_db_id'] = $_data['matches']['0']['product_db_id'];//产品ID
			 $datas['product_code']  = $_data['matches']['0']['product_code'];//产品编码
			 $datas['product_name']  = $_data['matches']['0']['product_name'];//产品名称
			 $datas['sub_title']     = $_data['matches']['0']['sub_title'];//产品短标题
			 $datas['product_description']     = $_data['matches']['0']['product_description'];//产品描述
			 $datas['product_characteristic']     = $_data['matches']['0']['product_characteristic'];//产品特色			 
			 $datas['db_id']     = $_data['matches']['0']['db_id'];//团ID
			 $datas['team_number']     = $_data['matches']['0']['team_number'];//团号
			 $datas['team_name']     = $_data['matches']['0']['team_name'];//团名称
			 $datas['team_status']     = $_data['matches']['0']['team_status'];//团状态
			 $datas['travel_days']     = $_data['matches']['0']['travel_days'];//团行程天数
			 $datas['lowest_price']     = $_data['matches']['0']['lowest_price'];//产品下所有团最低价
			 $datas['full_price']     = $_data['matches']['0']['full_price'];//团行程天数
			 $datas['lowest_num']     = $_data['matches']['0']['lowest_num'];//最低价对应的原价（和成人零售价值一致）
			 $datas['surplus_num']     = $_data['matches']['0']['surplus_num'];//渠道总剩余名额
			 $datas['trip_date']     = $_data['matches']['0']['trip_date'];//出团日期
			 $datas['back_trip_date']     = $_data['matches']['0']['back_trip_date'];//回团日期
			 $datas['close_date']     = $_data['matches']['0']['close_date'];//团收客截止日
			 $datas['erp_close_date']     = $_data['matches']['0']['erp_close_date'];//团资料截止日（erp截团日期）ps:截团日期优先取该字段，如果该字段值为空，则取close_date字段的值
			 $datas['is_sale']     = $_data['matches']['0']['is_sale'];//是否是优惠团1 是；0 否
			 $datas['wifi']     = $_data['matches']['0']['wifi'];//团是否提供随行wifi1 是；0 否
			 $datas['is_minigroup']     = $_data['matches']['0']['is_minigroup'];//团是否是精品小团1 是；0 否
			 $datas['is_quality_airline']     = $_data['matches']['0']['is_quality_airline'];//团是否提供优质航空1 是；0 否
			 $datas['schedule_days']     = $_data['matches']['0']['schedule_days'];//团计划天数
			 $datas['schedule_nights']     = $_data['matches']['0']['schedule_nights'];//团计划晚数
			 $datas['departure_name']     = $_data['matches']['0']['departure_name'];//出发城市
			 $datas['continent_name']     = $_data['matches']['0']['continent_name'];//团目的地大洲
			 $datas['country_name']     = $_data['matches']['0']['country_name'];//团目的地国家
			 $datas['way_city_name']     = $_data['matches']['0']['way_city_name'];//途径城市名称
			 $datas['schedule_temp_des']     = $_data['matches']['0']['schedule_temp_des'];//行程备注
			 $datas['airline_names']     = $_data['matches']['0']['airline_names'];//团所有航空公司名称
			 $datas['optional_item']     = $_data['matches']['0']['optional_item'];//自选项目
			 $datas['picture'] = $_data['matches']['0']['attributes']['picture'];//团图片信息
			 
			 foreach($a as $v)
			 {
				 if('0' == $v['flight_type'])
				 {
					$datas['flight_info']['go'][] = $v;
				 }
				 else
				 {
					 $datas['flight_info']['back'][] = $v;
				 }
			 }
			/* */
			 
			 //$datas['flight_info'] = $a;//$_data['matches']['0']['attributes']['flight_info'];//航程信息
			 $datas['daily_schedule'] = $_data['matches']['0']['attributes']['daily_schedule'];//团行程信息
			 $datas['team_visa'] = $_data['matches']['0']['attributes']['team_visa'];//签证信息
			 $datas['transport_city'] = $_data['matches']['0']['attributes']['transport_city'];//联程信息
			 $datas['schedule_service'] = $_data['matches']['0']['attributes']['schedule_service'];//服务信息(费用包含不包含、温馨提示等)
			 $msg = array('status'=>'1','params'=>$datas,'error'=>$_data['error']);
		 }
		 return $msg;
	}
/**
 *参团详情日历接口
 */
	public static function Detail_Calendar_Logic($data=array())
	{
		 $_data = json_decode($data,true);
		 if(-1 == $_data['status'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>$_data['error']);
		 }
		 elseif(0 == $_data['status'] && !$_data['matches'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>'接口返回为空');
		 }
		 else
		 {
			 $msg = array('status'=>'1','params'=>$_data['matches'],'error'=>$_data['error']);
		 }
		 return $msg;
	}
/**
 *参团详情资源查询接口
 */
	public static function Detail_Resources_Logic($data=array())
	{
		 $_data = json_decode($data,true);
		 if(-1 == $_data['status'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>$_data['error']);
		 }
		 elseif(0 == $_data['status'] && !$_data['matches'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>'接口返回为空');
		 }
		 else
		 {
			 $msg = array('status'=>'1','params'=>$_data['matches']['0'],'error'=>$_data['error']);
		 }
		 return $msg;
	}
/**
 *参团详情库存报价接口
 */
	public static function Detail_Instructions_Logic($data=array())
	{
		 //$_data = json_decode($data,true);
		 $a = '{
    "uuid": "",
    "status": "",
    "total": "",
    "total_found": "",
    "pn": "",
    "rn": "",
    "error": "",
    "matches": [
        {
            "teamPrices": [
                {
                    "dbId": "447cc1178dfb42b7b1352303bef96637",
                    "priceName": "单房差",
                    "price": 500,
                    "priceType": "FUND06",
                    "teamDbId": "dc15d93703734a8297f4d05b55bdbf27",
                    "priceFund": "FUND06fund",
                    "insertUserId": "cuixinxin",
                    "insertUserCode": "cuixinxin",
                    "insertDate": "2016-10-12 00:00:00",
                    "updateUserId": "cuixinxin",
                    "updateUserCode": "cuixinxin",
                    "updateDate": "2016-10-12 00:00:00",
                    "deptCode": "D160218174547491DH",
                    "delFlag": "0"
                },
                {
                    "dbId": "95e714e10fc1414992f9911606796b5f",
                    "priceName": "保险",
                    "price": 500,
                    "priceType": "FUND07",
                    "teamDbId": "dc15d93703734a8297f4d05b55bdbf27",
                    "priceFund": "FUND07fund",
                    "insertUserId": "cuixinxin",
                    "insertUserCode": "cuixinxin",
                    "insertDate": "2016-10-08 00:00:00",
                    "updateUserId": "cuixinxin",
                    "updateUserCode": "cuixinxin",
                    "updateDate": "2016-10-08 00:00:00",
                    "deptCode": "D160218174547491DH",
                    "delFlag": "0"
                },
                {
                    "dbId": "2e72c57a1a914ed19b06e3a62807d8a5",
                    "priceName": "特殊行程费",
                    "price": 500,
                    "priceType": "FUND08",
                    "teamDbId": "dc15d93703734a8297f4d05b55bdbf27",
                    "priceFund": "FUND08fund",
                    "insertUserId": "cuixinxin",
                    "insertUserCode": "cuixinxin",
                    "insertDate": "2016-10-08 00:00:00",
                    "updateUserId": "cuixinxin",
                    "updateUserCode": "cuixinxin",
                    "updateDate": "2016-10-08 00:00:00",
                    "deptCode": "D160218174547491DH",
                    "delFlag": "0"
                }
            ],
            "teamPriceTickets": [
                {
                    "dbid": null,
                    "template": "quanjiacang00000000000000000001",
                    "spaceIds": [
                        "a4561af269974dc09633f58cd7dc9a56"
                    ],
                    "teamGroup": {
                        "dc15d93703734a8297f4d05b55bdbf27": "Sat Oct 29 00:00:00 CST 2016"
                    },
                    "ticketName": "全价舱",
                    "discount": null,
                    "priceName": null,
                    "price": 13000,
                    "productId": null,
                    "earlyDays": "0",
                    "places": 28,
                    "soldPlaces": 0,
                    "discountApplicableNote": "全价舱",
                    "ticketAttribute": "实体舱",
                    "virtualplaces": 0,
                    "ticketList": null,
                    "spaceAttribute": "00",
                    "spaceType": "00",
                    "sourceFlag": null,
                    "flightNumber": null,
                    "teamType": null,
                    "channelList": null,
                    "activityList": null,
                    "clientTypeList": null,
                    "theLowestMark": "0"
                },
                {
                    "dbid": null,
                    "template": "d8ccb61ef0654b9ab90c23f6f910106e",
                    "spaceIds": [
                        "a65f7033e7094b3499706560ec372278"
                    ],
                    "teamGroup": {
                        "dc15d93703734a8297f4d05b55bdbf27": "Sat Oct 29 00:00:00 CST 2016"
                    },
                    "ticketName": "预售舱",
                    "discount": null,
                    "priceName": null,
                    "price": 11000,
                    "productId": null,
                    "earlyDays": null,
                    "places": 10,
                    "soldPlaces": 0,
                    "discountApplicableNote": null,
                    "ticketAttribute": "实体舱",
                    "virtualplaces": 0,
                    "ticketList": null,
                    "spaceAttribute": "00",
                    "spaceType": "06",
                    "sourceFlag": null,
                    "flightNumber": null,
                    "teamType": null,
                    "channelList": null,
                    "activityList": null,
                    "clientTypeList": null,
                    "theLowestMark": "1"
                }
            ],
            "adultPrice": 13000,
            "childrenPrice": 12000,
            "babyPrice": 11000,
            "peersAdultPrice": 0,
            "peersChildrenPrice": 0,
            "peersBabyPrice": 0
        }
    ],
    "searchanalysis_tips": {},
    "statistics_info": {}
}';
		$_data = json_decode($a,true);
		 if(-1 == $_data['status'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>$_data['error']);
		 }
		 elseif(0 == $_data['status'] && !$_data['matches'])
		 {
			 $msg = array('status'=> '0','params'=>$_data['matches'],'error'=>'接口返回为空');
		 }
		 else
		 {
			 foreach($_data['matches']['0']['teamPrices'] as $k=>$v)
			 {
				 $teamPrices[$k]['priceName']	= $v['priceName'];
				 $teamPrices[$k]['price']		= $v['price'];
				 $teamPrices[$k]['priceType']	= $v['priceType'];
				 $teamPrices[$k]['insertDate']	= $v['insertDate'];
				 $teamPrices[$k]['updateDate']	= $v['insertDate'];
			 }
			 
			for($j=0;$j<count($_data['matches']['0']['teamPriceTickets']);$j++){
			$newArr[]=$_data['matches']['0']['teamPriceTickets'][$j]['places'];
			}
			array_multisort($newArr,$_data['matches']['0']['teamPriceTickets']);
			$numk = 0;
			 foreach($_data['matches']['0']['teamPriceTickets'] as $k=>$v)
			 {
				$rdata['selling'][$numk]['ticketName'] = $v['ticketName'];	//舱位名称
				$rdata['selling'][$numk]['discount'] 	 = $v['discount'];		//折扣
				$rdata['selling'][$numk]['priceName']  = $v['priceName'];		//报价名称
				$rdata['selling'][$numk]['price'] 	 = $v['price'];			//价格
				$rdata['selling'][$numk]['productId']  = $v['productId'];		//产品ID
				$rdata['selling'][$numk]['earlyDays']  = $v['earlyDays'];		//提前天数
				$rdata['selling'][$numk]['places'] 	 = $v['places'];		//名额
				$rdata['selling'][$numk]['soldplaces'] = $v['soldPlaces'];	//已售名额
				$rdata['selling'][$numk]['remain'] = $v['places']-$v['soldPlaces'];	//剩余名额
				$rdata['selling'][$numk]['ticketList'] = $v['ticketList'];	//舱位列表
								
				$rdata['selling'][$numk]['spaceType']  = $v['spaceType'];		//舱位属性 00实舱 01虚舱
				$rdata['selling'][$numk]['sourceFlag'] = $v['sourceFlag'];	//来源标识0--价格体系 1--报价新增
				$rdata['selling'][$numk]['channelList']= $v['channelList'];	//渠道列表
				$rdata['selling'][$numk]['flightNumber']= $v['flightNumber'];	//团组计划人数
				$rdata['selling'][$numk]['activityList']= $v['activityList'];	//活动列表		
				$rdata['selling'][$numk]['theLowestMark']= $v['theLowestMark'];//是否为最低价
				$rdata['selling'][$numk]['virtualplaces']= $v['virtualplaces'];//虚拟名额
				$rdata['selling'][$numk]['clientTypeList']= $v['clientTypeList'];//客户列表
				$rdata['selling'][$numk]['ticketAttribute']= $v['ticketAttribute'];//舱位属性
				$rdata['selling'][$numk]['discountApplicableNote'] = $v['discountApplicableNote'];//折扣适用说明
				$rdata['selling'][$numk]['childrenPrice'] = $_data['matches']['0']['childrenPrice'];//儿童零售价
				$rdata['selling'][$numk]['adultPrice'] = $_data['matches']['0']['adultPrice'];//成人零售价
				$rdata['selling'][$numk]['babyPrice'] = $_data['matches']['0']['babyPrice'];//婴儿零售价
				 if($v['ticketName'] == '全价舱')
				 {
					$rdata['full']['0']['ticketName'] = $v['ticketName'];	//舱位名称
					$rdata['full']['0']['discount'] 	 = $v['discount'];		//折扣
					$rdata['full']['0']['priceName']  = $v['priceName'];		//报价名称
					$rdata['full']['0']['price'] 	 = $v['price'];			//价格
					$rdata['full']['0']['productId']  = $v['productId'];		//产品ID
					$rdata['full']['0']['earlyDays']  = $v['earlyDays'];		//提前天数
					$rdata['full']['0']['places'] 	 = $v['places'];		//名额
					$rdata['full']['0']['soldplaces'] = $v['soldPlaces'];	//已售名额
					$rdata['full']['0']['remain'] = $v['places']-$v['soldPlaces'];	//剩余名额
					$rdata['full']['0']['ticketList'] = $v['ticketList'];	//舱位列表				
					$rdata['full']['0']['spaceType']  = $v['spaceType'];		//舱位属性 00实舱 01虚舱
					$rdata['full']['0']['sourceFlag'] = $v['sourceFlag'];	//来源标识0--价格体系 1--报价新增
					$rdata['full']['0']['channelList']= $v['channelList'];	//渠道列表
					$rdata['full']['0']['flightNumber']= $v['flightNumber'];	//团组计划人数
					$rdata['full']['0']['activityList']= $v['activityList'];	//活动列表		
					$rdata['full']['0']['theLowestMark']= $v['theLowestMark'];//是否为最低价
					$rdata['full']['0']['virtualplaces']= $v['virtualplaces'];//虚拟名额
					$rdata['full']['0']['clientTypeList']= $v['clientTypeList'];//客户列表
					$rdata['full']['0']['ticketAttribute']= $v['ticketAttribute'];//舱位属性
					$rdata['full']['0']['discountApplicableNote'] = $v['discountApplicableNote'];//折扣适用说明
					$rdata['full']['0']['childrenPrice'] = $_data['matches']['0']['childrenPrice'];//儿童零售价
					$rdata['full']['0']['adultPrice'] = $_data['matches']['0']['adultPrice'];//成人零售价
					$rdata['full']['0']['babyPrice'] = $_data['matches']['0']['babyPrice'];//婴儿零售价
				 }
				 $numk++;
			 }
			 $rdata['teamPrices'] = $teamPrices;
			 $msg = array('status'=>'1','params'=>$rdata,'error'=>$_data['error']);
		 }
		 return $msg;
	}
 }
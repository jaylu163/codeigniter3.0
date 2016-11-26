<?php
/**
 * 老顾问接口,门店顾问接口,门店查询接口,省市区三级联动接口
 * author huhua
 */

class Custom extends Base_Controller{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 老顾问接口
	 * @param user_id 用户ID
	 * @return json
	 */
	public function index(){
		//参数接收
		$user_id = $this->input->get_post('user_id');//$user_id = 2003229;
		//userid不能为空
		if(!$user_id)
			return $this->jsonFormat(201, array(), '用户ID不能为空'); //用户ID不能为空
		
		//调用接口
		$api_url = config_item('MUMBER_CENTER_URL').'user/info/getusersalelist.do';
		$api_data = array(
			'userId' => $user_id,
		);
		$return = $this->httpCurlPost($api_url,$api_data);
		$return = json_decode($return,true);
		$data = array(
			'name' => $return['userName'],	
			'shopName' => $return['userDeptName'],
			'tel' => $return['userOfficeNumber'],
			'phone' => $return['userPhoneNumber'],
		);
		//门店地址查询
		$addressId = $return['userDeptCode'];
		$addressApiUrl = config_item('MUMBER_CENTER_URL').'store/erp_store.do';
		$addressApiData = array(
				'use_all' => 1,	//命中全部数据，固定值
				'store_dept_id' => $addressId,
				//'orderby' => 'distance:asc', //排序
		);
		$addressData = $this->httpCurlGet($addressApiUrl, $addressApiData);
		$addressData = json_decode($addressData, true);
		$data['address'] = isset($addressData['address']) ? $addressData['address'] : '' ;
		
		if(!$return)
			return $this->jsonFormat(202, array(), '接口调用失败'); //接口调用失败
		
		if(!$return['userCode'])
			return $this->jsonFormat(203, array(), '该用户没有老顾问'); //该用户没有老顾问
		
		return $this->jsonFormat(200, $data, 'ok');//调用成功
	}
	
	/**
	 * 门店顾问接口
	 * @param shopid 门店ID
	 * @return json
	 */
	public function shop(){
		//参数接收
		$shop_id = $this->input->get_post('shopid'); //$shop_id = 'D160218174605734X2'; 
		
		//门店ID不能为空
		if(!$shop_id)
			return $this->jsonFormat(201, array(), '门店ID不能为空'); //门店ID不能为空
		
		//调用接口
		$api_url = config_item('MUMBER_CENTER_URL').'dept/salelist.do';
		$api_data = array(
			'deptcode' => $shop_id,
			'jobcode' => 'J160218171314922SF', //旅游顾问岗位编码,固定值
		);
		$return = $this->httpCurlPost($api_url,$api_data);
		$return = json_decode($return,true);
		
		if($return)
			return $this->jsonFormat(200, $return, 'ok'); //调用成功
		else
			return $this->jsonFormat(202, array(), '该门店没有顾问'); //该门店没有顾问
	
	}
	
	/**
	 * 门店查询接口
	 * @param string $longitude 经度
	 * @param string $latitude 纬度
	 * @return json
	 */
	public function shopSearch(){
		//参数接收
		$longitude = $this->input->get_post('longitude');	//经度
		$latitude = $this->input->get_post('latitude');	//纬度
		$cityId = $this->input->get_post('cityid');//$cityId = '101001000';
		$districtId = $this->input->get_post('district_id');
		//$longitude = 118.891832;
		//$latitude = 32.157078;
		
		//经度或纬度不能为空
		if(!($longitude || $latitude || $cityId || $districtId))
			return $this->jsonFormat(201, array(), '经度、纬度、城市ID、区ID不能同时为空!'); //经度或纬度不能为空
		//调用接口
		$api_url = config_item('MUMBER_CENTER_URL').'store/erp_store.do';
		$api_data = array(
				'use_all' => 1,	//命中全部数据，固定值
				//'xcoord_center' => $longitude, //经度
				//'ycoord_center' => $latitude, //纬度
				'orderby' => 'distance:asc', //排序
		);
		if($longitude)
			$api_data['xcoord_center'] = $longitude;
		if($latitude)
			$api_data['ycoord_center'] = $latitude;
		if($cityId)
			$api_data['city_id'] = $cityId;
		if($districtId)
			$api_data['district_id'] = $districtId;
		
		$return = $this->httpCurlGet($api_url,$api_data);
		$return = json_decode($return,true);
		$return = $return['matches'];
		$data = array();
		foreach($return as $v){
			$tempArr = array();
			$tempArr['name'] = $v['store_name'];//店铺名称
			$tempArr['tel'] = $v['store_tel']; //门店电话
			$tempArr['address'] = $v['address']; //门店地址 
			$tempArr['sign'] = $v['store_sign']; //门店标签:pt 普通门店 jp 金牌门店 zt 暂停门店
			$data[] = $tempArr;
		}
		
		if($return)
			return $this->jsonFormat(200, $data, 'ok'); //调用成功
		else
			return $this->jsonFormat(202, array(), '接口调用失败'); //接口调用失败
	}
	
	/**
	 * 省市区三级联动接口
	 * @return json
	 */
	public function linkage(){
		//参数接收
		$type = $this->input->get_post('type');//$type = 'district';
		$id = $this->input->get_post('id');//$id = '101001133';
		//调用接口
		//$api_url = config_item('MUMBER_CENTER_URL').'store/erp_store.do';
		$api_url = config_item('MUMBER_CENTER_URL').'common/store.do';
		$api_data = array(
				'use_all' => 1,	//命中全部数据，固定值
				//'orderby' => 'distance:asc', //排序
		);
		switch($type){
			/*case 'city':
				$api_data['province_id'] = $id;
				break;*/
			case 'district':
				$api_data['city_id'] = $id;
				break;
			default:
				break;
		}
		$return = $this->httpCurlGet($api_url,$api_data);
		$return = json_decode($return,true);
		$return = $return['statistics_info']['district_id'];
		$data = array();
		if($type == 'city'){
			//返回省份下的所有城市
			foreach($return as $v){
				if($v['name'] == $id){
					foreach($v['next'] as $v1){
						$temp_arr = array();
						$temp_arr['name'] = $v1['attr'];
						$temp_arr['code'] = $v1['name'];
						$data[] = $temp_arr;
					}
				}
			}
		}else if($type == 'district'){
			//返回城市下的所有区
			$return = $return[0]['next'][0]['next'];
			foreach($return as $v){
				$temp_arr = array();
				$temp_arr['name'] = $v['attr'];
				$temp_arr['code'] = $v['name'];
				$data[] = $temp_arr;
			}
		}else{
			//返回所有省份
			foreach($return as $v){
				$temp_arr = array();
				$temp_arr['name'] = $v['attr'];
				$temp_arr['code'] = $v['name'];
				$data[] = $temp_arr;
			}
		}
			
		if($return)
			return $this->jsonFormat(200, $data, 'ok'); //调用成功
		else
			return $this->jsonFormat(202, array(), '接口调用失败'); //接口调用失败
	
	}
	
}





















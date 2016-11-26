<?php
/**
 * 订单相关接口
 * author huhua
 */
class Order extends Base_Controller{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 下单接口
	 */
	public function index(){
		//日志相关参数
		$ip = $this->input->get_post('ip');
		$sessionId = $this->input->get_post('session_id');
		$ref = $this->input->get_post('ref');
		$url = $this->input->get_post('url');
		$browser = $this->input->get_post('browser');
		$date = $this->input->get_post('date');
		$userId = $this->input->get_post('user_id');
		$userPhone = $this->input->get_post('user_phone');
		$userName = $this->input->get_post('user_name');
		//参数接收
		$teamDbId = '39793e1978a74abda76d925805017626';	//团DBID
		$teamNumber = 'CAI16-PEK0300-1007725';	//团号
		$orderTotalNum = 4;	//订单人数
		$adultNum = 4;	//成人数
		
		$childrenNum = '';	//儿童数 非必填
		$babyNum = '';	//婴儿数 非必填
		
		$saleChannelId = 111;	//销售渠道ID
		$saleChannelName = 111;	//销售渠道名称
		$saleChannelAttribute = 111; 	//销售渠道属性
		$saleChannelType = 111;	//销售渠道类型
		$saleCompanyId = 111;	//销售公司ID
		$saleCompanyName = 111;	//销售公司名称
		$saleDeptId = 'D160218180834569JT';	//销售部门ID
		$saleDeptName = 111;	//销售部门名称
		
		$saleId = '';	//销售人员ID	非必填
		$saleName = '';	//销售人员名称	非必填
		$contactId = '';	//联系人ID	非必填
		$contactEmail = '';	//联系人邮箱	非必填
		$contactGender = '';	//联系人性别	非必填
		
		$contactName = 111; //联系人姓名
		$contactPhone = '13711111111';	//联系人电话
		
		$activityId = '';	//活动ID	非必填
		$activityName = '';	//活动名称 非必填
		$thirdPartyId = ''; 	//第三方ID	非必填
		$thirdPartyName = '';	//第三方名称	非必填
		$orderRemark = '';	//下单备注	非必填
		$insertUserName = '';	//下单人姓名	非必填
		
		$insertUserCode = 1234;	//下单人编码
		$cabinId = '77f5d89d5acd4f5ab9a62c14ee280607'; 	//舱位ID
		$count = 2;	//舱位人数
		$cabinMoney = 222222;	//舱位金额
		$customerType = 2;	//客人类型
	
		if(!($teamDbId && $teamNumber && $orderTotalNum && $adultNum && $saleChannelId && $saleChannelName && $saleChannelAttribute && $saleChannelType && $saleCompanyId && $saleCompanyName && $saleDeptId && $saleDeptName && $contactName && $contactPhone && $insertUserCode && $cabinId && $count && $cabinMoney && $customerType))
			return $this->jsonFormat(201, array(), '下单数据不正确'); //下单数据不正确
		
		//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL').'order/team/saveorder.do';
		$apiData = array(
				'teamDbId' => $teamDbId,
				'teamNumber' => $teamNumber,
				'orderTotalNum' => $orderTotalNum,
				'adultNum' => $adultNum,
				
				//非必填start
				'childrenNum' => $childrenNum,
				'babyNum' => $babyNum,
				//非必填end
		
				'saleChannelId' => $saleChannelId,
				'saleChannelName' => $saleChannelName,
				'saleChannelAttribute' => $saleChannelAttribute,
				'saleChannelType' => $saleChannelType,
				'saleCompanyId' => $saleCompanyId,
				'saleCompanyName' => $saleCompanyName,
				'saleDeptId' => $saleDeptId,
				'saleDeptName' => $saleDeptName,
				
				//非必填start
				'saleId' => $saleId,
				'saleName' => $saleName,
				'contactId' => $contactId,
				'contactEmail' => $contactEmail,
				'contactGender' => $contactGender,
				//非必填end
				
				'contactName' => $contactName,
				'contactPhone' => $contactPhone,
				
				//非必填start
				'activityId' => $activityId,
				'activityName' => $activityName,
				'thirdPartyId' => $thirdPartyId,
				'thirdPartyName' => $thirdPartyName,
				'orderRemark' => $orderRemark,
				'insertUserName' => $insertUserName,
				//非必填end
		
				'insertUserCode' => $insertUserCode,
				'customerExports[0].cabinId' => $cabinId,
				'customerExports[0].count' => $count,
				'customerExports[0].cabinMoney' => $cabinMoney,
				'customerExports[0].customerType' => $customerType,
		);
	
		$return = $this->httpCurlPost($apiUrl,$apiData);
		$return = json_decode($return,true);
		//日志记录
		$logArr = array(
			'order_id' => $return['orderNumber'],
			'ip' => $ip,
			'session_id' => $sessionId,
			'user_id' => $userId,
			'user_name' => $userName,
			'ref' => $ref,
			'url' => $url,
			'browser' => $browser,
			'user_phone' => $userPhone,
			'params' => json_encode($teamDbId),
			'return_val' => json_encode($return),
			'create_time' => date('Y-m-d H:i:s'),		
		);
		$this->load->model('Order_model');
		$test = $this->Order_model->insertLog($logArr);
		
		if(!$return)
			return $this->jsonFormat(202, array(), '接口调用失败'); //接口调用失败
		
		if($return['isSuccess']){
			$data = array(
				'dbId' => $return['dbId'],
				'orderNumber' => $return['orderNumber'],
			);
			return $this->jsonFormat(200, $data, 'ok'); 
		}else 
			return $this->jsonFormat(203, array(), '下单失败');
	}
	
	/**
	 * 修改订单状态
	 */
	public function orderModify(){
		//参数接收
		$orderNumber = $this->input->get_post('orderNumber');	//订单号
		$orderStatus = $this->input->get_post('orderStatus');	//订单状态
		
		if(!($orderNumber && $orderStatus))
			return $this->jsonFormat(201, array(), '订单号和订单状态不能为空'); //订单号和订单状态不能为空
		
		//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL').'order/team/updateorder.do';
		$apiData = array(
			'orderNumber' => $orderNumber,
			'orderStatus' => $orderStatus,
			'invokeDate' => date('Y-m-d H:i:s',time()),
			'operatorCode' => 'web',
			'operatorName'	=> 'web',
			'operatorDeptCode' => 'web',
			'operatorDeptName' => 'web',
		);
		$return = $this->httpCurlPost($apiUrl,$apiData);
		$return = json_decode($return,true);
		
		if(isset($return['txnStatus'])){
			if(1 == $return['txnStatus'])
				return $this->jsonFormat(200, array(), 'ok');
			else if(2 == $return['txnStatus'])
				return $this->jsonFormat(202, array(), $return['info']);	//订单修改失败
		}else
			return $this->jsonFormat(203, array(), '接口调用失败');	//接口调用失败
		
	}
	
	/**
	 * 订单列表查询
	 */
	public function orderList(){
		//参数接收
		$userId = $this->input->get_post('userId');
		$onOffType = $this->input->get_post('onOffType');
		$currentPage = $this->input->get_post('page');
		$userId = '8000575';
		$onOffType = $onOffType ? $onOffType : 0 ;
		$onOffType = 1;
		if(!($userId))
			return $this->jsonFormat(201, array(), '用户ID和查询类型不能为空'); //用户ID和查询类型不能为空
				//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL').'order/team/orders.do';
		$apiData = array(
				'userId' => $userId,
				'onOffType' => $onOffType,
		);

		$return = $this->httpCurlPost($apiUrl,$apiData);
		$return = json_decode($return,true);
		if(isset($return['orderInfos']))
			$return = $return['orderInfos'];
		else
			$return = array();
		//返回的数组
		$data = array();
		foreach($return as $item){
			$tempArr = array(
				'orderNumber' => $item['orderNumber'],	//订单号
				'insertDate' => $item['insertDate'],	//下单日期
				'productName' => $item['productName'],	//产品名称
				'orderAmount' => $item['orderAmount'],	//订单总金额
				'incomeAmount' => $item['incomeAmount'],	//已付金额
				'orderStatus' => $item['orderStatus'],	//订单状态  01-预报 02-扣位申请 03-补录 05-订单确认 06-交易完成 07-交易关闭
				'payStatus' => $item['payStatus'],	//支付状态 01-未支付 02-部分支付 03-支付完成
				//'teamNumber' => $item['teamNumber'],	//团号
				'orderType' => 'new',	//订单类型 new新订单 old老订单
			);
			$data[] = $tempArr;
		}
		//老接口订单
		$userId = '52323';
		//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL_OLD').'order/search.do';
		$apiData = array(
				'userid' => $userId,
		);
		$return = $this->httpCurlGet($apiUrl,$apiData);
		$return = json_decode($return,true);
		$return = $return['orderDetail'];
		$today = date('Y-m-d');
		if(!is_array($return))
			$return = array();
		foreach($return as $item){
			$tempArr = array(
					'orderNumber' => $item['OrderCode'],	//订单号
					'insertDate' => $item['People_Num'],	//下单日期
					'productName' => $item['ProName'],	//产品名称
					'orderAmount' => $item['Sum_Price'],	//订单总金额
					'incomeAmount' => $item['Pay_Price'],	//已付金额
					//'orderStatus' => $item['orderStatus'],	//订单状态  01-预报 02-扣位申请 03-补录 05-订单确认 06-交易完成 07-交易关闭
					//'payStatus' => $item['payStatus'],	//支付状态 01-未支付 02-部分支付 03-支付完成
					//'teamNumber' => $item['teamNumber'],	//团号
					'orderType' => 'old',	//订单类型 new新订单 old老订单
			);
			if(($item['Pay_Price']+$item['Cut_Price']) >= $item['Sum_Price'])
				$tempArr['payStatus'] = '03';
			elseif(0 == $item['Pay_Price'])
				$tempArr['payStatus'] = '01';
			elseif(($item['Pay_Price'] > 0) && (($item['Pay_Price']+$item['Cut_Price']) < $item['Pay_Price']))
				$tempArr['payStatus'] = '02'; 
			
			if($today > substr($item['StartDate'], 0, 10))
				$tempArr['orderStatus'] = '05';
			else 
				$tempArr['orderStatus'] = '06';
			$data[] = $tempArr;
		}
		//分页
		//require_once (APPPATH.'libraries/Page.php');
		
		if(!$currentPage)
			$currentPage = 1;
		$totalRows = count($data);
		$pageSize = 6;
		$this->load->library('Page',array('totalRows'=>$totalRows,'pageSize'=>$pageSize,'currentPage'=>$currentPage));
		//$page = new Page($totalRows,$pageSize,$currentPage);
		$pageStr = $this->page->show4();
		$returnData = array();
		for($i = (($currentPage-1)*$pageSize) ; $i < ($currentPage*$pageSize); $i++){
			if($i >= $totalRows)
				break;
			$returnData['data'][] = $data[$i];
		}
		$returnData['page'] = $pageStr;
		return $this->jsonFormat(200, $returnData, 'ok');
		
	}
	
	/**
	 * 订单详情查询
	 */
	public function orderDetail(){
		//参数接收
		$orderNumber = $this->input->get_post('orderNumber');
		//$hasCustomerInfo = $this->input->get_post('hasCustomerInfo');	//是否查询客人信息
		//$hasDiscount = $this->input->get_post('hasDiscount');	//是否查询优惠信息
		//$hasRecrefInfo = $this->input->get_post('hasRecrefInfo');	//是否查询收款信息
		//$hasInvoiceInfo = $this->input->get_post('hasInvoiceInfo');	//是否查询发票信息
		
		//$hasCustomerInfo = $hasCustomerInfo ? $hasCustomerInfo : false ;
		//$hasDiscount = $hasDiscount ? $hasDiscount : false ;
		//$hasRecrefInfo = $hasRecrefInfo ? $hasRecrefInfo : false ;
		//$hasInvoiceInfo = $hasInvoiceInfo ? $hasInvoiceInfo : false ;
		
		$orderNumber = 'TF16092801023396';
		$hasCustomerInfo = true;
		$hasDiscount = true;
		$hasRecrefInfo = true;
		$hasInvoiceInfo = true;
		
		if(!$orderNumber)
			return $this->jsonFormat(201, array(), '订单ID不能为空'); //订单ID不能为空
		
		//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL').'order/team/info.do';
		$apiData = array(
				'orderNumber' => $orderNumber,
				'hasCustomerInfo' => $hasCustomerInfo,
				'hasDiscount' => $hasDiscount,
				'hasRecrefInfo' => $hasRecrefInfo,
				'hasInvoiceInfo' => $hasInvoiceInfo,
		);
		$return = $this->httpCurlGet($apiUrl,$apiData);
		$return = json_decode($return,true);
		
		$data = array(
			'orderStatus' => $return['orderBaseInfo']['orderStatus'],	//订单状态
			'productName' => $return['orderBaseInfo']['productName'],	//产品名称
			'orderNumber' => $return['orderBaseInfo']['orderNumber'],	//订单号
			'insertDate' => $return['orderBaseInfo']['insertDate'],	//下单时间
			'outDate' => $return['orderBaseInfo']['outDate'],	//出团日期
			'returnDate' => $return['orderBaseInfo']['returnDate'],	//回团日期
			'adultPrice' => $return['orderBaseInfo']['adultPrice'], //成人价
			'adultNum' => $return['orderBaseInfo']['adultNum'],	//成人数
			'childrenPrice' => $return['orderBaseInfo']['childrenPrice'],	//儿童价
			'childrenNum' => $return['orderBaseInfo']['childrenNum'],	//儿童数
			'babyPrice' => $return['orderBaseInfo']['babyPrice'],	//婴儿价
			'babyNum' => $return['orderBaseInfo']['babyNum'],	//婴儿数
			'contactName' => $return['orderBaseInfo']['contactName'],	//联系人姓名
			'contactPhone' => $return['orderBaseInfo']['contactPhone'],	//联系人电话
			'serviceOperatorDeptName' => $return['orderBaseInfo']['serviceOperatorDeptName'],	//服务操作部门名称
			'serviceOperatorName' =>$return['orderBaseInfo']['serviceOperatorName'], //服务操作人名称
			'orderAmount' => $return['orderBaseInfo']['orderAmount'],	//订单总价
		);
		//服务门店信息
		$shopId = $return['orderBaseInfo']['serviceOperatorDeptId'];
		$shopApiUrl = config_item('MUMBER_CENTER_URL').'store/erp_store.do';
		$shopApiData = array(
				'use_all' => 1,	//命中全部数据，固定值
				'store_dept_id' => $shopId,
				//'orderby' => 'distance:asc', //排序
		);
		$shopData = $this->httpCurlGet($shopApiUrl, $shopApiData);
		$shopData = json_decode($shopData, true);
		if(isset($shopData['matches'][0])){
			$shopData = $shopData['matches'][0];
			$data['shopTel'] = $shopData['store_tel '];	//门店电话
			$data['shopFax'] = $shopData['store_fax'];	//门店传真
			$data['address'] = $shopData['address'];	//门店地址
			//门店营业时间
			switch(date('N')){
				case 1:
					$data['shopTime'] = substr($shopData['monday_start'],-8).'-'.substr($shopData['monday_end'],-8);
					break;
				case 2:
					$data['shopTime'] = substr($shopData['tuesday_start'],-8).'-'.substr($shopData['tuesday_end'],-8);
					break;
				case 3:
					$data['shopTime'] = substr($shopData['wednesday_start'],-8).'-'.substr($shopData['wednesday_end'],-8);
					break;
				case 4:
					$data['shopTime'] = substr($shopData['thursday_start'],-8).'-'.substr($shopData['thursday_end'],-8);
					break;
				case 5:
					$data['shopTime'] = substr($shopData['friday_start'],-8).'-'.substr($shopData['friday_end'],-8);
					break;
				case 6:
					$data['shopTime'] = substr($shopData['saturday_start'],-8).'-'.substr($shopData['saturday_end'],-8);
					break;
				case 7:
					$data['shopTime'] = substr($shopData['sunday_start'],-8).'-'.substr($shopData['sunday_end'],-8);
					break;
				default:
					break;
			}
		}else{
			$data['shopTel'] = '';	//门店电话
			$data['shopFax'] = '';	//门店传真
			$data['shopTime'] = '';
			$data['address'] = '';
		}
		//发票信息
		if($return['orderInvoiceInfos']){
			$data['invoice'] = array(
				'insertDate' => $return['orderInvoiceInfos'][0]['insertDate'],	//申请时间
				'invoiceType' => $return['orderInvoiceInfos'][0]['invoiceType'],	//发票类型
				'invoiceHead' => $return['orderInvoiceInfos'][0]['invoiceHead'],	//发票抬头
			); 
		}else
			$data['invoice'] = array();
		
		return $this->jsonFormat(200, $data, 'ok');
	}
	
	/**
	 * 申请退团接口
	 */
	public function quitTeam(){
		//参数接收
		$orderNumber = $this->input->get_post('orderNumber');	//订单号
		$quitReason = $this->input->get_post('quitReason');	//退团原因
		$quitRemark = $this->input->get_post('quitRemark');	//退团描述
		//$orderNumber = 'TF16092801023396';
		//$quitReason = '测试';
		
		if(!($orderNumber && $quitReason && $quitRemark))
			return $this->jsonFormat(201, array(), '订单ID和退团理由不能为空'); //订单ID不能为空
		
		//调用接口
		$apiUrl = config_item('MUMBER_CENTER_URL').'order/team/quitteam.do';
		$apiData = array(
				'orderNumber' => $orderNumber,
				'quitReason' => $quitReason,
				'quitRemark' => $quitRemark,
		);
		$return = $this->httpCurlPost($apiUrl,$apiData);
		$return = json_decode($return,true);
		
		if(isset($return['txnStatus'])){
			if(1 == $return['txnStatus'])
				return $this->jsonFormat(200, array(), 'ok'); 
			else
				return $this->jsonFormat(203, array('info' => $return['info']), '申请退团失败'); //申请退团失败
		}else
			return $this->jsonFormat(202, array(), '接口调用失败'); //接口调用失败
	}
}

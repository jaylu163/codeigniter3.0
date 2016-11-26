<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 签名生成及校验
 */
class Sign{
	protected $_from = 'group';
	protected $_key = '';//加密的盐值
	protected $_timeout = 10;//超时时间
	protected $_check_sign = true;//是否开启验签
	/**
	 * 获取配置信息
	 */
	public function __construct(){
		$CI = & get_instance();//在自己的类中使用 CodeIgniter 类:将 CodeIgniter 对象赋值给一个变量
		$CI->config->load('config',true);//加载配置
		$this->_key = $CI->config->item('sign_key','config');
		$this->_timeout = $CI->config->item('timeout');
		$this->_check_sign = $CI->config->item('check_sign');
	}
	/**
	 * 生成加密串
	 * @return string 加密的字符串
	 */
	public function makeSign(){
		$time = time();
		return md5($this->_from.$time.$this->_key).mt_rand(100,999);
	}
	/**
	 * 校验签名
	 * @param  mixed  数组或者时间戳
	 * @param  string  $_sign 加密串
	 * @return boolean         校验结果
	 */
	public function checkSign($params=array(),$_sign=''){
		if (is_array($params)) {
			sort($params);
			$time = isset($params['_time'])?$params['_time']:$params[1];
			$sign = isset($params['_sign'])?$params['_sign']:$params[0];
		}elseif (is_numeric($params)) {
			$time = $params;
		}
		if($this->_check_sign){
			$from = $this->_from;
			if(empty($time) || empty($sign)){
				return false;
			}
			//验证是否超时
			$t = abs(time()-$time);
			if(0>$t || $this->_timeout<$t){
				return false;
			}
			//验证签名
			if(!$this->_key){
				return false;
			}
			$sign = md5($this->_from.$time.$this->_key);
			if($sign===substr($sign,0,32)){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

}
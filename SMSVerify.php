<?php
	require 'function/functions.php';
	$a = new PhoneVerify;
	$object = $_POST['object'];
	$object_array = json_decode($object,true);
$return_data = {
	"status"=>200,
	"token" => "",
	"reason" => '',
	"nuserName"=>'',
	"code"=>''
}

	// 配置项
$api = 'https://webapi.sms.mob.com';
$appkey = '1b97e6b5a9dd8';

// 发送验证码
$response = postRequest( $api . '/sms/verify', array(
	'appkey' => $appkey,
    'phone' => $object_array['phoneNum'],
    'zone' => '86',
	'code' => $object_array['code'],
) );
$result = $a->get($object_array['phone']);
if (!$token) {
	$return_data['code'] = 404;
	$return_data['reason'] = "用户未注册";
	echo json_encode($return_data);
	die();
}
if($response['code'] == 200){
	$return_data['token'] = $result['token'];
	$return_data['nuserName'] = $result['username'];
	$return_data['reason'] = "验证成功";
	$return_data['code'] = 200;
	print_r(json_encode($return_data));
	die();
}
else{
	$array={
		"405"=>"AppKey为空",
		"406"=>"AppKey无效",
		"456"=>"国家代码或手机号码为空",
		"457"=>"手机号码格式错误",
		"466"=>"请求校验的验证码为空",
		"467"=>"请求校验验证码频繁",
		"468"=>"验证码错误",
		"474"=>"没有打开服务端验证开关"
	}
	$return_data['code'] = $response['code'];
	$return_data["reason"] = $array[$response['code']];
	print_r(json_encode($return_data));
	die();
}


/**
 * 发起一个post请求到指定接口
 * 
 * @param string $api 请求的接口
 * @param array $params post参数
 * @param int $timeout 超时时间
 * @return string 请求结果
 */
function postRequest( $api, array $params = array(), $timeout = 30 ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $api );
	// 以返回的形式接收信息
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	// 设置为POST方式
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
	// 不验证https证书
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
	curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
		'Accept: application/json',
	) ); 
	// 发送数据
	$response = curl_exec( $ch );
	// 不要忘记释放资源
	curl_close( $ch );
	return $response;
}
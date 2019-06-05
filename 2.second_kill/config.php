<?php

date_default_timezone_set('Asia/Shanghai');
$start_time=mktime(17,1,0,5,16,2018);//项目开始时间
$end_time=$start_time+3600;//项目结束时间
$index_page="http://miaosha1.com/php_www/2.second_kill/level1/miaosha_index.php";
$login_page="http://miaosha2.com/php_www/2.second_kill/level2/miaosha_login.php";
$data_middle_page="http://miaosha3.com/php_www/2.second_kill/level3/miaosha_data_middle.php";
$over_page="http://192.168.91.11/php_www/2.second_kill/over.html";

define ('STATE_FRONT_MIAOSHA',0);
define ('STATE_IN_MIAOSHA',1);
define ('STATE_AFTER_MIAOSHA',2);

define("MIAOSHA_REDIS_PARTICIPATE","miaosha_redis_participate");

function get_miaosha_state($start_time, $end_time)
{
	if (time()>$start_time && time()<$end_time) {
		return STATE_IN_MIAOSHA;
	}else if(time()<$start_time){
		return STATE_FRONT_MIAOSHA;
	}else{
		return STATE_AFTER_MIAOSHA;
	}
}

//第3层通知1,2,4层
function sendOver($phone)
{
	$url_level1="http://miaosha1.com/php_www/2.second_kill/level1/set_file.php";
	$url_level2="http://miaosha2.com/php_www/2.second_kill/level2/set_file.php";
	//其实实际不会用http GET太弱了
	//实际消息队列进行流量削锋+tcp/udp去走swoole mysql连接池
	$url_level4="http://miaosha4.com/php_www/2.second_kill/level4/set_mysql.php?phone=".$phone;

	//$ch = curl_init();//GET方式
	//curl_setopt($ch, CURLOPT_URL, $url_level1);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_HEADER, 0);
	//$response = curl_exec($ch); // 已经获取到内容，没有输出到页面上。
	//curl_close($ch);
	////echo $response;

	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL, $url_level2);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_HEADER, 0);
	//$response = curl_exec($ch); // 已经获取到内容，没有输出到页面上。
	//curl_close($ch);
	////echo $response;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url_level4);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$response = curl_exec($ch); // 已经获取到内容，没有输出到页面上。
	curl_close($ch);
	if ($response) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function create_token()
{
	$str = 1111;
	$end = 9999;
	$salt = array("L","J","S","H");
	$str = rand($str, $end);
	$a = $str.$str%ord($salt[0]);
	$str = rand($str, $end);
	$b = $str.$str%ord($salt[1]);
	$str = rand($str, $end);
	$c = $str.$str%ord($salt[2]);
	$str = rand($str, $end);
	$d = $str.$str%ord($salt[3]);
	return $a.'-'.$b.'-'.$c.'-'.$d;
}

function check_token($res)
{
	$salt = array("L","J","S","H");
	$res = explode('-',$res);
	foreach ($res as $k=>$v) {
		$start = substr($v,0,4);
		$end = substr($v,4);
		$new = $start -$end;
		if ($new%ord($salt[$k])) {
			return false;
		}
	}
	return true;
}

//echo $res = create_token();
//echo check_token($res);
?>

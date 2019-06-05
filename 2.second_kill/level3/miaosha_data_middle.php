<?php
include_once("../config.php");
include_once("../redis.php");
header('Access-Control-Allow-Origin:http://miaosha2.com'); //防止ajax跨域
$data =array('msg'=>'false');//初始化数据
//1.数据输入
if (!isset($_GET['token']) || !isset($_GET['phone']) ||!isset($_GET['callback'])){
	$data =array('msg'=>'$_GET lack false');//初始化数据
	echo $callback.'('.json_encode($data).')';
	exit;
}
$callback=$_GET['callback'];
$phone = floatval($_GET['phone']);
$token = floatval($_GET['token']);

//2.是否还在活动
$state = get_miaosha_state($start_time, $end_time);
if ($state!=STATE_IN_MIAOSHA) {
	header("Location:$over_page");
	exit;
}

//3.整理level2提交的数据
$res = check_token($_GET['token']);
if (!$res) {
	echo $callback.'('.json_encode($data).')';
	exit;
}

//4.数据队列存储流程 redis
//是否已经参与过活动
$redis_obj = my_redis::getIntance();
if (!isset($redis_obj)) {
	$data =array('msg'=>'redis connect false');
	echo $callback.'('.json_encode($data).')';
	exit;
}

//5.是否参与过
$already_participate_miaosha=$redis_obj->sIsMember(MIAOSHA_REDIS_PARTICIPATE, $phone);
if ($already_participate_miaosha) {
	$data =array('msg'=>'already_participate_miaosha');
	echo $callback.'('.json_encode($data).')';
	exit;
}

//6.插入redis
$ret=$redis_obj->sAdd(MIAOSHA_REDIS_PARTICIPATE, $phone);
if (!$ret) {
	$data =array('msg'=>'phone add set errror');
	echo $callback.'('.json_encode($data).')';
	exit;
}else{
	$data =array('msg'=>'ok');//初始化数据
}

$redis_obj->close();

$ret = sendOver($phone);
if (!$ret) {
	$data =array('msg'=>'curl add mysql error');//初始化数据
}

//返回给level2
echo $callback.'('.json_encode($data).')';
exit;
?>

<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

for ($i = 0; $i < 10; $i++) {
	$key= sprintf("pid:%d_time:%d_i:%d",getmypid(),time(),$i);
	$result = $redis->set($key, "val:".time());
	echo $result = $redis->get($key);
}

?>

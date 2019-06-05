<?php
$mem  = new Memcached();
$mem->addServer('127.0.0.1',11211);

for ($i = 0; $i < 10; $i++) {
	$key= sprintf("pid:%d_time:%d_i:%d",getmypid(),time(),$i);
	if( $mem->add($key,"val:".time(),3600)){
		//echo  '原始数据缓存成功!';
	}else{
		//echo '数据已存在：';
	}
	echo $mem->get($key);
}
?>

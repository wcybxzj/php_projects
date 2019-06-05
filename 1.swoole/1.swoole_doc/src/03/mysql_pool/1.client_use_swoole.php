<?php
function work($socket)
{
	$name1 = 'name1'.date('Y-m-d H:i:s');
	$name2 = 'name2'.date('Y-m-d H:i:s');
	$data = array(
		'first_name'=>$name1,
		'last_name'=>$name2,
	);
	$buf = json_encode($data);
	$len = strlen($buf);
	socket_send ( $socket , $buf , $len , 0);
}

$clients = array();
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
socket_connect($socket,'192.168.91.11',9501);

for ($i = 0; $i < 100; $i++) {
	work($socket);
}

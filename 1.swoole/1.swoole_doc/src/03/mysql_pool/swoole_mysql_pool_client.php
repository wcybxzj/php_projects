<?php

class Client
{
	private $client;
	private $i = 0;
	private $time;

	public function __construct() {
		$this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
		$this->client->on('Connect', array($this, 'onConnect'));
		$this->client->on('Receive', array($this, 'onReceive'));
		$this->client->on('Close', array($this, 'onClose'));
		$this->client->on('Error', array($this, 'onError'));
	}

	public function connect() {
		$fp = $this->client->connect("127.0.0.1", 9501 , 1);
		if( !$fp ) {
			echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
			return;
		}
	}

	public function onReceive( $cli, $data ) {
		$this->i ++;
		if( $this->i >= 10000 ) {
			echo "Use Time: " . ( time() - $this->time);
			exit(0);
		}
		else {
			var_dump($data);
			die();
		}
	}

	public function onConnect($cli) {
		$name1 = 'name1'.date('Y-m-d H:i:s');
		$name2 = 'name2'.date('Y-m-d H:i:s');
		$data = array(
			'first_name'=>$name1,
			'last_name'=>$name2,
		);
		$data = json_encode($data);
		$cli->send($data);
		$this->time = time();
	}

	public function onClose( $cli) {
		echo "Client close connection\n";
	}

	public function onError() {

	}

	public function send($data) {
		$this->client->send( $data );
	}

	public function isConnected() {
		return $this->client->isConnected();
	}
}

$cli = new Client();
$cli->connect();

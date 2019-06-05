<?php

class MySQLPool
{
	private $serv;
	private $pdo;

	public function __construct() {
		$this->serv = new swoole_server("0.0.0.0", 9501);
		$this->serv->set(array(
			'worker_num' =>32,
			'daemonize' => false,
			'max_request' => 10000,
			'dispatch_mode' => 3,
			'debug_mode'=> 1 ,
			'task_worker_num' => 32
		));

		$this->serv->on('WorkerStart', array($this, 'onWorkerStart'));
		$this->serv->on('Connect', array($this, 'onConnect'));
		$this->serv->on('Receive', array($this, 'onReceive'));
		$this->serv->on('Close', array($this, 'onClose'));
		// bind callback
		$this->serv->on('Task', array($this, 'onTask'));
		$this->serv->on('Finish', array($this, 'onFinish'));
		$this->serv->start();
	}

	public function onWorkerStart( $serv , $worker_id) {
		echo "onWorkerStart\n";
		// 判定是否为Task Worker进程
		if( $worker_id >= $serv->setting['worker_num'] ) {
			$this->pdo = new PDO(
				"mysql:host=192.168.91.11;port=3306;dbname=test_db",
				"root",
				"root",
				array(
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8';",
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_PERSISTENT => true
				)
			);
		}
	}

	public function onConnect( $serv, $fd, $from_id ) {
		echo "Client {$fd} connect\n";
	}

	public function onReceive( swoole_server $serv, $fd, $from_id, $data ) {
		$data = json_decode($data,1);
		//var_dump($data); die();
		$first_name=$data['first_name'];
		$last_name=$data['last_name'];
		$sql = array(
			'sql'=>" INSERT INTO `actor` (`actor_id`, `first_name`, `last_name`, `last_update`) VALUES
			(NULL, '$first_name', '$last_name', CURRENT_TIMESTAMP)",
		'fd' => $fd
		);
		//echo $sql['sql'];die();
		$serv->task($sql);
	}

	public function onClose( $serv, $fd, $from_id ) {
		echo "Client {$fd} close connection\n";
	}

	public function onTask($serv,$task_id,$from_id, $data) {
		try{
			//var_dump($data);die();
			$statement = $this->pdo->exec($data['sql']);
			//$serv->send( $data['fd'],"Insert");
			return true;
		} catch( PDOException $e ) {
			var_dump( $e );
			return false;
		}
	}

	public function onFinish($serv,$task_id, $data) {
		echo "task finish\n";
	}
}

new MySQLPool();

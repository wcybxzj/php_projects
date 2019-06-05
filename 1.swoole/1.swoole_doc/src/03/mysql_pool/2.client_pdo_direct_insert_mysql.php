<?php

class myclass
{
	private $pdo;

	public function __construct($pconnect) {
		$this->pdo = new PDO(
			"mysql:host=192.168.91.11;port=3306;dbname=test_db",
			"root",
			"root",
			array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8';",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => $pconnect
			)
		);
	}

	public function work() {
		$first_name= 'direct_name1:'.date("Y-m-d H:i:s");
		$last_name= 'direct_name2:'.date("Y-m-d H:i:s");

		$sql=" INSERT INTO `actor` (`actor_id`, `first_name`, `last_name`, `last_update`) VALUES
		(NULL, '$first_name', '$last_name', CURRENT_TIMESTAMP)";

		try{
			$statement = $this->pdo->exec($sql);
			return true;
		} catch( PDOException $e ) {
			var_dump( $e );
			return false;
		}
	}

	public function close()
	{
		$this->pdo= null;
	}
}

if ($_GET['pconnect']=='true') {
	echo "pconnect<br>";
	$obj = new myclass(true);
}else{
	echo "connect<br>";
	$obj = new myclass(false);
}

for ($i = 0; $i < 100; $i++) {
	$obj->work();
}

if ($_GET['close']=='true') {
	echo "close<br>";
	$obj->close();
	unset($obj);
}else{
	echo "not close<br>";
}

<?php

class myclass
{
	private $pdo;

	public function __construct($pconnect) {
		$servername = "192.168.91.11";
		$username = "root";
		$password = "root";
		$dbname = "test_db";

		if ($pconnect==true) {
			// 创建连接
			$this->conn = new mysqli("p:".$servername, $username, $password, $dbname) or die("mysql connect error");
		}else{
		// 创建连接
			$this->conn = new mysqli($servername, $username, $password, $dbname) or die("mysql connect error");
		}
	}

	public function work() {
		$first_name= 'direct_name1:'.date("Y-m-d H:i:s");
		$last_name= 'direct_name2:'.date("Y-m-d H:i:s");

		$sql=" INSERT INTO `actor` (`actor_id`, `first_name`, `last_name`, `last_update`) VALUES
		(NULL, '$first_name', '$last_name', CURRENT_TIMESTAMP)";

		if ($this->conn->query($sql) === TRUE) {
		    echo "insert ok ";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	public function close()
	{
		$this->conn->close();
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
		echo "</br>";

if ($_GET['close']=='true') {
	echo "close<br>";
	$obj->close();
	unset($obj);
}else{
	echo "not close<br>";
}

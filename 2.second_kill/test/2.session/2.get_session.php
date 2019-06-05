<?php
session_start();
if ( isset($_SESSION['start'])) {
	echo $_SESSION['start'];
}else{
	echo 'not set!';
}
?>

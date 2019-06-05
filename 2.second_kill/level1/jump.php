<?php
include_once ("../config.php");
echo '开始时间:'.$start_time;
echo '结束时间:'.$end_time;
if (time()>$start_time && time()<$end_time) {
	header("Location:$login_page");
}else if(time()<$start_time){
	header("Location:$login_page");
}else{
	header("Location:$over_page");
}
die();

?>

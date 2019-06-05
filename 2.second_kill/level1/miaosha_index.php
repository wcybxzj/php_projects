<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<script type="text/javascript" charset="utf-8" src="../jquery-3.3.1.min.js"></script>
	<title></title>
</head>

<body>
	<h1>秒杀展示页</h1>

<?php
include_once ("../config.php");
echo "<h1>";
echo '开始时间:'.date("Y-m-d H:i:s",$start_time);
echo "<br>";
echo '结束时间:'.date("Y-m-d H:i:s",$end_time);
echo "<br>";
echo '当前时间:'.date("Y-m-d H:i:s");
echo "</h1>";

if (time()>$start_time && time()<$end_time) {
	echo '<h1>在活动中</h1>';
	echo '倒计时js实现 开始还有xxx秒';
	echo <<<EOT
		<button onclick="window.location.href='./jump.php'">Continue</button>
EOT;
}else if(time()<$start_time){
	echo '<h1>活动马上开始</h1>';
	echo '倒计时js实现 开始还有xxx秒';
}else if(time()>$end_time){
	echo '<h1>活动已经结束</h1>';
	//header("Location:$over_page");
}
?>


<div id="start_time"></div>


</body>
<script>
$.ajax({
    type: 'HEAD', // 获取头信息，type=HEAD即可
    url : window.location.href,
    complete: function( xhr,data ){
        // 获取相关Http Response header
        var wpoInfo = {
            // 服务器端时间
            "date" : xhr.getResponseHeader('Date'),
            // 如果开启了gzip，会返回这个东西
            "contentEncoding" : xhr.getResponseHeader('Content-Encoding'),
            // keep-alive ？ close？
            "connection" : xhr.getResponseHeader('Connection'),
            // 响应长度
            "contentLength" : xhr.getResponseHeader('Content-Length'),
            // 服务器类型，apache？lighttpd？
            "server" : xhr.getResponseHeader('Server'),
            "vary" : xhr.getResponseHeader('Vary'),
            "transferEncoding" : xhr.getResponseHeader('Transfer-Encoding'),
            // text/html ? text/xml?
            "contentType" : xhr.getResponseHeader('Content-Type'),
            "cacheControl" : xhr.getResponseHeader('Cache-Control'),
            // 生命周期？
            "exprires" : xhr.getResponseHeader('Exprires'),
            "lastModified" : xhr.getResponseHeader('Last-Modified')
        };
		$( "#start_time" ).html(wpoInfo.date);
		//var date_start = new Date("2018-05-16 03:00:00").getTime();
		//$( "#start_time" ).html(date_start);
    }
});
</script>

</html>

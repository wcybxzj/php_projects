<?php
include_once('../config.php');
?>
<html>
<head>
	<script type="text/javascript" charset="utf-8" src="../jquery-3.3.1.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="../jquery.cookie.js"></script>
</head>
<body>
	<div id="msg"></div>
	<div id="jsonp"></div>
	用户登录
	<form action="" method="get" accept-charset="utf-8">
		电话:
		<input type="text" name="phone" id="phone" value="<?php echo time();?>">
		token:
		<input type="text" name="token"id ="token" value="<?php echo create_token();?>">
	</form>
		<button id='sub'>提交</button>
</body>
<script>
$(function(){
	var url = '<?php echo $data_middle_page;?>';
	//电话检查
	function check(phone){
		return true;
	}

	function success_jsonpCallback(data)
	{
		if (data.msg=='ok') {
			$("#jsonp").html("JSOPN OK");
			$.cookie('miao','ok');
		}else{
			$("#jsonp").html(data.msg);
			$.cookie('miao',null);
		}
	}

	$("#sub").click(function(){
		var phone = $("#phone").val();
		var token = $("#token").val();
		var data = {'phone':phone, 'token':token};
		var res = check(phone);
		if (res) {
			$.ajax({
				url:url,
				data:data,
				//async:false,
				async:true,
				dataType:'jsonp',
				jsonp:'callback',
				jsonpCallback:'success_jsonpCallback',
				success:function(cc){
					success_jsonpCallback(cc);
				},
				error:function()
				{
					//alert("error");
					$.cookie('miao',null);
				},
				//timeout:50000,
			});
		}
	});

	//var miao = $.cookie('miao');
	//if (miao) {
	//	$("#msg").html("已经登录");
	//}
} )
</script>
</html>

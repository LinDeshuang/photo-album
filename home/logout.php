<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
	<?php
		include_once('common/view/head.php');
	?>
</head>
<body>
	<?php
		unset($_SESSION['user']);
		setcookie(session_name(), session_id(), time() - 1, "/"); 
	?>
	<?php
		include_once('../home/common/view/top.php');
	?>
	<div class="layui-container">
		<div class="quote">退出成功！<span id="second"></span>秒后回到主页</div>
	</div>
</body>
	<?php
		include_once('common/view/script.php');
	?>
	<script type="text/javascript">
		var second = 4;
		setInterval(function(){
				second--;
			if(second >= 0){
				$('#second').html(second);
			}
		},1000);
		setTimeout(function(){
			window.location.href = '/index.php';
		},3000);
	</script>
</html>
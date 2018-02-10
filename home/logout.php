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
			header("refresh:2;url='/index.php");
		?>
		<div class="layui-layout layui-layout-admin">
		  <div class="home-header layui-bg-black">
		    <div class="layui-container">
		    <a href="/index.php"><h2 class="layui-logo"><i class='layui-icon'>&#xe857;</i>&nbsp;简易电子相册</h2></a>
		    </div>
		  </div>
		</div>
		<div class="layui-container" style="min-height: 600px;"></div>
		<p class='layui-elem-quote' style="background-color: #fff;position: absolute;top: 50%;left: 50%;width: 200px;height: 100px;line-height: 100px; margin-top: -100px;margin-left: -50px;font-size: 15px;text-align: center;">
			退出成功，正在跳转<i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i>
		</p>
		<?php
		include_once('common/view/foot.php');
		?>
	</body>
</html>
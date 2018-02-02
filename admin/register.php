<!DOCTYPE html>
<html>
<head>
	<title>register page</title>
	<?php
		include_once('common/view/head.php');
	?>
</head>
<body class="layui-bg-blue">
	<?php
		include_once('../home/common/view/top.php');
	?>
	<div class="layui-container">
		<form class="layui-form layui-bg-cyan text-center" style="margin:20% auto;padding:30px;width: 450px;height: 450px;">
			<div class="form-h2">
				<a href="login.php" class="layui-bg-gray">登录</a>
				<a >注册</a>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">用户名</label>
			    <div class="layui-input-block">
			        <input type="text" name="account" placeholder="请输入用户名" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="password" placeholder="请输入密码" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">确认密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="confirm_password" placeholder="请输入密码" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">昵称</label>
			    <div class="layui-input-block">
			        <input type="text" name="nick_name" placeholder="请输入昵称" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">自我介绍</label>
			    <div class="layui-input-block">
			        <textarea name="introduction" placeholder="请输入自我介绍" class="layui-textarea"></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">验证码</label>
			    <div class="layui-input-inline">
			        <input type="password" id="verify_code" name="verify_code" placeholder="请输入验证码" required autocomplete="off" class="layui-input">
			    </div>
			     <img width="100px" height="40px" src="/admin/createCaptcha.php" onclick="this.src = '/admin/createCaptcha.php?time='+Math.random();document.getElementById('verify_code').focus();" alt="点击更换" title="点击更换" style="float:left;cursor: pointer">
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" value="注册" class="layui-btn">
			    </div>
			</div>
		</form>
	</div>
</body>
	<?php
		include_once('common/view/script.php');
	?>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>register page</title>
	<?php
		include_once('common/view/head.php');
	?>
</head>
<body>
	<?php
		include_once('../home/common/view/top.php');
	?>
	<div class="layui-container">
		<form class="layui-form layui-bg-cyan" style="margin:10% auto;padding:30px;width: 500px;">
			<div class="form-h2">
				<a href="login.php" class="layui-bg-gray">登录</a>
				<a >注册</a>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">账号</label>
			    <div class="layui-input-block">
			        <input type="text" name="account" lay-verify="required|account" placeholder="请输入用户名" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="password" lay-verify="required|password" placeholder="请输入密码" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">确认密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="confirm_password" lay-verify="required|password" placeholder="请输入密码" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">昵称</label>
			    <div class="layui-input-block">
			        <input type="text" name="nick_name" lay-verify="required|nickname" placeholder="请输入昵称" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">性别</label>
			    <div class="layui-input-block">
			      <input type="radio" name="gender" value="1" title="男" checked>
			      <input type="radio" name="gender" value="0" title="女" >
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">邮箱</label>
			    <div class="layui-input-block">
			        <input type="text" name="email" placeholder="请输入邮箱" lay-verify="required|email" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">验证码</label>
			    <div class="layui-input-inline">
			        <input type="text" name="verify_code" lay-verify="required|verify_code" placeholder="请输入验证码" required autocomplete="off" class="layui-input">
			    </div>
			     <img width="100px" height="40px" src="/admin/create_captcha.php" onclick="this.src = '/admin/create_captcha.php?time='+Math.random();" alt="点击更换" title="点击更换" style="float:left;cursor: pointer">
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" lay-filter='*' lay-submit  value="注册" class="layui-btn">
			    </div>
			</div>
		</form>
	</div>
</body>
	<?php
		include_once('common/view/script.php');
	?>
	<script type="text/javascript">
		layui.use('form', function(){
		  var form = layui.form;
		  
		  //监听提交
		  form.on('submit(*)', function(data){
		  	var regData = data.field;
		  	if(regData.password!=regData.confirm_password){
		  		layer.msg('两次输入的密码不一样',{icon:5});
		  		$('input[name=confirm_password]').focus();
		  	}else{
		  		$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'register_control.php',
			  		data:regData,
			  		dataType:'json',
			  		method:'post',
			  		success:function(retData){
			  			if(retData.errcode == 0){
			  				layer.alert(retData.errmsg+',&nbsp;&nbsp;<a href="login.php" class="layui-btn">马上去登录</a>',{icon:1});
			  			}else{
			  				layer.msg(retData.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		}
		  		});
			  }
		    return false;
		  });
		});
	</script>
</html>
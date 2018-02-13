<!DOCTYPE html>
<html>
<head>
	<title>请登录</title>
	<?php
		include_once('common/view/head.php');
	?>
</head>
<body>
	<?php
		include_once('common/view/top.php');
	?>
	<div class="layui-container">
		<form class="layui-form layui-bg-cyan text-center" style="margin:10% auto;padding:30px;width: 500px;">
			<div class="form-h2">
				<a >登录</a>
				<a href="register.php" class="layui-bg-gray">注册</a>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">用户名</label>
			    <div class="layui-input-block">
			        <input type="text" name="account" placeholder="请输入用户名" lay-verify="required" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="password" placeholder="请输入密码" lay-verify="required" required autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">验证码</label>
			    <div class="layui-input-inline">
			        <input type="text" name="verify_code" placeholder="请输入验证码" lay-verify="required" required autocomplete="off" class="layui-input">
			    </div>
			    <img width="100px" height="40px" src="/admin/create_captcha.php" onclick="this.src = '/admin/create_captcha.php?time='+Math.random();" alt="点击更换" title="点击更换" style="float:left;cursor: pointer">
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">自动登录</label>
			    <div class="layui-input-block">
			        <input type="checkbox" title="有效期7天" name="auto_login" autocomplete="off" class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" lay-filter='*' lay-submit value="登录" class="layui-btn">
			    </div>
			</div>
		</form>
	</div>
	<?php
		include_once('common/view/foot.php');
	?>
</body>
	<?php
		include_once('common/view/script.php');
	?>
	<script type="text/javascript">
		layui.use('form', function(){
		  var form = layui.form;

		  //监听提交
		  form.on('submit(*)', function(data){
		  	var logData = data.field;
		  	 $('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'login_control.php',
			  		data:logData,
			  		dataType:'json',
			  		method:'post',
			  		success:function(retData){
			  			if(retData.errcode == 0){
			  				layer.msg(retData.errmsg,{icon:1});
			  				setTimeout(function(){window.location.href='/index.php';},1500);
			  			}else{
			  				layer.msg(retData.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		},
			  		error:function(){
			  			layer.msg('登录失败，发生了意料之外的错误',{icon:5});
			  		}
	  			});
		    return false;
		  });


		});
	</script>
</html>
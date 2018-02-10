<!DOCTYPE html>
<html>
<head>
	<title>相册管理后台</title>
	<?php
		include_once('common/view/head.php');
	?>
</head>
<body class="layui-layout-body">
	<?php
		$id = $_SESSION['user_id'];
		$user_info = $_DB->query("SELECT * FROM user WHERE id = {$id}");
		extract($user_info[0]);
	?>
	<?php
		include_once('common/view/top.php');
	?>	
	<?php
		include_once('common/view/nav.php');
	?>

  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-tab layui-tab-brief">
	  <ul class="layui-tab-title">
	    <li class="layui-this">基本信息</li>
	    <li>帐号设置</li>
	  </ul>
	  <div class="layui-tab-content">
	  	<div class="layui-tab-item layui-show">
	  		<!-- 基本信息 -->
	  		 <div style="padding: 15px;">
		    	<ul class="layui-timeline">
				  <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h3 class="layui-timeline-title">我的资料</h3>
				      <img id="photo" src="<?php echo $user_info[0]['photo'];?>" class="layui-anim layui-anim-up" alt="用户头像" title="用户头像" width="200px" height="200px" style="border:solid 2px #2F4056;border-radius: 50%;"><br>
				      <a href="/admin/set_head_photo.php" class="layui-btn" style="margin: 10px 50px;">
				      	<i class="layui-icon">&#xe60d;</i>设置头像
				      </a>
				    </div>
				  </li>
				  <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h4 class="layui-timeline-title layui-bg-cyan" style="height: 40px;padding: 5px;line-height: 2em;">昵称：<?php echo $nick_name;?>&nbsp;&nbsp;
				      	<button class="layui-btn" id="nickName"> 
				      		<i class="layui-icon">&#xe642;</i>&nbsp;修改
				      	</button>
				      </h4>
				    </div>
				  </li>
				   <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h4 class="layui-timeline-title layui-bg-cyan" style="height: 40px;padding: 5px;line-height: 2em;">性别：<?php if($gender=='1'){echo "男&nbsp;<i class='layui-icon'>&#xe662;</i>";}else if($gender=='2'){echo "女<i class='layui-icon'>&#xe661;</i>";}else{echo "未知";} ?></h4>
				    </div>
				  </li>
				  <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h4 class="layui-timeline-title layui-bg-cyan" style="height: 40px;padding: 5px;line-height: 2em;">邮箱：<?php echo $email;?></h4>
				    </div>
				  </li>
				   <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h4 class="layui-timeline-title layui-bg-cyan" style="height: 40px;padding: 5px;line-height: 2em;">自我介绍&nbsp;&nbsp;
				      	<button class="layui-btn" id="introduction"> 
				      		<i class="layui-icon">&#xe642;</i>&nbsp;修改
				      	</button>
				      </h4>
				      <p>
				      	<?php 
				      		if(empty($introduction)){
				      			echo "什么都没写呢！";
				      		}else{
				      			echo htmlspecialchars_decode($introduction);
				      		}
				      	?>
				      </p>
				    </div>
				  </li>
				  <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h4 class="layui-timeline-title layui-bg-cyan" style="height: 40px;padding: 5px;line-height: 2em;">注册时间</h4>
				      <p>
				        <?php
				        	echo date('Y:m:d',$create_time);
				        ?>
				      </p>
				    </div>
				  </li>
				</ul>
		    </div>
	  	</div>
	  	<div class="layui-tab-item">
	  		<!-- 帐号设置 -->
	  			<form class="layui-form text-center" style="margin:5% auto;padding:30px;width: 500px;">
					<div class="layui-form-item">
					    <label class="layui-form-label">用户名</label>
					    <div class="layui-input-block">
					        <input type="text" name="account" autocomplete="off" class="layui-input" value="<?php echo $account?>" disabled="disabled">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">原密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="old_password" placeholder="请输入原密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">新密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="password" placeholder="请输入新密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">确认密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="confirm_password" placeholder="请再次输入新密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-block">
					    	<input type="submit" lay-filter='*' lay-submit value="修改" class="layui-btn">
					    </div>
					</div>
				</form>
	  	</div>
	  </div>
	</div> 
   
  </div>
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    相册管理后台
  </div>
</div>
	<?php
		include_once('common/view/script.php');
	?>
	<script type="text/javascript">
		$(function(){
			$('#nickName').click(function(){
				layer.alert('<form id="msgForm1">\
								<div class="layui-form-item">\
								        <input value="<?php echo $nick_name;?>" type="text" name="nick_name" lay-verify="required|nickname" placeholder="请输入昵称" required autocomplete="off" class="layui-input">\
								</div>	\
							</form>',
							{
								title:'修改昵称'
						},function(index){
						  var nick_name = $('#msgForm1').find('input[name=nick_name]').val();
						  $.ajax({
						  	url:'update_info.php',
						  	data:{
						  		type:1,
						  		nick_name:nick_name
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			setTimeout(function(){window.location.reload();},1500);
						  		}else {
						  			layer.msg(retData.errmsg,{icon:5});
						  		}
								layer.close(index);
						  	},
						  	error:function(){
								layer.close(index);
						  	}
						  });

						});
			});
			$('#introduction').click(function(){
			layer.alert('<form id="msgForm2">\
							<div class="layui-form-item">\
							        <textarea cols="50" rows="50" value="<?php echo htmlspecialchars_decode($introduction);?>" name="introduction" lay-verify="required|introduction" placeholder="请输入简介" required autocomplete="off" class="layui-input"></textarea>\
							</div>	\
						</form>',
						{
							title:'修改自我介绍',
							area:['300px','200px']
					},function(index){
					  var introduction = $('#msgForm2').find('textarea[name=introduction]').val();
					  $.ajax({
						  	url:'update_info.php',
						  	data:{
						  		type:2,
						  		introduction:introduction
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			setTimeout(function(){window.location.reload();},1500);
						  			
						  		}else {
						  			layer.msg(retData.errmsg,{icon:5});
						  		}
								layer.close(index);
						  	},
						  	error:function(){
								layer.close(index);
						  	}
						  });
					});
			});
		});
		//帐号设置异步处理
		layui.use('form', function(){
		  var form = layui.form;

		  //监听提交
		  form.on('submit(*)', function(data){
		  	var upData = data.field;
		  		//异步提交
		  		if(upData.password!=upData.confirm_password){
		  			layer.msg('两次输入的密码不一样',{icon:5});
		  		}else{
		  			$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  			$.ajax({
		  				url:'update_info.php',
		  				data:{
		  					type:3,
		  					data:upData
		  				},
		  				method:'post',
		  				dataType:'json',
		  				success:function(retData){
		  					if(retData.errcode == 0){
						  		layer.msg(retData.errmsg,{icon:1});
					  			setTimeout(function(){window.location.reload();},1500);
		  					}else {
						  		layer.msg(retData.errmsg,{icon:5});
		  					}
						  	$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
		  				}
		  			});
		  		}
		    return false;
		  });
		});

		//设置头像
		layui.use('upload',function(){
			var upload = layui.upload;

			var uploadInst = upload.render({
				elem: '#changePhoto',
				url: '/upload/',
				done: function(res){
					console.log(res);
				},
				error: function(){
					alert('error');
				}
			});
		});
	</script>
</body>
</html>
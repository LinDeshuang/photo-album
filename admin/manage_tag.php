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
		include_once('common/view/top.php');
	?>	
	<?php
		include_once('common/view/nav.php');
	?>

  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-container" style="padding: 15px;">
    	<blockquote class="layui-elem-quote"><h3>创建新的相册标签</h3></blockquote>
    	<form class="layui-form" action="" style="margin: 20px;">
		  <div class="layui-form-item">
		    <label class="layui-form-label">标签</label>
		    <div class="layui-input-block">
		      <input type="text" name="tag_name" required lay-verify="required" placeholder="请输入标签名" autocomplete="off" class="layui-input">
		    </div>
		  </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">标签颜色</label>
		    <div class="layui-input-block">
		        <input type="radio" name="tag_color" value="red" checked title="<span class='layui-badge layui-bg-red'>赤色</span>">
		        <input type="radio" name="tag_color" value="orange" title="<span class='layui-badge layui-bg-orange'>橙色</span>">
		        <input type="radio" name="tag_color" value="green" title="<span class='layui-badge layui-bg-green'>绿色</span>">
		        <input type="radio" name="tag_color" value="blue" title="<span class='layui-badge layui-bg-blue'>蓝色</span>">
		        <input type="radio" name="tag_color" value="cyan" title="<span class='layui-badge layui-bg-cyan'>藏青</span>">
		        <input type="radio" name="tag_color" value="black" title="<span class='layui-badge layui-bg-black'>黑色</span>">
		    </div>
		  </div>
		  <div class="layui-form-item">
		    <div class="layui-input-block">
		      <button class="layui-btn" type="submit" lay-submit lay-filter="*">创建</button>
		    </div>
		  </div>
		</form>
    	<blockquote class="layui-elem-quote"><h2>我的相册标签<span class="layui-badge layui-bg-gray">点击标签可删除</span></h2></blockquote>
    	<?php
    		$user_id = $_SESSION['user_id']; 
    		$tag_info = $_DB->query("SELECT * FROM album_tag WHERE user_id = {$user_id} and d_time = 0 ORDER BY create_time DESC");
    		if(!$tag_info){
    			echo "<blockquote class='layui-elem-quote layui-quote-nm'>还没有任何标签呢！</blockquote>";
    		}else{
    			foreach ($tag_info as $key => $value) {
    				echo "<span data-id={$value['id']} class='layui-btn layui-bg-{$value['tag_color']} tag-btn'>{$value['tag_name']}&nbsp;<i class='layui-icon'>&#x1006;</i></span>";
    			}
    		}
    	 ?>
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
		layui.use('form',function(){
			var form = layui.form;

			 //监听提交
		  form.on('submit(*)', function(data){
		  	if(data.field.tag_name.length>10){
		  		layer.msg('标签名长度不能大于10',{icon:5});
		  	}else{
		  		$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'manage_tag_control.php',
			  		data: data.field,
			  		dataType:'json',
			  		method:'post',
			  		success:function(retData){
			  			if(retData.errcode == 0){
			  				layer.msg(retData.errmsg,{icon:1});
			  				setTimeout(function(){window.location.reload()},1500);
			  			}else{
			  				layer.msg(retData.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		},
			  		error:function(){
			  			layer.msg('网络出错，稍后再试',{icon:5});
			  		}
		  		});
			  }
		    return false;
		  });
		});
		$(function(){
			$('.tag-btn').each(function(Index){
				$(this).click(function(){
					var tag_id = $(this).attr('data-id');
					layer.confirm('确定删除？',function(index){
						$.ajax({
						  	url:'delete_tag.php',
						  	data:{
						  		id: tag_id
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			$('.tag-btn').eq(Index).fadeOut();
						  		}else {
						  			layer.msg(retData.errmsg,{icon:5});
						  		}
						  		layer.close(index);
						  	},
						  	error:function(){
						  		layer.close(index);
								layer.msg('网络出错了，请稍后再试',{icon:5});
						  	}
						  });
					});
				})
			})
		})
	</script>
</html>
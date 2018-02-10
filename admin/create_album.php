<?php
	require('../class/page.php');
?>
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
    	<blockquote class="layui-elem-quote"><h3>创建新的相册</h3></blockquote> 
    	<form class="layui-form" style="margin: 20px;">
		  <div class="layui-form-item">
		    <label class="layui-form-label">相册名称</label>
		    <div class="layui-input-block">
		      <input type="text" name="album_name" required lay-verify="required" placeholder="请输入相册名" autocomplete="off" class="layui-input">
		    </div>
		  </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">相册简介</label>
		    <div class="layui-input-block">
		        <textarea name="album_intro" required lay-verify="required|introduction" placeholder="请输入相册简介" class="layui-textarea"></textarea>
		    </div> 
		  </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">相册类型</label>
		    <div class="layui-input-block">
		        <input type="radio" name="album_type" value="1" checked title="公开">
		        <input type="radio" name="album_type" value="0" title="私有">
		    </div> 
		  </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">相册标签</label>
		    <div class="layui-input-block">
		    	<span id="tag-box">
		    		<?php
				      	$user_id = $_SESSION['user_id']; 
			    		$tag_info = $_DB->query("SELECT * FROM album_tag WHERE user_id = {$user_id} and d_time = 0 ORDER BY create_time");
			    		if($tag_info){
			    			foreach ($tag_info as $key => $value) {
			    				echo "<span check='0' data-id={$value['id']} class='layui-btn layui-bg-{$value['tag_color']} layui-bg-gray tag-btn'>{$value['tag_name']}</span>";
			    			}
			    		}
				      ?>
		    	</span>
		        <button class="layui-btn layui-btn-normal" id="addTag"><i class="layui-icon">&#xe608;</i></button>
		    </div>
		  </div>
		  <div class="layui-form-item">
		    <div class="layui-input-block">
		      <button class="layui-btn" type="submit" lay-submit lay-filter="album_submit">创建</button>
		    </div>
		  </div>
		</form>
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
	//选中标签方法
	function checkTag(obj){
		if($(obj).attr('check') == 0){
			$(obj).attr('check',1).removeClass('layui-bg-gray');
		}else{
			$(obj).attr('check',0).addClass('layui-bg-gray');
		}
	}		  
	$(function(){
		layui.use('form', function(){
				  var form = layui.form;
		//添加标签
			$('#addTag').click(function(){
				layer.alert('<form class="layui-form" id="addTagForm">\
						  <div class="layui-form-item">\
						  	  <label class="layui-form-label">标签名称</label>\
						  	  <div class="layui-input-block">\
						      <input type="text" name="tag_name" required lay-verify="required" placeholder="请输入标签名" autocomplete="off" class="layui-input">\
						       </div>\
						  </div>\
						  <div class="layui-form-item">\
						    <label class="layui-form-label">标签颜色</label>\
						    <div class="layui-input-block" >\
						        <input type="radio" name="tag_color" value="red" checked><span class="layui-badge layui-bg-red">赤色</span><br>\
						        <input type="radio" name="tag_color" value="orange"><span class="layui-badge layui-bg-orange">橙色</span><br>\
						        <input type="radio" name="tag_color" value="green"><span class="layui-badge layui-bg-green">绿色</span><br>\
						        <input type="radio" name="tag_color" value="blue"><span class="layui-badge layui-bg-blue">蓝色</span><br>\
						        <input type="radio" name="tag_color" value="cyan"><span class="layui-badge layui-bg-cyan">藏青</span><br>\
						        <input type="radio" name="tag_color" value="black"><span class="layui-badge layui-bg-black">黑色</span><br>\
						    </div>\
						  </div>\
						</form>'
					,{title: '添加标签',area:['400px','400px']}
					,function(index){
						var tag_name = $('#addTagForm').find('input[name=tag_name]').val();
						if(tag_name==''){
							layer.msg('标签名不能为空',{icon:5});
						}else if(tag_name.length>10){
							layer.msg('标签名长度不能超过10',{icon:5});
						}else{
							var data = $('#addTagForm').serialize();
							$.ajax({
							  	url:'manage_tag_control.php',
							  	data:data,
							  	method:'post',
							  	dataType:'json',
							  	success:function(retData){
							  		if(retData.errcode == 0){
							  			layer.msg(retData.errmsg,{icon:1});
							  			$('#tag-box').append('<span onclick="checkTag(this)" check="0" data-id="'+retData.tag_id+'" class="layui-btn layui-bg-'+retData.tag_color+' layui-bg-gray tag-btn">'+tag_name+'</span>')
							  		}else {
							  			layer.msg(retData.errmsg,{icon:5});
							  		}
									layer.close(index);
							  	},
							  	error:function(){
							  		layer.msg('网络出错，请稍后再试',{icon:5});
									layer.close(index);
							  	}
							  });
						}
					});
					form.render();
					return false;
			});
			//提交表单数据
			form.on('submit(album_submit)',function(data){
				if(data.field.album_name.length>20){
					layer.msg('相册名称长度不能大于10',{icon:5});
				}else if (data.field.album_intro.length>200){
					layer.msg('相册简介长度不能大于200',{icon:5});
				}else {
					var tag_set = [];
					$('.tag-btn').each(function(Index){
						if($(this).attr('check')==1){
							tag_set.push($(this).attr('data-id'));
						}
					});
					data.field.tag_set = tag_set;
					if(tag_set==[]){
						layer.msg('没选标签呢！',{icon:5});
					}else{
						$.ajax({
						  	url:'create_album_control.php',
						  	data:data.field,
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			setTimeout(function(){window.location.href='/admin/manage_album.php?nav=2-4'},1500);
						  		}else {
						  			layer.msg(retData.errmsg,{icon:5});
						  		}
						  	},
						  	error:function(){
						  		layer.msg('网络出错，请稍后再试',{icon:5});
						  	}
						  });
					}
					
				}
				return false;
			});
		});

		$('.tag-btn').each(function(Index){
			$(this).click(function(){
				checkTag(this);
			});
		})
	});


	</script>
</body>
</html>
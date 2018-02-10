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
    	<blockquote class="layui-elem-quote"><h2>照片上传&nbsp;&nbsp;<span class="layui-badge layui-bg-orange">注意！仅支持5M以下的jpg,jpeg,bmp,gif,png图片</span></h2></blockquote>
    	<form class="layui-form" action="" style="margin: 20px;">
    		<div class="layui-form-item">
    			<div class="layui-input-block">
    				<img id="defaultImg" src="/public/static/images/default.png" width="200px" height="200px" title="请上传图片">    				
    			</div>
    		</div>
    		<input type="hidden" name="photo_id" id="photoId">
    		<input type="hidden" name="type" value="info">
    	    <div class="layui-form-item">
    	    	<div class="layui-input-block">
				    <button type="button" class="layui-btn layui-btn-normal" id="uploadPhoto">
					      	<i class="layui-icon">&#xe67c;选择照片</i>
			        </button>
		    	</div>
		    </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">照片命名</label>
		    <div class="layui-input-block">
		      <input type="text" name="photo_name" required lay-verify="required" placeholder="请输入照片命名" autocomplete="off" class="layui-input">
		    </div>
		  </div>
		  <div class="layui-form-item layui-form-text">
		    <label class="layui-form-label">备注</label>
		    <div class="layui-input-block">
		      <textarea name="note" placeholder="请输入备注，可不填" class="layui-textarea"></textarea>
		    </div>
		  </div>
		  <div class="layui-form-item">
		    <div class="layui-input-block">
		      <button class="layui-btn" type="submit" id="submit" lay-submit lay-filter="*">保存</button>
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
		layui.use(['upload','form'], function(){
		  var upload = layui.upload;
		  var form = layui.form;
		   
		  //执行实例
		  var uploadInst = upload.render({
		    elem: '#uploadPhoto' //绑定元素
		    ,url: 'upload_photo_control.php' //上传接口
		    ,field: 'image'
		    ,size: 5000
		    ,data: {type: 'image'}
		    ,before: function(obj){
		    	layer.load();
		    }
		    ,done: function(res){
		      if(res.errcode == 0){
		      	var id = res.errmsg.id;
		      	var path = res.errmsg.path;
		      	$('#defaultImg').attr('src',path);
		      	$('#photoId').val(id);
		        layer.closeAll('loading');
		        layer.msg('上传成功，完善一下信息后保存吧！',{icon:1});
		      }else{
		      	layer.msg('上传失败，原因：' + res.errmsg,{icon:5});
		      }
		    }
		    ,error: function(){
		      layer.closeAll('loading');
		    }
		  });
		   //监听提交
		  form.on('submit(*)', function(data){
		  	if($('#photo_id').val()==''){
		  		layer.msg('请先上传照片',{icon:5});
		  	}else{
		  		$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'upload_photo_control.php',
			  		data: data.field,
			  		dataType:'json',
			  		method:'post',
			  		success:function(retData){
			  			if(retData.errcode == 0){
			  				layer.confirm('保存成功，继续上传吗？', {icon: 3, title:'提示'}, function(index){
							  layer.close(index);
							  window.location.reload();
							});
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
</body>
</html>
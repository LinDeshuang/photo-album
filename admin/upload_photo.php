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
    	<form class="layui-form" action="" style="margin: 20px;">
    		<div class="layui-form-item">
    			<div class="layui-input-block">
    				<img id="defaultImg" src="/public/static/images/default.png" width="200px" height="200px" title="请上传图片">    				
    			</div>
    		</div>
    	    <div class="layui-form-item">
    	    	<div class="layui-input-block">
				    <button type="button" class="layui-btn layui-btn-normal" id="uploadPhoto">
					      	<i class="layui-icon">&#xe67c;上传照片</i>
			        </button>
		    	</div>
		    </div>
		  <div class="layui-form-item">
		    <label class="layui-form-label">照片命名</label>
		    <div class="layui-input-block">
		      <input type="text" name="photo_name" required  lay-verify="required" placeholder="请输入照片命名" autocomplete="off" class="layui-input">
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
		      <button class="layui-btn" id="submit" lay-submit lay-filter="*">保存</button>
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
		layui.use('upload', function(){
		  var upload = layui.upload;
		   
		  //执行实例
		  var uploadInst = upload.render({
		    elem: '#uploadPhoto' //绑定元素
		    ,url: '/upload/' //上传接口
		    ,auto: false
		    ,bindAction: '#submit'
		    ,field: 'image'
		    ,size: 5000
		    ,choose: function(obj){
	    	 	obj.preview(function(index, file, result){
	    	 		$('#defaultImg').attr('src',result);
	    	 	})
		    }
		    ,before: function(obj){
		    	layer.load();
		    }
		    ,done: function(res){
		      console.log(res);
		      layer.closeAll('loading');
		    }
		    ,error: function(){
		      alert('error');
		      layer.closeAll('loading');
		    }
		  });
		});
	</script>
</html>
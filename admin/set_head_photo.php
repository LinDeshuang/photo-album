<?php
	require('../class/page.php');
	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'photo_name';
	$search_val = isset($_GET['search_val'])?$_GET['search_val']:'';
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
  	<?php
		$user_id = $_SESSION['user_id'];
		$user_info = $_DB->query("SELECT * FROM user WHERE id = {$user_id}");
		extract($user_info[0]);
	?>
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
		<div class="layui-tab layui-tab-brief">
			<ul class="layui-tab-title">
		    	<li><a href="/admin/user.php">基本信息</a></li>
		    	<li  class="layui-this">头像设置</li>
		  	</ul>
	    </div>
	    <img id="photo" src="<?php echo $user_info[0]['photo'];?>" class="layui-anim layui-anim-up" alt="用户头像" title="用户头像" width="200px" height="200px" style="border:solid 2px #2F4056;border-radius: 50%;">
    	<div class="layui-collapse">
		  <div class="layui-colla-item">
		    <h3 class="layui-colla-title">选择一张图片作为头像<span class="layui-badge">设置后重新登录才能看到真正的效果哦</span></h3>
		    <div class="layui-colla-content layui-show">
		    	<?php 
		    	$count = $_DB->rowCount("SELECT * FROM photo WHERE  status = 1 AND user_id = {$user_id} AND d_time = 0 AND {$search_type} LIKE '%{$search_val}%' ");
		    	$page_size = 4;
		    	$url = "/admin/set_head_photo.php?nav=2-4&search_type={$search_type}&search_val={$search_val}&page={page}";
		    	$start = $page_size*($page-1);
		   		$photo_info = $_DB->query("SELECT * FROM photo WHERE status = 1 AND user_id = {$user_id} AND d_time = 0 AND {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$start},{$page_size}  ");


	   			 ?>
	   			 <form class="layui-form layui-form-pane">
				    <label class="layui-form-label">图片搜索</label>
				    <div class="layui-input-inline">
				      <select name="search_type">
						  <option value="photo_name">命名</option>
						  <option value="note" <?php if($search_type == 'note'){echo "selected" ;}?>>备注</option>
					  </select>     
				    </div>
				    <div class="layui-input-inline">
				      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
				      <input type="hidden" name="nav" value="2-4"> 
				      <input type="hidden" name="id" value="<?php echo $id?>"> 
				    </div>
				    <div class="layui-input-inline">
				      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
				      	<i class="layui-icon">&#xe615;</i>
				      </button>  
				    </div>
		     	</form>
		     	<!--输出当前页照片 -->
		    	<div class="layui-row" style="margin-top: 30px;">
		    	 	<?php
		    	 		if(!$photo_info){
		    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>一张照片都没有啊，快去上传吧</blockquote>";
		    	 		}else{
		    	 			foreach ($photo_info as $key => $value) {
		    	 			extract($value);
		    	 			$create_time = date('Y-m-d H:i');
		    	 			echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3 photo-block-admin' style='height:300px;'>
								      <img class='photo layui-anim layui-anim-up' id='photo_{$key}' src='{$path_name}' title='{$photo_name}' note-data = '{$note}' width='80%' height='70%'>
								      <div style='margin: 5px;'>
								      <p class='layui-badge layui-bg-blue'>{$photo_name}</p>
								      <p class='layui-badge layui-bg-gray'><i class='layui-icon'>&#xe60e;</i>{$create_time}</p>
								      </div>
								      <button check='0' photo-id='{$id}' class='layui-btn layui-btn-primary selectPhoto'><i class='layui-icon'>&#xe618;</i>&nbsp;就这张</button>
								    </div>";
		    	 			}
		    	 		} 	
		    	 	 ?>
				</div>
				<!--输出分页栏 -->
		     	<div class="showPage">
		     		<?php 
		 		   		if($count > $page_size){
		   					$Page = new Page($count,$page_size,$page,$url,1);
							echo $Page->p_write();
		   				}
		   		 	?>
		     	</div>
		    </div>
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
			$('.photo').each(function(index){
				//图片提示框
				$(this).hover(function(){
					var tipContent = $(this).attr('note-data');
					layer.tips('备注: '+tipContent,'#photo_'+index);
				});
				//点击看大图
				$(this).click(function(){
					var src = $(this).attr('src');
					var width = $(this).width()*3;
					var height = $(this).height()*3;
					layer.open({
						area: ['60%','90%'],
						title: '查看图片',
						content: '<img src="'+src+'" width="'+width+'" height="'+height+'" style="margin:20px 10%;">'
					})
				});
			});

			$('.selectPhoto').each(function(Index){
					$(this).click(function(){
						var photo_id = $(this).attr('photo-id');
						layer.confirm('你确定吗？',function(index){
							$.ajax({
							  	url:'/admin/set_head_photo_control.php',
							  	data:{
							  		photo_id: photo_id
							  	},
							  	method:'post',
							  	dataType:'json',
							  	success:function(retData){
							  		if(retData.errcode == 0){
							  			layer.msg(retData.errmsg,{icon:1});
							  			setTimeout(function(){ window.location.reload();} ,1500);
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
					});
				
				});
			})
	</script>
</body>
</html>
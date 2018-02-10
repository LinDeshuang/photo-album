<?php
	require('../class/page.php');
	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$album_photo_page = isset($_GET['album_photo_page'])?$_GET['album_photo_page']:1;
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
    <!-- 内容主体区域 -->
    <?php 
    	$album_id = isset($_GET['id'])?$_GET['id']:'';
    	if(empty($album_id)){
    		header('Location:/admin/manage_album.php?nav=2-4');
    	}
    	$user_id = $_SESSION['user_id'];
    	$album_info = $_DB->query("SELECT * FROM album WHERE id = {$album_id}");
    	$tag_info = $_DB->query("SELECT * FROM album_tag WHERE user_id = {$user_id} and d_time = 0 ORDER BY create_time");
    	extract($album_info[0]);
     ?>
    <div class="layui-container" style="padding: 15px;">
    	<blockquote class="layui-elem-quote"><h3><a href="/admin/manage_album.php?nav=2-4">相册管理</a>&nbsp;&nbsp;/&nbsp;&nbsp;相册详情</h3></blockquote> 

    	<table class="layui-table" lay-size="lg">
    		<tbody>
			    <tr>
			      <td width="70px" class="layui-bg-gray">相册名称</td>
			      <td><?php echo $album_name;?></td>
			    </tr>
			     <tr>
			      <td width="70px" class="layui-bg-gray">相册简介</td>
			      <td><?php echo $album_intro;?></td>
			    </tr>
			    <tr>
			      <td width="70px" class="layui-bg-gray">标签</td>
			      <td>
			      	<?php 
			      	$tag_set = explode(',', $tag_set);
							foreach ($tag_info as $key => $value) {
								
								foreach ($tag_set as $k => $v) {
									if( $v == $value['id']){
			    					echo "<span  class='layui-badge layui-bg-{$value['tag_color']}'>{$value['tag_name']}</span>";
			    					}
								}
			    			}
			    	 ?>
			      </td>
			    </tr>
		    </tbody>
    	</table>
		<div class="layui-collapse">
		  <div class="layui-colla-item">
		    <h3 class="layui-colla-title">相册图片<span class="layui-badge">相册的第一张照片将作为封面</span></h3>
		    <div class="layui-colla-content layui-show">
	      		<?php 
			    	$album_photo_count = $_DB->rowCount("SELECT * FROM photo WHERE id IN ({$album_photo}) AND status = 1 and user_id = {$user_id} and d_time = 0");
			    	$album_photo_page_size = 4;
			    	$album_photo_url = "/admin/album_photo.php?id={$album_id}&nav=2-4&search_type={$search_type}&search_val={$search_val}&page={$page}&album_photo_page={page}";
			    	$album_photo_start= $album_photo_page_size*($album_photo_page-1);
			   		$album_photo_info = $_DB->query("SELECT * FROM photo WHERE id IN ({$album_photo}) AND status = 1 and user_id = {$user_id} and d_time = 0 ORDER BY create_time DESC LIMIT {$album_photo_start},{$album_photo_page_size}  ");


	   			?>
	   			<!--输出当前页相册的照片 -->
		    	<div class="layui-row " id="layer-photos-box1" style="margin-top: 30px;">
		    	 	<?php
		    	 		if(!$album_photo_info){
		    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>一张照片都没有啊，快去添加吧</blockquote>";
		    	 		}else{
		    	 			foreach ($album_photo_info as $key => $value) {
		    	 			extract($value);
		    	 			$create_time = date('Y-m-d H:i');
		    	 			echo "<div class='layui-col-xs3 layui-col-sm3 layui-col-md3 photo-block-admin' style='height:300px;'>
								      <img class='photo layui-anim layui-anim-up' id='photo_{$key}' src='{$path_name}' title='{$photo_name}' note-data = '{$note}' width='80%' height='70%'>
								      <div style='margin: 5px;'>
								      <p class='layui-badge layui-bg-blue'>{$photo_name}</p>
								      <p class='layui-badge layui-bg-gray'><i class='layui-icon'>&#xe60e;</i>{$create_time}</p>
								      </div>
								      <button photo-id='{$id}' class='layui-btn layui-btn-danger removePhoto'><i class='layui-icon'>&#x1006;</i>&nbsp;移除</button>
								    </div>";
		    	 			}
		    	 		} 	
		    	 	 ?>
				</div>
				<!--输出当前页相册的照片分页栏 -->
		     	<div class="showPage">
		     		<?php 
		 		   		if($album_photo_count > $album_photo_page_size){
		   					$PageAlbumPhoto = new Page($album_photo_count,$album_photo_page_size,$album_photo_page,$album_photo_url,1);
							echo $PageAlbumPhoto->p_write();
		   				}
		   		 	?>
		     	</div>
	      	</div>
	      </div>
	    </div>
    	<div class="layui-collapse">
		  <div class="layui-colla-item">
		    <h3 class="layui-colla-title">图片库<span class="layui-badge">选中要加入相册的图片，然后点击添加就可以将图片加入相册了</span></h3>
		    <div class="layui-colla-content layui-show">
		    	<?php 
		    	if(empty($album_photo)){
		    		$not_in = '';
		    	}else {
		    		$not_in = "id NOT IN ({$album_photo}) AND";
		    	}
		    	$count = $_DB->rowCount("SELECT * FROM photo WHERE ".$not_in." status = 1 AND user_id = {$user_id} AND d_time = 0 AND {$search_type} LIKE '%{$search_val}%' ");
		    	$page_size = 4;
		    	$url = "/admin/album_photo.php?id={$album_id}&nav=2-4&search_type={$search_type}&search_val={$search_val}&album_photo_page={$album_photo_page}&page={page}";
		    	$start = $page_size*($page-1);
		   		$photo_info = $_DB->query("SELECT * FROM photo WHERE ".$not_in." status = 1 AND user_id = {$user_id} AND d_time = 0 AND {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$start},{$page_size}  ");


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
		    	<div class="layui-row" id="layer-photos-box2" style="margin-top: 30px;">
		    	 	<?php
		    	 		if(!$photo_info){
		    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>一张图片都没有啊，快去上传吧</blockquote>";
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
								      <button check='0' photo-id='{$id}' class='layui-btn layui-btn-primary selectPhoto'><i class='layui-icon'>&#xe618;</i>&nbsp;选中</button>
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
		     	<div style="margin: 10px;width: 100%;text-align: center;">
		     		<button id="addPhoto" class="layui-btn"><i class="layui-icon">&#xe654;</i>&nbsp;添加</button>
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
				//相册图片大图
				layer.photos({
					  photos: '#layer-photos-box1'
					  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
					}); 
				//图片大图
				layer.photos({
					  photos: '#layer-photos-box2'
					  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
					}); 
			});
			//移除图片
			$('.removePhoto').each(function(Index){
				$(this).click(function(){
					var photo_id = $(this).attr('photo-id');
					layer.confirm('确定删除？',function(index){
						$.ajax({
						  	url:'/admin/remove_photo_from_album.php',
						  	data:{
						  		album_id: <?php echo $album_id;?>,
						  		photo_id: photo_id
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			setTimeout(function(){ window.location.href = "/admin/album_photo.php?id=<?php echo $album_id;?>&nav=2-4"; } ,1500);
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
			//选择图片
			$('.selectPhoto').each(function(Index){
				$(this).click(function(){
					if($(this).attr('check')==0){
						$(this).attr('check',1).removeClass('layui-btn-primary');
					}else{
						$(this).attr('check',0).addClass('layui-btn-primary');
					}
				});
			});
			//添加图片
			$('#addPhoto').click(function(){
				var photo_id_set = [];
				$('.selectPhoto').each(function(Index){
					if($(this).attr('check')==1){
						photo_id_set.push($(this).attr('photo-id'));
					}
				});
				if(photo_id_set.length==0){
					layer.msg('还没选图片呢！',{icon:5});
				}else{
					layer.load();
					$.ajax({
						  	url:'/admin/add_photo_to_album.php',
						  	data:{
						  		album_id: <?php echo $album_id;?>,
						  		photo_id_set: photo_id_set
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		layer.closeAll();
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			setTimeout(function(){ window.location.reload(); } ,1500);
						  		}else {
						  			layer.msg(retData.errmsg,{icon:5});
						  		}
						  	},
						  	error:function(){
								layer.closeAll();
								layer.msg('出错了，稍后再试',{icon:5});
						  	}
						  });
				}
			});


		});
	</script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>电子相册管理系统</title>
	<?php
		include_once('common/view/head.php');
		require('../class/db.php');
		require('../class/page.php');
		//获取当前页号
		$page = isset($_GET['page'])?$_GET['page']:1;
		if(!isset($_GET['user_id'])){
			header('Location:/index.php');
		}else{
			$user_id = $_GET['user_id'];
		}
		$user_info = $_DB->query("SELECT * FROM user WHERE id={$user_id}");
		extract($user_info[0]);
	?>
</head>
	<body>
		<!-- 顶部 -->
		<?php
			include_once('common/view/top.php');
		?>
		<!-- 内容主体区域 -->
		<div class="layui-container" style="padding: 15px;min-height:700px;">
			<p class='layui-elem-quote' style="background-color: #fff;">用户详情</p>
			<div class="layui-container  user-detail-container"  style="background-color: #fff;width: 100%; padding: 20px;">
					<div class='user-info-bar'>
				 		<?php 
				 			echo "<a href='/home/user_detail.php?user_id={$user_id}' class='head-img'><img src='{$photo}' ></a>
							    <a href='/home/user_detail.php?user_id={$user_id}' class='nick-name-bar'>{$nick_name}</a>";
										
				 		 ?>
		 		 	</div>
		 		<div class="user-detail-box">
	 		 		<p class='layui-elem-quote layui-quote-nm'>性别：<?php if($gender){echo "男&nbsp;<i class='layui-icon'>&#xe662;</i>";}else{echo "女<i class='layui-icon'>&#xe661;</i>";} ?></p> 
	 		 		<p class='layui-elem-quote layui-quote-nm'>简介：<?php if(empty($introduction)){echo "<i class='layui-icon'>&#xe69c;</i>&nbsp;他很懒，什么都没写";}else{echo $introduction;} ?></p> 
	 		 		<p class='layui-elem-quote layui-quote-nm'>邮箱：<?php echo $email; ?></p> 

	 		 		<p class='layui-elem-quote' style="background-color: #fff;">他的相册</p> 

	 		 		<div class=" user-album">

	 		 			<?php 
							$tag_info = $_DB->query("SELECT * FROM album_tag WHERE d_time=0");
							$all_album_count = $_DB->rowCount("SELECT * FROM album WHERE status=1 AND d_time=0 AND album_type=1 AND album_photo != '' AND user_id = {$user_id} ");
							$page_size = 8;
							$start = $page_size*($page-1);
							$url = "/home/user_detail.php?page={page}";
							$album_info = $_DB->query("SELECT * FROM album WHERE status=1 AND d_time=0 AND album_type=1 AND album_photo != '' AND user_id = {$user_id}  ORDER BY create_time  DESC LIMIT {$start},{$page_size}");
						 ?>
						 <div class="layui-container" style="background-color: #fff;width: 100%; padding: 20px;">
						 	<div class="layui-row">
						 	<?php
			    	 		if(!$album_info){
			    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>目前还没有公开的相册</blockquote>";
			    	 		}else{
			    	 			foreach ($album_info as $key => $value) {
			    	 			extract($value);
			    	 			$create_time = date('Y-m-d H:i');
			    	 			$cover_photo_id = explode(',',$album_photo)[0];
			    	 			$cover = $_DB->query("SELECT id, path_name FROM photo WHERE id = {$cover_photo_id}")[0]['path_name'];
			    	 			echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3 album-block-home'>
									      <a class='album' id='album_{$key}' data-album-type={$album_type} data-album-intro = '{$album_intro}' href='/home/album_detail.php?album_id={$id}'>
									      	<img class=' layui-anim layui-anim-up'  src='{$cover}' title='{$album_name}' >
									      </a>
									      <div style='margin: 5px;'>
									      <p class='layui-badge layui-bg-blue'>{$album_name}</p>
									      <p class='layui-badge layui-bg-gray'><i class='layui-icon'>&#xe60e;</i>{$create_time}</p><br>
									      <p class='layui-badge'><i class='layui-icon'>&#xe658;</i>点击量:{$click_count}</p>
									      </div>
									      <div class='tag-bar'>标签：";
								//标签处理
								        $tag_set = explode(',', $tag_set);
										foreach ($tag_info as $key => $value) {
											
											foreach ($tag_set as $k => $v) {
												if( $v == $value['id']){
						    					echo "<span  class='layui-badge layui-bg-{$value['tag_color']}'>{$value['tag_name']}</span>";
						    					}
											}
						    			}
						    			echo "</div></div>";
				    	 			}
				    	 		} 	
				    	 	 ?>
						 	</div>
						 </div>
					 	<!--输出当前页相册的照片分页栏 -->
				     	<div class="showPage">
				     		<?php 
				 		   		if($all_album_count > $page_size){
				   					$Page = new Page($all_album_count,$page_size,$page,$url,1);
									echo $Page->p_write();
				   				}
				   		 	?>
				     	</div>
	 		 		</div>
				</div>
			</div>
		</div>
		<!-- 底部 -->
		<?php
			include_once('common/view/foot.php');
		?>
	</body>
	<?php
		include_once('common/view/script.php');
	?>
	<script type="text/javascript">
		$(function(){
			//相册提示框
			$('.album').each(function(index){
				$(this).hover(function(){
					var tipContent = $(this).attr('data-album-intro');
					layer.tips('相册简介: '+tipContent,'#album_'+index);
					return false;
				});
			});
		})
	</script>
</html>
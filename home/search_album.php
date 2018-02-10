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
		$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'album_name';
		$search_val = isset($_GET['search_val'])?$_GET['search_val']:'';
	?>
</head>
	<body>
		<!-- 顶部 -->
		<?php
			include_once('common/view/top.php');
		?>
		<!-- 内容主体区域 -->
		<div class="layui-container" style="padding: 15px;min-height:700px;">
			<blockquote class='layui-elem-quote' style="background-color: #fff;">为您搜索到的结果</blockquote> 
			<?php 
				$tag_info = $_DB->query("SELECT * FROM album_tag WHERE d_time=0");
				$all_album_count = $_DB->rowCount("SELECT album.id AS album_id, album.user_id, album.album_name, album.album_intro, album.tag_set, album.album_type,  album.click_count, album.album_photo, album.status, album.d_time, album.create_time, user.nick_name, user.photo FROM album LEFT JOIN user ON album.user_id = user.id WHERE album.status=1 AND album.d_time=0 AND album.album_type=1 AND album.album_photo != '' AND album.{$search_type} LIKE '%{$search_val}%'");
				$page_size = 8;
				$start = $page_size*($page-1);
				$url = "/home/search_album.php?search_type={$search_type}&search_val={$search_val}&page={page}";
				$album_info = $_DB->query("SELECT album.id AS album_id, album.user_id, album.album_name, album.album_intro, album.tag_set, album.album_type, album.album_photo,  album.click_count, album.status, album.d_time, album.create_time, user.nick_name, user.photo FROM album LEFT JOIN user ON album.user_id = user.id WHERE album.status=1 AND album.d_time=0 AND album.album_type=1 AND album.album_photo != '' AND album.{$search_type} LIKE '%{$search_val}%'  ORDER BY album.create_time  DESC LIMIT {$start},{$page_size}");
			 ?>
			 <div class="layui-container" style="background-color: #fff;width: 100%; padding: 20px;">
			 	<div class="layui-row">
			 	<?php
    	 		if(!$album_info){
    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>真可惜没有搜索到您想要的相册</blockquote>";
    	 		}else{
    	 			foreach ($album_info as $key => $value) {
    	 			extract($value);
    	 			if(mb_strlen($nick_name)>10){$nick_name=mb_substr($nick_name, 1,10).'...';}
    	 			$create_time = date('Y-m-d H:i');
    	 			$cover_photo_id = explode(',',$album_photo)[0];
    	 			$cover = $_DB->query("SELECT id, path_name FROM photo WHERE id = {$cover_photo_id}")[0]['path_name'];
    	 			echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3 album-block-home'>
						      <a class='album' id='album_{$key}' data-album-type={$album_type} data-album-intro = '{$album_intro}' href='/home/album_detail.php?album_id={$album_id}'>
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

						echo      "</div>
									<div class='user-info-bar'>
									    <a href='/home/user_detail.php?user_id={$user_id}' class='head-img'><img src='{$photo}' ></a>
									    <a href='/home/user_detail.php?user_id={$user_id}' class='nick-name-bar'>{$nick_name}</a>
									</div>
									</div>";
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
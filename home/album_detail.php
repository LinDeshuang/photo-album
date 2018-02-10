<!DOCTYPE html>
<html>
<head>
	<title>电子相册管理系统</title>
	<?php
		include_once('common/view/head.php');
		require('../class/db.php');
		require('../class/function.php');
		if(!isset($_GET['album_id'])){
			header('Location:/index.php');
		}else{
			$album_id = $_GET['album_id'];
		}
		//点击量+1
		$is_click = 0;
		if(isset($_SESSION['click_count_log'])){
			$click_count = explode(',', $_SESSION['click_count_log']);

			foreach ($click_count as $key => $value) {
				if($value==$album_id){
					$is_click=1;
					break;
				}
			}
			if(!$is_click){
				$_SESSION['click_count_log'] = $_SESSION['click_count_log'].','.$album_id;
				$_DB->exec("UPDATE album SET click_count=click_count+1 WHERE id={$album_id}");
			}
		}else{
			$_SESSION['click_count_log']=$album_id;
			$_DB->exec("UPDATE album SET click_count=click_count+1 WHERE id={$album_id}");
		}

	?>
</head>
	<body>
		<!-- 顶部 -->
		<?php
			include_once('common/view/top.php');
		?>
		<!-- 内容主体区域 -->
		<div class="layui-container" style="padding: 15px;min-height:700px;">
			<blockquote class='layui-elem-quote' style="background-color: #fff;">相册详情</blockquote> 
			<div class="layui-container album-detail-container" style="background-color: #fff;width: 100%; padding: 20px;">
			<?php 
				$album_info = $_DB->query("SELECT album.id AS album_id, album.user_id, album.album_name, album.album_intro, album.tag_set, album.album_type, album.album_photo, album.status, album.d_time, album.create_time, user.nick_name, user.photo FROM album LEFT JOIN user ON album.user_id = user.id WHERE album.status='1' AND album.d_time=0 AND album.album_type='1' AND album.album_photo != '' AND album.id = {$album_id}");
				extract($album_info[0]);
				$photo_info = $_DB->query("SELECT * FROM photo WHERE id in($album_photo)");
				$tag_info = $_DB->query("SELECT * FROM album_tag WHERE d_time=0 AND $user_id = {$user_id}");
			 ?>
				 <div class='user-info-bar'>
		 		<?php 
		 			echo "<a href='/home/user_detail.php?user_id={$user_id}' class='head-img'><img src='{$photo}' ></a>
					    <a href='/home/user_detail.php?user_id={$user_id}' class='nick-name-bar'>{$nick_name}</a>";
								
		 		 ?>
	 		 	</div>
	 		 	<div class="detail-box">
	 		 		<p class='layui-elem-quote layui-quote-nm'>相册名：<?php echo $album_name; ?></p> 
	 		 		<p class='layui-elem-quote layui-quote-nm'>相册简介：<?php echo $album_intro; ?></p> 
	 		 		<p class='layui-elem-quote layui-quote-nm'>相册标签：
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
	 		 		</p> 
	 		 		<div class=" detail-all-photo" id="layer-photos-box">
	 		 			<div class="layui-row">
	 		 			<?php 
	 		 				foreach ($photo_info as $key => $value) {
	 		 					if($key != 0 && $key%4 == 0){
	 		 						echo "</div><div class='layui-row detail-all-photo'>";
	 		 					}
	 		 						echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3'>
	 		 								<img class=' layui-anim layui-anim-up photo' id='photo_{$key}'  src='{$value['path_name']}' data-note='{$value['note']}' title='{$value['photo_name']}' width='80%' height='80%'>
	 		 								</div>";
		 		 				}
		 		 			 ?>
		 		 		</div>
	 		 		</div>
	 		 	</div>
			</div>
			<div class="layui-container comment-container">
				<h3 class="layui-elem-quote">评论区</h3>
					<div class="layui-container" style="text-align: center;">
						<button class="layui-btn layui-btn-normal comment-btn" data-p-comment="0" data-album-id="<?php echo $album_id;?>"><i class="layui-icon">&#xe63a;</i>我要评论</button>

						<!--输出评论-->
						<?php 
							$comment_info = $_DB->query("SELECT comment.id, comment.pid,comment.user_id,comment.comment_content, comment.album_id, comment.create_time, comment.status,comment.d_time,user.nick_name FROM comment LEFT JOIN user ON comment.user_id=user.id WHERE album_id={$album_id} AND comment.status='1' AND comment.d_time=0 ORDER BY comment.create_time DESC");
							$comment_info = arrayToLevel($comment_info);
							foreach ($comment_info as $key => $value) {
				                if($value['pid']!=0){
				                    foreach ($comment_info as $k => $v) {
				                        if($v['id'] == $value['pid']){
				                            $origin_comment = $v['comment_content'];
				                            $origin_user = $v['nick_name'];
				                            $origin_user_id = $v['user_id'];
				                            $comment_info[$key]['origin_user']=$origin_user;
				                            $comment_info[$key]['origin_user_id']=$origin_user_id;
				                            break;
				                        }
				                    }
				                }
				            }

						 ?>
						 <div class="layui-container">
						 	<div class="layui-collapse" style="margin: 10px;margin-top: 20px;width: 90%;">
							  <div class="layui-colla-item">
							    <h2 class="layui-colla-title">所有评论</h2>
							    <div class="layui-colla-content">
							    	<?php 
							    		
							    		if(!$comment_info){
							    			echo "<p class='layui-elem-quote layui-quote-nm'>目前没有任何评论</p>";
							    		}else{
							    			echo "<ul class='comment-list'>";
							    			$echo='';	
							    			foreach ($comment_info as $key => $value) {
							    				extract($value);
							    				if($level == 1){
							    					$echo = $echo."</li><li class='first-comment'><p>
							    									<a href='/home/user_detail.php?user_id={$user_id}'>
							    									<i class='layui-icon'>&#xe612;</i>{$nick_name}</a>&nbsp;:&nbsp;{$comment_content}
							    									<button class='layui-btn layui-btn-xs layui-btn-warm comment-btn' data-p-comment='{$id}' data-user='{$nick_name}' data-album-id='{$album_id}'><i class=layui-icon>&#xe63a;</i>回复</button>
							    									</p>";

							    				}else if($level == 2){
							    					$echo = $echo."<ul class='child-comment-list'><li class='child-comment'>
							    									<p><a href='/home/user_detail.php?user_id={$user_id}'>
							    									<i class='layui-icon'>&#xe612;</i>{$nick_name}</a>&nbsp;回复&nbsp;
							    										<a href='/home/user_detail.php?user_id={$origin_user_id}'><i class='layui-icon'>&#xe612;</i>{$origin_user}</a>&nbsp;:&nbsp;
							    										{$comment_content}
							    										<button class='layui-btn layui-btn-xs layui-btn-warm comment-btn' data-user='{$nick_name}' data-p-comment='{$id}' data-album-id='{$album_id}'><i class=layui-icon>&#xe63a;</i>回复</button>
							    										</p></li>";
							    					if(isset($comment_info[$key+1]) && $comment_info[$key+1]['level'] == 1){
							    						$echo = $echo."</ul>";
							    					}
							    				}else{
							    					$echo = $echo."<li class='child-comment'><p><a href='/home/user_detail.php?user_id={$user_id}'><i class='layui-icon'>&#xe612;</i>{$nick_name}</a>&nbsp;回复&nbsp;
							    						<a href='/home/user_detail.php?user_id={$origin_user_id}'><i class='layui-icon'>&#xe612;</i>{$origin_user}</a>&nbsp;:&nbsp;
							    						{$comment_content}
							    						<button class='layui-btn layui-btn-xs layui-btn-warm comment-btn' data-p-comment='{$id}' data-user='{$nick_name}' data-album-id='{$album_id}'><i class=layui-icon>&#xe63a;</i>回复</button>
							    						</p></li>";
							    					if(isset($comment_info[$key+1]) && $comment_info[$key+1]['level'] == 1){
							    						$echo = $echo."</ul>";
							    					}
							    				}
							    			}
							    			$echo = substr($echo, 5);
							    			echo $echo;
							    			echo "</ul>";
							    		}
							    	 ?>
							    </div>
							  </div>
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
			$('.photo').each(function(index){
				$(this).hover(function(){
					var note = $(this).attr('data-note');
					var photo_name = $(this).attr('title');
					layer.tips(photo_name+'<br>备注: '+note,'#photo_'+index);
					return false;
				});
			});
			layer.photos({
					  photos: '#layer-photos-box'
					  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
					}); 
			//弹出评论框
			$('.comment-btn').each(function(Index){
				$(this).click(function(){
					var pid = $(this).attr('data-p-comment');
					var album_id = $(this).attr('data-album-id');
					if(pid==0){
						var title='发表评论';
					}else{
						var nick_name = $(this).attr('data-user');
						var title='回复'+nick_name;
					}
					layer.open({
						  title: title
						  ,content: ' <form class="layui-form" id="commentForm">\
									<div class="layui-form-item layui-form-text">\
									      <textarea name="comment_content" placeholder="请输入评论内容" class="layui-textarea"></textarea>\
									</div>\
									<input type="hidden" name="album_id" value="'+album_id+'">\
									<input type="hidden" name="pid" value="'+pid+'">\
								</form>'
						  ,btn: ['<i class="layui-icon">&#xe609;</i>', '关闭']
						  ,yes: function(index, layero){
						    //按钮【按钮一】的回调
						    var commentContent = $('#commentForm').find('textarea[name=comment_content]').val();
						    if(commentContent.length==0 || commentContent.length>200){
						    	layer.msg('评论内容不能为空，且长度不能超过200个字',{icon:5});
						    	return false;
						    }else{
						    	var data = $('#commentForm').serialize();
						    	$.ajax({
								  	url:'/home/comment_control.php',
								  	data:data,
								  	method:'post',
								  	dataType:'json',
								  	success:function(retData){
								  		if(retData.errcode == 0){
								  			layer.msg(retData.errmsg,{icon:1});
								  			setTimeout(function(){ window.location.reload(); } ,1500);
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
						    }
						    
						  }
						  ,btn2: function(index, layero){
						    //按钮【按钮二】的回调
						    layer.close(index);
						  }
						});
				});
			});
		})
	</script>
</html>
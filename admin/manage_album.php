<?php
	require('../class/page.php');
	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'album_name';
	$search_val = isset($_GET['search_val'])?$_GET['search_val']:'';
	$album_type = isset($_GET['album_type'])?$_GET['album_type']:2;
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
    	<blockquote class="layui-elem-quote"><h3>我的相册仓库</h3></blockquote>
	    <?php 
	    	$user_id = $_SESSION['user_id'];
	    	$if_search_album_type = ($album_type==2)?"":"AND album_type = {$album_type}";
	    	$count = $_DB->rowCount("SELECT * FROM album WHERE status = '1' AND user_id = {$user_id} AND d_time = 0 {$if_search_album_type} AND {$search_type} LIKE '%{$search_val}%' ");
	    	$page_size = 8;
	    	$url = "manage_album.php?nav=2-1&search_type={$search_type}&search_val={$search_val}&album_type={$album_type}&page={page}";
	    	$start = $page_size*($page-1);
	   		$album_info = $_DB->query("SELECT * FROM album WHERE status = '1' AND user_id = {$user_id} AND d_time = 0 {$if_search_album_type} AND  {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$start},{$page_size}  ");
	   		$tag_info = $_DB->query("SELECT * FROM album_tag WHERE user_id = {$user_id} and d_time = 0 ORDER BY create_time");
	     ?>
    	<form class="layui-form layui-form-pane">
		    <label class="layui-form-label">相册搜索</label>
		    <div class="layui-input-inline">
		      <select name="search_type">
				  <option value="album_name">相册名</option>
				  <option value="album_intro" <?php if($search_type == 'album_intro'){echo "selected" ;}?>>相册简介</option>
			  </select>     
		    </div>
		    <div class="layui-input-inline">
		    	<select name="album_type">
				  <option value="2" <?php if($album_type == 2){echo "selected" ;}?>>所有类型</option>
				  <option value="1" <?php if($album_type == 1){echo "selected" ;}?>>公开</option>
				  <option value="0" <?php if($album_type == 0){echo "selected" ;}?>>私有</option>
			  	</select> 
		    </div>
		    <div class="layui-input-inline">
		      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" class="layui-input">  
		      <input type="hidden" name="nav" value="2-4"> 
		    </div>
		    <div class="layui-input-inline">
		      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
		      	<i class="layui-icon">&#xe615;</i>
		      </button>  
		    </div>
     	</form>
     	<!--输出当前页相册 -->
    	<div class="layui-row" style="margin-top: 30px;min-width: 500px;">
    	 	<?php
    	 		if(!$album_info){
    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>一本相册都没有啊，快去创建吧&nbsp;&nbsp;<a class='layui-btn' href='/admin/create_album.php?nav=2-5'>现在去</a></blockquote>";
    	 		}else{
    	 			foreach ($album_info as $key => $value) {
    	 			extract($value);
    	 			$create_time = date('Y-m-d H:i');
    	 			$cover_photo_id = explode(',',$album_photo)[0];
    	 			$cover = $_DB->query("SELECT id, path_name FROM photo WHERE id = {$cover_photo_id}")[0]['path_name'];
    	 			$cover=(empty($cover)?'/public/static/images/album-default-cover.png':$cover);
    	 			echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3 album-block-admin'>
						      <a class='album' id='album_{$key}' data-album-type={$album_type} data-album-intro = '{$album_intro}' href='/admin/album_photo.php?id={$id}&nav=2-4'>
						      	<img class=' layui-anim layui-anim-up'  src='{$cover}' title='{$album_name}' >
						      </a>
						      <div style='margin: 5px;'>
						      <p class='layui-badge layui-bg-blue'>{$album_name}</p>
						      <p class='layui-badge layui-bg-gray'><i class='layui-icon'>&#xe60e;</i>{$create_time}</p>
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

					echo      "</div><div class='album-btn-bottom layui-bg-gray'>
						      	<a class='layui-btn layui-btn-sm layui-btn-normal' title='相册图片' href='/admin/album_photo.php?id={$id}&nav=2-4'><i class='layui-icon'>&#xe634;</i></a>
						       	<a href='/admin/update_album_info.php?nav=2-4&id={$id}' title='信息修改' class='layui-btn layui-btn-sm' data-id='{$id}'><i class='layui-icon'>&#xe642;</i></a>
						      	<button class='layui-btn layui-btn-sm layui-btn-danger delete-btn' title='删除相册' data-id='{$id}'><i class='layui-icon'>&#xe640;</i></button>
						      </div>
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
			//提示框
			$('.album').each(function(index){
				$(this).hover(function(){
					var tipContent = $(this).attr('data-album-intro');
					layer.tips('相册简介: '+tipContent,'#album_'+index);
				});
			});
			//删除相册
			$('.delete-btn').each(function(Index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					layer.confirm('确定删除？',function(index){
						$.ajax({
						  	url:'delete_album.php',
						  	data:{
						  		id: id
						  	},
						  	method:'post',
						  	dataType:'json',
						  	success:function(retData){
						  		if(retData.errcode == 0){
						  			layer.msg(retData.errmsg,{icon:1});
						  			$('.delete-btn').eq(Index).parent().parent().fadeOut();
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
		});
	</script>
</body>
</html>
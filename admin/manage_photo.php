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
    <!-- 内容主体区域 -->
    <div class="layui-container" style="padding: 15px;">
    	<blockquote class="layui-elem-quote"><h3>我的照片仓库</h3></blockquote>
    <?php 
    	$user_id = $_SESSION['user_id'];

    	$count = $_DB->rowCount("SELECT * FROM photo WHERE status = '1' and user_id = {$user_id} and d_time = 0 and {$search_type} LIKE '%{$search_val}%' ");
    	$page_size = 8;
    	$url = "manage_photo.php?nav=2-1&search_type={$search_type}&search_val={$search_val}&page={page}";
    	$start = $page_size*($page-1);
   		$photo_info = $_DB->query("SELECT * FROM photo WHERE status = '1' and user_id = {$user_id} and d_time = 0 and {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$start},{$page_size}  ");
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
		      <input type="hidden" name="nav" value="1-1"> 
		    </div>
		    <div class="layui-input-inline">
		      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
		      	<i class="layui-icon">&#xe615;</i>
		      </button>  
		    </div>
     	</form>
     	<!--输出当前页照片 -->
    	<div class="layui-row" id="layer-photos-box" style="margin-top: 30px;">
    	 	<?php
    	 		if(!$photo_info){
    	 			echo "<blockquote class='layui-elem-quote layui-quote-nm'>一张照片都没有啊，快去上传吧</blockquote>";
    	 		}else{
    	 			foreach ($photo_info as $key => $value) {
    	 			extract($value);
    	 			$create_time = date('Y-m-d H:i');
    	 			echo "<div class=' layui-col-xs3 layui-col-sm3 layui-col-md3 photo-block-admin'>
						      <img class='photo layui-anim layui-anim-up' id='photo_{$key}' src='{$path_name}' title='{$photo_name}' note-data = '{$note}' width='80%' height='70%'>
						      <div style='margin: 5px;'>
						      <p class='layui-badge layui-bg-blue'>{$photo_name}</p>
						      <p class='layui-badge layui-bg-gray'><i class='layui-icon'>&#xe60e;</i>{$create_time}</p>
						      </div>
						      <div class='photo-btn-bottom layui-bg-gray'>
						       	<button class='layui-btn layui-btn-sm update-btn' data-id='{$id}'><i class='layui-icon'>&#xe642;</i></button>
						      	<button class='layui-btn layui-btn-sm layui-btn-danger delete-btn' data-id='{$id}'><i class='layui-icon'>&#xe640;</i></button>
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
			$('.photo').each(function(index){
				$(this).hover(function(){
					var tipContent = $(this).attr('note-data');
					layer.tips('备注: '+tipContent,'#photo_'+index);
				});
				layer.photos({
					  photos: '#layer-photos-box'
					  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
					}); 
			});

			$('.update-btn').each(function(Index){
				$(this).click(function(){
					var data_id = $(this).attr('data-id');
					var photo_name = $(this).parent().parent().find('.photo').attr('title');
					var note = $(this).parent().parent().find('.photo').attr('note-data');
					layer.alert('<form class="layui-form" id="updateForm">\
								<div class="layui-form-item">\
								        <input type="text" name="photo_name" value="'+photo_name+'" placeholder="请输入新命名" autocomplete="off" class="layui-input">\
								</div>	\
								<input type="hidden" name="id" value="'+data_id+'">\
								<div class="layui-form-item layui-form-text">\
								      <textarea name="note"  placeholder="请输入新备注，可不填" class="layui-textarea">'+note+'</textarea>\
							  	</div>\
							</form>'
							,{title: '修改照片信息',area:['400px','400px']}
							,function(index){
								var photo_name = $('input[name=photo_name]').val();
								var note = $('textarea[name=note]').val();
								if(photo_name==''){
									layer.msg('命名不能为空',{icon:5});
								}else if(photo_name.length>20){
									layer.msg('命名长度不能超过20',{icon:5});
								}else if (note!='' && note.length>150){
									layer.msg('备注长度不能超过150',{icon:5});
								}else{
									var data = $('#updateForm').serialize();
									$.ajax({
									  	url:'update_photo_info.php',
									  	data:data,
									  	method:'post',
									  	dataType:'json',
									  	success:function(retData){
									  		if(retData.errcode == 0){
									  			layer.msg(retData.errmsg,{icon:1});
									  			$('.photo').eq(Index).attr('note-data',note).attr('title',photo_name);
									  			$('.photo').eq(Index).next().children().eq(0).html(photo_name);
									  		}else {
									  			layer.msg(retData.errmsg,{icon:5});
									  		}
											layer.close(index);
									  	},
									  	error:function(){
											layer.close(index);
									  	}
									  });
								}
							});
				});	
			});
			//删除图片
			$('.delete-btn').each(function(Index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					layer.confirm('确定删除？',function(index){
						$.ajax({
						  	url:'delete_photo.php',
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
</html>
<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	$tagId = '';
	$tagColor = '';
	session_start();
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($_SESSION['user'])){
			$errCode = 410;
			$errMsg  = '未登录或登录失效';
		}else{
			$user_id = $_SESSION['user_id'];
			if (empty($tag_name) || empty($tag_color) ){
				$errCode = 410;
				$errMsg  = '创建失败，参数缺失';
			}else if(mb_strlen($tag_name)>10){
				$errCode = 410;
				$errMsg  = '标签名长度不能超过10';
			}else if($_DB->rowCount("SELECT * FROM album_tag WHERE user_id={$user_id} AND tag_name='{$tag_name}' AND d_time = 0")){
				$errCode = 410;
				$errMsg  = '标签已存在';
			}else{
				$time = time();
				if($_DB->prepare("INSERT INTO album_tag(id,user_id,tag_name,tag_color,create_time) VALUES(null,?,?,?,?)",[$user_id,$tag_name,$tag_color,$time])){
					$tagId = $_DB->lastInsertId('id');
					$tagColor = $tag_color;
					$errCode = 0;
					$errMsg  = '创建成功';
				}else{
					$errCode = 420;
					$errMsg  = '创建失败，请稍后再试';
				}
			}
		}
		
	}else{
		$errCode = 400;
		$errMsg  = '方法错误，请用post方法';
	}

	exit(json_encode([
		'errcode'=>$errCode,
		'errmsg'=>$errMsg,
		'tag_id'=>$tagId,
		'tag_color'=>$tagColor
	],JSON_UNESCAPED_UNICODE));
 ?>
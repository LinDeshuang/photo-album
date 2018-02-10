<?php 
	require('../class/db.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($_SESSION['user'])){
			$errCode = 410;
			$errMsg  = '评论失败，未登录或登录失效';
		}else{
			$user_id = $_SESSION['user_id'];
			if(!isset($album_id) || empty($album_id)){
				$errCode = 410;
				$errMsg  = '参数缺失';
			}else if(!isset($pid) || $pid===null){
				$errCode = 410;
				$errMsg  = '参数缺失';
			}else if(!isset($comment_content) || empty($comment_content)){
				$errCode = 410;
				$errMsg  = '评论内容不能为空';
			}else if(mb_strlen($comment_content) > 200){
				$errCode = 410;
				$errMsg  = '评论内容不能超过200个字';
			}else{
				$time = time();
				if($_DB->prepare("INSERT INTO comment(id,pid,user_id,album_id,comment_content,create_time) VALUES(0,?,?,?,?,?)",[$pid,$user_id,$album_id,$comment_content,$time])){
					$errCode = 0;
					$errMsg  = '评论成功';
				}else{
					$errCode = 420;
					$errMsg  = '评论失败，请稍后再试';
				}
			}	
		}
	}else{
		$errCode = 400;
		$errMsg  = '方法错误，请用post方法';
	}

	exit(json_encode([
		'errcode'=>$errCode,
		'errmsg'=>$errMsg
	],JSON_UNESCAPED_UNICODE));
 ?>
<?php 
	require('../class/db.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($_SESSION['user'])){
			$errCode = 410;
			$errMsg  = '未登录或登录失效';
		}else{
			$user_id = $_SESSION['user_id'];
			if(!isset($photo_id) || empty($photo_id)){
				$errCode = 410;
				$errMsg  = '参数缺失';
			}else{
				$photo_info = $_DB->query("SELECT * FROM photo WHERE id = {$photo_id}");
				if($photo_info == false || empty($photo_info)){
					$errCode = 410;
					$errMsg  = '图片不存在';
				}else{
					$path_name = $photo_info[0]['path_name'];
					$_DB->exec("UPDATE photo SET is_head = 0 WHERE user_id={$user_id}");
					$_DB->exec("UPDATE photo SET is_head = 1 WHERE user_id={$user_id} AND id = {$photo_id}");
					if($_DB->exec("UPDATE user SET photo='$path_name' WHERE id={$user_id}")){
						$errCode = 0;
						$errMsg  = '设置成功';
					}else{
						$errCode = 420;
						$errMsg  = '设置失败，请稍后再试';
					}
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
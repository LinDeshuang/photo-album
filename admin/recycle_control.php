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
			if(!isset($action) || empty($action)){
				$errCode = 410;
				$errMsg  = '参数缺失';
			}else{
				switch ($action) {
					case 1:
						if(!isset($photo_id) || empty($photo_id)){
							$errCode = 410;
							$errMsg  = '参数缺失';
						}else if(!$_DB->rowCount("SELECT * FROM photo WHERE id={$photo_id} AND user_id={$user_id}")){
							$errCode = 410;
							$errMsg  = '图片不存在';
						}else{
							if($_DB->exec("UPDATE photo SET d_time=0 WHERE id={$photo_id} AND user_id={$user_id}")){
								$errCode = 0;
								$errMsg  = '操作成功';
							}else{
								$errCode = 420;
								$errMsg  = '操作失败';
							}
						}
						break;
					case 2:
						if(!isset($album_id) || empty($album_id)){
							$errCode = 410;
							$errMsg  = '参数缺失';
						}else if(!$_DB->rowCount("SELECT * FROM album WHERE id={$album_id} AND user_id={$user_id}")){
							$errCode = 410;
							$errMsg  = '图片不存在';
						}else{
							if($_DB->exec("UPDATE album SET d_time=0 WHERE id={$album_id} AND user_id={$user_id}")){
								$errCode = 0;
								$errMsg  = '操作成功';
							}else{
								$errCode = 420;
								$errMsg  = '操作失败';
							}
						}
						break;
					
					default:
						$errCode = 410;
						$errMsg  = '参数错误';
						break;
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
<?php 
	require ('../class/db.php');
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
			if (!isset($photo_id) || empty($photo_id) || !isset($album_id) || empty($album_id) ){
				$errCode = 410;
				$errMsg  = '创建失败，参数缺失';
			}else{
				$album_info = $_DB->query("SELECT * FROM album WHERE user_id={$user_id} AND id='{$album_id}' AND status = 1 AND d_time = 0");
				if($album_info == false || empty($album_info)){
					$errCode = 410;
					$errMsg  = '该相册不存在';
				}else{
					$time = time();
					$old_id_set = $album_info[0]['album_photo'];
					$old_id_set = explode(',' , $old_id_set );
					foreach ($old_id_set as $key => $value) {
						if($value == $photo_id){
							unset($old_id_set[$key]);
							break;
						}
					}
					if(empty($old_id_set)){
						$new_id_set = '';
					}else{
						$new_id_set = implode(',' , $old_id_set);
					}
					
					if($_DB->exec("UPDATE album SET album_photo='$new_id_set', update_time={$time} WHERE id={$album_id}")){
						$errCode = 0;
						$errMsg  = '移除成功';
					}else{
						$errCode = 420;
						$errMsg  = '移除失败，请稍后再试';
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
		'errmsg'=>$errMsg,
	],JSON_UNESCAPED_UNICODE));
 ?>
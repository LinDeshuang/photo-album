<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($id) && !isset($photo_name) && !isset($note)){
			$errCode = 410;
			$errMsg  = '参数错误';
		}else if (empty($photo_name)){
			$errCode = 410;
			$errMsg  = '照片命名不能为空';
		}else if (strlen($photo_name)>20){
			$errCode = 410;
			$errMsg  = '照片命名长度不能超过20';
		}else if (!empty($note) && strlen($note)>150){
			$errCode = 410;
			$errMsg  = '备注长度不能超过150';
		}else {
			$note = htmlspecialchars_decode($note);
			if($_DB->prepare("UPDATE photo SET photo_name = ?, note = ? WHERE id = {$id}",[$photo_name,$note])){
				$errCode = 0;
				$errMsg  = '修改成功';
			}else{
				$errCode = 420;
				$errMsg  = '修改失败，请稍后再试';
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
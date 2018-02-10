<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($id) || empty($id)){
			$errCode = 410;
			$errMsg  = '参数错误';
		}else if (!$_DB->rowCount("SELECT id FROM album_tag WHERE id={$id}")){
			$errCode = 410;
			$errMsg  = '该标签不存在！';
		}else{
			$time = time();
			if($_DB->exec("UPDATE album_tag SET d_time={$time} WHERE id={$id}")){
				$errCode = 0;
				$errMsg  = '删除成功！';
			}else{
				$errCode = 420;
				$errMsg  = '删除失败，请稍后再试';
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
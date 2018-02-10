<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	if(!empty($_POST)){
		extract($_POST);
		if(!isset($id) || empty($id)){
			$errCode = 410;
			$errMsg  = '参数错误';
		}else if (!$_DB->rowCount("SELECT id FROM photo WHERE id={$id}")){
			$errCode = 410;
			$errMsg  = '该图片不存在！';
		}else if (($_DB->query("SELECT is_head FROM photo WHERE id={$id}")[0]['is_head'] == '1')){
			$errCode = 410;
			$errMsg  = '该图片是头像，不能删！';
		}else{
			$time = time();
			if($_DB->exec("UPDATE photo SET d_time={$time} WHERE id={$id}")){
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
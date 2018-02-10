<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	$photoInfo = '';
	session_start();
	if(!empty($_GET)){
		extract($_GET);
		if(!isset($_SESSION['user'])){
			$errCode = 410;
			$errMsg  = '获取失败，未登录或登录失效';
		}else if(!isset($page) || empty($page)){
			$errCode = 410;
			$errMsg  = '参数错误';
		}else{
			$user_id = $_SESSION['user_id'];
			$count = $_DB->rowCount("SELECT * FROM photo WHERE status = 1 and user_id = {$user_id} and d_time = 0");
    		$page_size = 8;
    		$start = $page_size*($page-1);
    		$photo_info = $_DB->query("SELECT * FROM photo WHERE status = 1 and user_id = {$user_id} and d_time = 0 ORDER BY create_time DESC LIMIT {$start},{$page_size}");
    		if($photo_info!==false){
				$errCode = 0;
				$errMsg  = 'ok';
				$photoInfo = $photo_info;
    		}else{
				$errCode = 420;
				$errMsg  = '加载失败';
    		}
		}	
	}else{
		$errCode = 400;
		$errMsg  = '方法错误，请用get方法';
	}

	exit(json_encode([
		'errcode'=>$errCode,
		'errmsg'=>$errMsg,
		'photo_info'=>$photoInfo,
	],JSON_UNESCAPED_UNICODE));
 ?>	
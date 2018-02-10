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
			if (empty($album_name) || empty($album_intro) || $album_type===null || empty($tag_set) ){
				$errCode = 410;
				$errMsg  = '创建失败，参数缺失';
			}else if(mb_strlen($album_name)>20){
				$errCode = 410;
				$errMsg  = '相册名称名长度不能超过20';
			}else if(!isset($id) && $_DB->rowCount("SELECT * FROM album WHERE user_id={$user_id} AND album_name='{$album_name}' AND status = 1 AND d_time = 0")){
				$errCode = 410;
				$errMsg  = '相册名称已存在';
			}else if(mb_strlen($album_intro)>200){
				$errCode = 410;
				$errMsg  = '相册名简介长度不超过200';

			}else if(count($tag_set)>5) {
				$errCode = 410;
				$errMsg  = '不能添加超过5个标签';
			}else{
				$time = time();
				$tag_set = implode($tag_set, ',');
				$album_intro = htmlspecialchars_decode($album_intro);
				if(!isset($id)){
					//没传id，插入数据库
					if($_DB->prepare("INSERT INTO album(id,user_id,album_name,tag_set,album_intro,album_type,create_time) VALUES(0,?,?,?,?,?,?)",[$user_id,$album_name,$tag_set,$album_intro,$album_type,$time])){
							$errCode = 0;
							$errMsg  = '创建成功';
						}else{
							$errCode = 420;
							$errMsg  = '创建失败，请稍后再试';
						}
				}else{
					//传了id，更新数据
					if(!$_DB->rowCount("SELECT * FROM album WHERE user_id={$user_id} AND id='{$id}'")){
						$errCode = 410;
						$errMsg  = '相册不存在';
					}else {
						if($_DB->prepare("UPDATE album SET album_name = ?,tag_set = ?,album_intro = ?,album_type = ?,update_time = ? WHERE id = {$id} and user_id = {$user_id} ",[$album_name,$tag_set,$album_intro,$album_type,$time])){
							$errCode = 0;
							$errMsg  = '保存成功';
						}else{
							$errCode = 420;
							$errMsg  = '保存失败，请稍后再试';
						}
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
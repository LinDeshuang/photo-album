<?php 
	require ('../class/db.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])) {
			$errCode = 410;
			$errMsg  = '登录失效，修改失败';	
		}else {
			$type = isset($_POST['type'])?$_POST['type']:'';
			$user_id = $_SESSION['user_id'];
			if($type) {
				switch ($type) {
					case 1://修改昵称
						$nick_name = isset($_POST['nick_name'])?$_POST['nick_name']:'';
						if(!$nick_name){
							$errCode = 410;
							$errMsg  = '昵称不能为空';
						}else if(mb_strlen($nick_name)>20){
							$errCode = 410;
							$errMsg  = '昵称长度不能大于20';
						}else if($_DB->rowCount("SELECT * FROM user WHERE nick_name = '{$nick_name}'")){
							$errCode = 410;
							$errMsg  = '昵称已存在';
						}else {
							if($_DB->prepare("UPDATE user set nick_name = ? WHERE id = {$user_id}",[$nick_name])) {
								$errCode = 0;
								$errMsg  = '修改成功';
							}else {
								$errCode = 410;
								$errMsg  = '修改失败，请稍候再试';
							}
						}
						break;
					case 2://修改简介
						$introduction = isset($_POST['introduction'])?htmlspecialchars_decode($_POST['introduction']):'';
						if(!$introduction){
							$errCode = 410;
							$errMsg  = '自我介绍不能为空';
						}else if(mb_strlen($introduction)>200){
							$errCode = 410;
							$errMsg  = '自我介绍长度不能大于200';
						}else if($_DB->rowCount("SELECT * FROM user WHERE introduction = '{$introduction}'")){
							$errCode = 410;
							$errMsg  = '自我介绍已存在';
						}else {
							if($_DB->prepare("UPDATE user set introduction = ? WHERE id = {$user_id}",[$introduction])) {
								$errCode = 0;
								$errMsg  = '修改成功';
							}else {
								$errCode = 410;
								$errMsg  = '修改失败，请稍候再试';
							}
						}
						break;
					case 3://修改密码
						$old_password = isset($_POST['data']['old_password'])?md5(md5($_POST['data']['old_password']).SALT):'';
						$password = isset($_POST['data']['password'])?$_POST['data']['password']:'';
						$confirm_password = isset($_POST['data']['confirm_password'])?$_POST['data']['confirm_password']:'';
						if(empty($old_password) || empty($password) || empty($confirm_password)) {
							$errCode = 410;
							$errMsg  = '参数错误';
						}else if(!preg_match("/^[^\'\"]{6,20}$/", $password)){
							$errCode = 410;
							$errMsg = '密码的长度必须在6-20之间,且不能包含引号';
						}else if($password!=$confirm_password) {
							$errCode = 410;
							$errMsg  = '两次输入的密码不一样';
						}else if($_DB->query("SELECT password FROM user WHERE id = {$user_id}")[0]['password'] != $old_password ) {
							$errCode = 410;
							$errMsg  = '原密码错误，请重新输入';
						}else {
							$password = md5(md5($password).SALT);
							if($_DB->prepare("UPDATE user set password = ? WHERE id = {$user_id}",[$password])) {
								$errCode = 0;
								$errMsg  = '修改成功';
							}else {
								$errCode = 410;
								$errMsg  = '修改失败，请稍候再试';
							}
						}
					
				}
			}else {
				$errCode = 410;
				$errMsg  = '参数错误';
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
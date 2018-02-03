<?php 
	require('../class/DB.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	$captcha = strtolower($_SESSION['captcha']);
	if(!empty($_POST)){
		$data = extract($_POST);
		//密码加盐加密
		$password = $password = md5(md5($password).SALT);
		if ($captcha != strtolower($verify_code)) {
			$errCode = 410;
			$errMsg = '验证码错误';
		}else if (!($user_info = $_DB->query("SELECT * FROM user WHERE account = '{$account}' AND password = '{$password}'"))) {
			$errCode = 410;
			$errMsg = '账号或密码错误，请重新输入';
		}else{
			if(isset($auto_login)){
				$lifeTime = 3600*24*7;//7天自动登录
			}else{
				$lifeTime = 3600*4;//4小时有效
			}
			$_SESSION['user'] = true;
			$_SESSION["user_account"] = $user_info[0]['account'];
			$_SESSION["user_nick_name"] = $user_info[0]['nick_name'];
			setcookie(session_name(), session_id(), time() + $lifeTime, "/"); 
			$errCode = 0;
			$errMsg  = '登录成功';
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
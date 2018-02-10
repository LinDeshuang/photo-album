<?php 
	require('../class/db.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	$captcha = strtolower($_SESSION['captcha']);
	if(!empty($_POST)){
		$data = extract($_POST);
		if($captcha != strtolower($verify_code)){
			$errCode = 410;
			$errMsg = '验证码错误';
		}else if(!preg_match("/^\w{8,20}$/", $account)){
			$errCode = 410;
			$errMsg = '账号必须是长度8-20之间的数字和字母';
		}else if($_DB->rowCount("SELECT * FROM user WHERE account = '{$account}'")){
			$errCode = 410;
			$errMsg = '账号已存在';
		}else if(!preg_match("/^[^\'\"]{6,20}$/", $password)){
			$errCode = 410;
			$errMsg = '密码的长度必须在6-20之间,且不能包含引号';
		}else if($password!=$confirm_password){
			$errCode = 410;
			$errMsg = '两次输入的密码不一致';
		}else if(mb_strlen($nick_name)>20){
			$errCode = 410;
			$errMsg = '昵称长度不能大于20';
		}else if($_DB->rowCount("SELECT * FROM user WHERE nick_name = '{$nick_name}'")){
			$errCode = 410;
			$errMsg = '昵称已存在';
		}else if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email)){
			$errCode = 410;
			$errMsg = '邮箱格式错误';
		}else if($_DB->rowCount("SELECT * FROM user WHERE email = '{$email}'")){
			$errCode = 410;
			$errMsg = '邮箱已存在';
		}else {
			$time = time();//注册时间
			$password = md5(md5($password).SALT);//密码加盐加密
			$photo = '/public/static/images/minion.jpg';//默认头像
			$insertData = [$account,$password,$nick_name,$gender,$email,$time,$photo,1,0];
			$res = $_DB->prepare("insert into user(id,account,password,nick_name,gender,email,create_time,photo,status,points) values(null,?,?,?,?,?,?,?,?,?)",$insertData);
			if($res){
				$errCode = 0;
				$errMsg = '注册成功';
			}else{
				$errCode = 410;
				$errMsg = '注册失败，稍后再试';
				// $errMsg = $_DB->errorInfo();

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
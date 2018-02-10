<?php
	require('../class/db.php');
	session_start();
	date_default_timezone_set('PRC');
	//登录状态监测
	if(!isset($_SESSION['user'])){
		header('Location:/index.php');
	}
?>
	<meta charset="utf-8">
	<link type="favicon" rel="shortcut icon" href="/public/static/images/favicon.png" />
	<link rel="stylesheet" type="text/css" href="/public/static/layui/css/layui.css">
	<link rel="stylesheet" type="text/css" href="/public/static/css/global.css">

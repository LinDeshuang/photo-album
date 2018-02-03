<?php 
	require('../class/captcha.php');
	header('content-type:image/png'); 
	session_start();
	$captcha = createCaptcha(4);
	$_SESSION['captcha']=$captcha;
 ?>
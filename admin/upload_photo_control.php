<?php 
	require('../class/db.php');
	$errCode = '';
	$errMsg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])){
			$errCode = 410;
			$errMsg  = '未登录或登录失效';
		}else{
			$user_id = $_SESSION['user_id'];
			$user_account = $_SESSION['user_account'];
			$type = isset($_POST['type'])?$_POST['type']:'';
			if(empty($type)){
				$errCode = 410;
				$errMsg  = '出错了，参数缺失，上传类型缺失';
			}else {
				switch ($type) {
					case 'image':
						if(empty($_FILES['image'])){
							$errCode = 410;
							$errMsg  = '出错了，参数缺失，文件缺失';
						}else {
							extract($_FILES['image']);
							$file_ext = substr($name, strpos($name, '.'));
							//验证图片类型
							if($file_ext != '.jpg' && $file_ext != '.png' && $file_ext != '.gif' && $file_ext != '.bmp' && $file_ext != '.jpeg' ){
								$errCode = 410;
								$errMsg  = '上传失败，图片类型错误'.$file_ext;
							}else if($size >= 5*1024*1024){
							//验证图片大小
								$errCode = 410;
								$errMsg  = '上传失败，图片不能大于5M';
							}else {
							//保存图片到服务器
								$rand1=rand(0,9);
								$rand2=rand(0,9);
								$rand3=rand(0,9);
								$rand4=rand(0,9);
								date_default_timezone_set('PRC');
								$photo_name=date("Ymdhm").$rand1.$rand2.$rand3.$rand4;
								$save_dir = '../public/upload/'.$user_account.'/';
								//创建用户照片目录
								if(!is_dir($save_dir)){
									mkdir($save_dir);
								}
								$save_path = $save_dir.$photo_name.$file_ext;
								if(move_uploaded_file($tmp_name, $save_path)){
									$time = time();
									$sql_path = '/public/upload/'.$user_account.'/'.$photo_name.$file_ext;
									//数据入库
									if($_DB->prepare("INSERT INTO photo(id,user_id,path_name,create_time,photo_size,status) VALUES(null,?,?,?,?,1)",[$user_id,$sql_path,$time,$size])){
									    $insert_id = $_DB->lastInsertId('id');
									    $errCode = 0;
									    $errMsg  = ['msg'=>'上传成功','id'=>$insert_id,'path'=>$sql_path];
									}else{
										$errCode = 420;
										$errMsg  = '上传失败，数据录入出错';
									}
								}else{
									$errCode = 420;
									$errMsg  = '上传失败，请稍后重试';
								}
							}
						}
						break;
					
					default:
						extract($_POST);
						if(!isset($photo_name) || !isset($photo_id) || !isset($note) ){
							$errCode = 410;
							$errMsg  = '参数缺失，保存失败';
						}else if(mb_strlen($photo_name)>20){
							$errCode = 410;
							$errMsg  = '照片名字不能超过20字';
						}else if(!empty($note) && mb_strlen($note)>150){
							$errCode = 410;
							$errMsg  = '照片介绍不能超过150字';
						}else {
							if($_DB->prepare("UPDATE photo SET photo_name = ? , note = ? WHERE id = {$photo_id}",[$photo_name, htmlspecialchars_decode($note)])){
								$errCode = 0;
								$errMsg  = '保存成功';
							}else{
							$errCode = 420;
							$errMsg  = '保存失败，请稍后重试';
							}
						}
						
						break;
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
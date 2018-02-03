<?php 
/**
* 生成验证码图片
* length 验证码长度
* return 验证码
*/
function createCaptcha($length = 4){

	$code = '12345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXYZ';

	$width = $length * 50;    //图片宽度

	$height = 60;		//图片高度

	$fontSize = 30;		//字体大小

	$im = @imagecreatetruecolor($width , $height);

	$background = imagecolorallocate($im, 250, 250, 250);

	imagefill($im,0,0,$background);

	$captcha = '';

	//随机生成验证码
	for($i = 0; $i < $length ; $i++ ){
		$char = $code[rand(0,strlen($code)-1)];

		$captcha.=$char;

		$text_color = imagecolorallocate($im, rand(0,120),rand(0,120),rand(0,120));

		$x = ($i*50) + rand(5, 10);  

		imagettftext($im, $fontSize, mt_rand(-40, 40), $x,  $fontSize*1.4, $text_color, '../class/ttfs/'.rand(1,6).'.ttf', $char);
	}

	//画干扰点
	for($i = 0; $i < 10; $i++ ){
        //杂点颜色
        $noiseColor = imagecolorallocate($im, mt_rand(150, 225), mt_rand(150, 225), mt_rand(150, 225));
        for ($j = 0; $j < 5; $j++) {
            // 绘杂点
            imagestring($im, 3, mt_rand(-10, $width), mt_rand(-10, $height), '.', $noiseColor);
        }
	}

	//画干扰线
	for($i=0;$i<10;$i++) {  
    $linecolor = imagecolorallocate($im, rand(80,220), rand(80,220), rand(80, 220));  
    imageline($im, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $linecolor);  
	} 
	imagepng($im);

	imagedestroy($im);

	return $captcha;
}
 ?>
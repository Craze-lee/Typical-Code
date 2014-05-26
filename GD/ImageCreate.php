<?php

//创建画布
$image = ImageCreate(200,50);
//第一次调用imagecolorallocate()函数是设置背景色，另外的则是绘制的内容
$background_color = imagecolorallocate($image,255,255,255);

$gray = imagecolorallocate($image,204,204,204);
//在画布上绘制一个矩形盒子
imagefilledrectangle($image,20,10,150,40,$gray);

//header('Content-type:image/png');

//ImagePNG(图像，保存路径) 第二个参数可选
ImagePNG($image,'./image.png');

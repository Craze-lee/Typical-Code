<?php

$image = imagecreate(500,500);
$background_color = imagecolorallocate($image,255,255,255);
$line_color = imagecolorallocate($image,0,0,0);

imageline($image, 0,0,100,100,$line_color);   //直线

imagerectangle($image,100,0,200,100,$line_color);  //空心矩形

imagefilledrectangle($image,200,0,300,100,$line_color); //实心矩形

//多边形(x1,y1,x2,y2,x3,y3)
$points = array(300,0,450,50,500,100);
imagepolygon($image,$points,count($points)/2,$line_color);  //参数：画布，多边形点的数组，点的个数，画笔颜色

//输出
header('Content-type:image/png');
imagepng($image);

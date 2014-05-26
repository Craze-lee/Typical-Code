<?php
$sourceImage = 'images/01.png';
$thumbWidth = 200;
$thumbHeight = 200;

$original = imagecreatefrompng($sourceImage);
$dims = getimagesize($sourceImage);  //获取图片属性

//这里应创建真彩（24位），而不是imagecreate（8位）
$thumb = imagecreatetruecolor($thumbWidth,$thumbHeight);

//目的图像，源图像，需要复制的图像坐标，目的图像宽高，源图像宽高
imagecopyresampled($thumb,$original,0,0,0,0,$thumbWidth,$thumbHeight,$dims[0],$dims[1]);

header('Content-type:image/png');
imagepng($thumb);

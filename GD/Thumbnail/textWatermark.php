<?php

$image = imagecreatefromjpeg('images/we.jpg');
$color = imagecolorallocate($image,68,68,68);
//文字水印
imagestring($image,5,100,100,"Craze-Lee & Mingchi",$color);

header('Content-type:image/jpg');
imagejpeg($image);

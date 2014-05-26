<?php

$image = imagecreatefromjpeg("images/we.jpg");
$iWidth = imagesx($image);

$watermark = imagecreatefrompng("images/06.png");
$wmWidth = imagesx($watermark);
$wmHeight = imagesy($watermark);

$xPos = $iWidth - $wmWidth;
imagecopymerge($image,$watermark,$xPos,0,0,0,$wmWidth,$wmHeight,100);

header('Content-type:image/jpg');
imagejpeg($image);

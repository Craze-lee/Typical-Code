<?php
require_once('Thumbnail.class.php');
$tn  = new Thumbnail(100,100);
$image = 'images/02.png';
$tn->loadFile($image);
$tn->buildThumb('images/new_02.png');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div>
    <h1>Before ...</h1>
    <p><img src='images/02.png' alt = "original Image" /></p>
</div>
<div>
    <h1>After ...</h1>
    <p><img src='images/new_02.png' width="<?=$tn->getThumbWidth();?>" height="<?=$tn->getThumbHeight();?>" alt="resize Image" /></p>
</div>
</body>
</html>

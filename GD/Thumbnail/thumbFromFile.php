<?php

require_once('Thumbnail.class.php');
$tn = new Thumbnail(200,200);
$tn->loadFile('images/01.png');
header('Content-type: '.$tn->getMime());
$tn->buildThumb();

?>

<?php

require_once('Thumbnail.class.php');
$image_html = '';

$dir = dir('images');
while($image = $dir->read()){
    $ext = explode('.',$image);
    $size = count($ext);
    if(($ext[$size-1]=='png') && !preg_match('/^thumb_/',$image) && $image != '.' && $image != '..')
    {
        if(!file_exists('images/thumb_'.$image)){
            $tn = new Thumbnail(200,200,true,false);
            $tn->loadFile('images/'.$image);
            $tn->buildThumb('images/thumb_'.$image);
        }
        $image_html .= '<div class="image">' . '<a href="images/'.$image.'">' .'<img src="images/thumb_'.$image.'">' .'</a></div>';
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h1>Gallery</h1>
    <?php echo ($image_html); ?>
</body>
</html>

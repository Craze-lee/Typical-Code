<?php

//获得相片的全部EXIF信息，相机，图像编辑工具，照片日期，相机型号等
$exif_data = exif_read_data('images/we.jpg');
echo '<pre>';
print_r($exif_data);
echo '</pre>';

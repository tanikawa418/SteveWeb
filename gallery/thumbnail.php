<?php
    ini_set("gd.jpeg_ignore_warning", 1);

    $width = 1000; // 画像横幅を指定
    $url = "images/2019-08-25 17.18.27_preview.jpeg"; // 画像URLを指定

    list($image_w, $image_h) = getimagesize($url);
    $proportion = $image_w / $image_h;
    $height = $width / $proportion;
    if($proportion < 1){
        $height = $width;
        $width = $width * $proportion;
    }

    if(strpos($url, '.png') !== false) {
        $image = imagecreatefrompng($url);
        header('Content-type: image/png');
    }
    else {
        $image = imagecreatefromjpeg($url);
        header('Content-type: image/jpeg');
    }

    $canvas = imagecreatetruecolor($width, $height);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $width, $height, $image_w, $image_h);
    imagejpeg($canvas, NULL, 100);
    imagedestroy($canvas);

?>
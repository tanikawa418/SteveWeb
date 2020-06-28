<?php

function create_thumbnail($thumb_w,$thumb_h,$path,$base_filename,$rate){
    list($w,$h) = getimagesize($path . $base_filename);
    
    
    if($w > $h){
        $diff  = ($w - $h) * 0.5; 
        $diffW = $h;
        $diffH = $h;
        $diffY = 0;
        $diffX = $diff;
    }elseif($w < $h){
        $diff  = ($h - $w) * 0.5; 
        $diffW = $w;
        $diffH = $w;
        $diffY = $diff;
        $diffX = 0;
    }elseif($w === $h){
        $diffW = $w;
        $diffH = $h;
        $diffY = 0;
        $diffX = 0;
    }
    
    $thumbpic = imagecreatetruecolor($thumb_w,$thumb_h);
    
    $base_image = imagecreatefromjpeg($path . $base_filename);
    
    imagecopyresampled($thumbpic,$base_image,0,0, $diffX, $diffY, $thumb_w, $thumb_h, $diffW, $diffH);
    
    imagejpeg($thumbpic,$path . '/thumb/' . $base_filename,$rate);
}


?>
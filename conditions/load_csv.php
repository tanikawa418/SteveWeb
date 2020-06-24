<?php

require('../common/php/dbconnect.php');


setlocale(LC_ALL, 'ja_JP.UTF-8');
$dir = 'C:/Users/itani/Dropbox/Private/STEVE/CageCondition/';

$files = glob($dir . '*.csv');

$success = 0;
$failed = 0;
foreach($files as $file){
    $data = file_get_contents($file);
    
    //InkBirdの出力データはUTF16なのでUTF8に変換
    $data = mb_convert_encoding($data, 'UTF-8', 'UTF-16LE');
    $temp = tmpfile();
    $csv  = array();
     
    fwrite($temp, $data);
    rewind($temp);
     
    while (($data = fgetcsv($temp, 0, "\t")) !== FALSE) {
        $csv[] = $data;
    }
    fclose($temp);
    
    for ($i=1; $i < count($csv); $i++){
        $sql = 'INSERT INTO `cage_conditions`(`date`, `device_name`, `temperature`, `humidity`,`modified`) VALUES ("' . $csv[$i][0] . '","Steve01","' . $csv[$i][1] . '","' . $csv[$i][2] . '",now());';
        $stmt = $db->prepare($sql);
    
        $check = $stmt->execute();
        if($check){
            $success += 1;
        }else{
            $failed += 1;
        }
    }
}


if(count($files)>0){
    if($success + $failed > 0){
        if($success == 0){
            $res_msg = 'No updates.';
        }else{
            $res_msg = count($files) . ' file(s) done, ' . $success . ' new records successfully added.'; 
        }
    }else{
        // $error = 'Failed.';
    }
}else{
    $res_msg = 'No files.'; //処理すべきファイルがなかった場合
}

    header('Content-Type: application/x-www-form-urlencoded;charset=UTF-8');
    echo json_encode(compact('res_msg','success','failed'));

?>
<?php
require('../common/php/dbconnect.php');

//DB上のファイルリスト取得
$sql = 'SELECT pic_filename FROM gallery';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_filelist = $response->fetchAll(PDO::FETCH_ASSOC);

// foreach($arr_filelist as $db_file){
//     echo $db_file['pic_filename'] . "<br>";
// }
// var_dump($arr_filelist);

//ディレクトリの画像ファイル検索
chdir('images/');
$globfiles = glob('*.jpg');

foreach($globfiles as $file){    
    // echo $file . 'aaa';
    $exist_check = 0;
    foreach($arr_filelist as $db_file){
        if($file == $db_file['pic_filename']){
            // echo $file . 'はDBに存在します' . '<br>';
            $exist_check = 1;
        }
    }

    if($exist_check == 0){
        $exifdata = exif_read_data($file,null,true);
        $original_date_str = isset($exifdata["EXIF"]['DateTimeOriginal']) ? $exifdata["EXIF"]['DateTimeOriginal'] : "aa";
        $original_date_str = str_replace([' ',':'],'',$original_date_str);
        echo $file . ' : ' .$original_date_str;

        $sql = 'INSERT INTO `gallery`(`pic_filename`, `original_date`, `entry_date`) VALUES ("' . $file . '", CAST(' . $original_date_str . ' AS DATETIME),now());';
        echo $sql . '<br>';
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
}

//データ取得処理
$sql = 'SELECT * FROM vw_gallery gl ORDER BY gl.original_date DESC';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_gallery = $response->fetchAll(PDO::FETCH_ASSOC);

$jsondata = json_encode($arr_gallery);

?>
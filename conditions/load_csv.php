<?php

require('../common/php/dbconnect.php');

setlocale(LC_ALL, 'ja_JP.UTF-8');
 
$file = 'C:/MAMP/htdocs/SteveWeb/conditions/csv/steve.csv';
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



$success = 0;
$failed = 0;
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

echo '<h2>Succeed : ' .$success . '</h2>';
echo '<h2>Failed : ' .$failed . '</h2>';



?>
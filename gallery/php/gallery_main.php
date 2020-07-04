<?php
//データ取得処理
$sql = 'SELECT * FROM vw_gallery gl ORDER BY gl.original_date DESC';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_gallery = $response->fetchAll(PDO::FETCH_ASSOC);

$jsondata = json_encode($arr_gallery);

?>
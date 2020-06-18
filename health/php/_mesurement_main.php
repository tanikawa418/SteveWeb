<?php

//mesurement.php　からrequireされる

//削除ボタン押下時処理
if(!empty($_POST) && $_POST['mode']='delete'){
    
    //pic_filenameの取得
    $sql = 'SELECT * FROM mesurement WHERE mesurement_id=?';
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_POST['mesurement_id']));
    $response = $stmt->fetch();
    $delete_filename = $response['pic_filename'];
    if($delete_filename){
        $is_attached = true;
    }else{
        $is_attached = false;
    }
    
    // DB Delete
    $sql = 'DELETE FROM mesurement WHERE mesurement_id=?';
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_POST['mesurement_id']));
    $result_db_delete = $stmt->rowCount();
    
    //File Delete
    if($is_attached){
        if(unlink('images/mesurement_pics/' . $delete_filename)){
            //元画像があり、正常に削除された場合
            $result_file_delete = 1;
        }else{
            //元画像があり、削除されなかった場合
            $result_file_delete = 0;
        }
    }else{
        $result_file_delete = -1;
    }
    
    //トーストメッセージの作成
    if(isset($result_db_delete)){
        if($result_db_delete==1){
            $toast_message_db = 'データを削除しました';
            $toast_type_db = 'success';
        }else{
            $toast_message_db = 'データ削除に失敗しました';
            $toast_type_db = 'error';
        }
    }

    if($result_file_delete==1){
        $toast_message_file = '画像を削除しました';
        $toast_type_file = 'success';
    }elseif($result_file_delete==0){
        $toast_message_file = '画像削除に失敗しました';
        $toast_type_file = 'error';
    }else{
        $toast_message_file = '画像データがなかったので削除処理をスキップしました';
        $toast_type_file = 'info';
    }
    
}

//データ取得処理
$sql = 'SELECT * FROM mesurement ms INNER JOIN pets pt ON pt.pet_id = ms.pet_id ORDER BY ms.date DESC';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_health = $response->fetchAll(PDO::FETCH_ASSOC);
// JSに配列渡し
$jsonData = json_encode($arr_health);


?>
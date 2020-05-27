<?php
    require('../common/php/dbconnect.php');

    if(!empty($_POST)){
        //pic_filenameの取得
        $sql = 'SELECT * FROM mesurement WHERE mesurement_id=?';
        $stmt=$db->prepare($sql);
        $stmt->execute(array($_POST['mesurement_id']));
        $response = $stmt->fetch();
        $delete_filename = $response['pic_filename'];

        // DB Delete
        $sql = 'DELETE FROM mesurement WHERE mesurement_id=?';
        $stmt=$db->prepare($sql);
        $stmt->execute(array($_POST['mesurement_id']));
        $result_db_delete = $stmt->rowCount();
        
        //File Delete
        if(unlink('images/mesurement_pics/' . $delete_filename)){
            $result_file_delete = 1;
        }else{
            $result_file_delete = 0;
        }
        echo $result_db_delete;
        echo $result_file_delete;
        
        header('Location: mesurement.php?result='.$result_db_delete*$result_file_delete);
        exit();
    }



?>

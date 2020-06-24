<?php
    require('../common/php/dbconnect.php');

    if(!empty($_POST)){
        //pic_filenameの取得
        $sql = 'SELECT * FROM measurement WHERE measurement_id=?';
        $stmt=$db->prepare($sql);
        $stmt->execute(array($_POST['measurement_id']));
        $response = $stmt->fetch();
        $delete_filename = $response['pic_filename'];

        // DB Delete
        $sql = 'DELETE FROM measurement WHERE measurement_id=?';
        $stmt=$db->prepare($sql);
        $stmt->execute(array($_POST['measurement_id']));
        $result_db_delete = $stmt->rowCount();
        
        //File Delete
        unlink('images/measurement_pics/thumb/' . $delete_filename);
        if(unlink('images/measurement_pics/' . $delete_filename)){
            $result_file_delete = 1;
            echo 'images/measurement_pics/thumb/' . $delete_filename;
        }else{
            $result_file_delete = 0;
        }
        echo $result_db_delete;
        echo $result_file_delete;
        
        // header('Location: measurement.php?result='.$result_db_delete*$result_file_delete);
        // exit();
    }



?>

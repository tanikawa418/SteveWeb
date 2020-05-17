<?php
    try{
        $db = new PDO('mysql:dbname=steve;host=127.0.0.1;charset=utf8','root','root');
    }catch(PDOException $e){
        print('<p class="msgError">DB connect error!! : ' . $e->getMessage() . '</p>');
    }

?>
<?php
session_start();
//セッションタイムアウト設定（秒）
$timeout = 3600;

if(isset($_SESSION['user_id']) && $_SESSION['time'] + $timeout > time()){
    $_SESSION['time'] = time();
}else{
    header('Location:http://localhost/Steveweb/login/login.php');
    exit();
}


?>
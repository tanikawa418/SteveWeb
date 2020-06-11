<?php
session_start();
require('../common/php/dbconnect.php');
$salt = 'IamTheWalrusByTheBeatles';

if($_COOKIE['user_id']!==''){
    $user_id = $_COOKIE['user_id'];
}

if(!empty($_POST)){
    if($_POST['submit'] != ""){
        echo md5(md5($salt) . $_POST['password']);
        echo '<br>';
        $user_id = $_POST['user_id'];
        //エラーチェック
        if(!$_POST['user_id']){
            $error['user_id'] = 'blank';
        }
        if(!$_POST['password']){
            $error['password'] = 'blank';
        }

        if(empty($error)){
            $sql = 'SELECT password FROM USERS WHERE user_id=? AND password=?';
            $login = $db->prepare($sql);
            $login->execute(array($_POST['user_id'],md5(md5($salt) . $_POST['password'])));
            $userpw = $login->fetch();

            if($userpw){
                $_SESSION['user_id'] = $_POST['user_id'];
                $_SESSION['time'] = time();
                if($_POST['remember_me']==='on'){
                    setcookie('user_id',$_POST['user_id'],time()+60*60*24*7);
                }
                header('Location:../home/index.php');
                exit();
            }else{
                $error['login'] = 'unmatched';
            }
        }else{
            // echo 'error occured';
        }

    }

    if($_POST['cancel'] != ""){
        header('Location: ../opening/opening.html');
    }

}

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="../common/css/reset.css" media="screen and (min-width: 1025px)">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <title>Crawl in</title>
</head>
<body>
    <div class="mycontainer">
        <div class="mywrapper">
            <div class="mycard">
                <div class="mycardheader">
                    <p><i class="fas fa-sign-in-alt"></i> Crawl In</p>
                </div>
                <form action="" method="post" class="form-group">
                    <p class="field_label">ID<span class="required">　(必須)</span></p>
                    <input type="text" name="user_id" class="form-control input_sm <?php if($error['user_id']!=''){echo 'field_error';} ?>" placeholder=""
                    value="<?php echo htmlspecialchars($user_id,ENT_QUOTES); ?>">
                    <?php if($error['user_id']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
    
                    <p class="field_label">Password<span class="required">　(必須)</span></p>
                    <input type="password" name="password" class="form-control input_sm <?php if($error['password']!=''){echo 'field_error';} ?>" value="<?php echo $_POST['password'];?>">
                    <?php if($error['password']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <input class="field_label" type="checkbox" name="remember_me" value="on"> Remember me
                    <?php if($error['login']=='unmatched'){
                       echo '<p class="error">IDまたはパスワードが誤っています</p>';
                    } ?>
                    <br><hr>
                    <button id="btn_submit" class="btn btn-secondary" type="submit" name="submit" value="submit">Crawl in</button>
                    <button id="btn_cancel" class="btn btn-light" type="cancel" name="cancel" value="cancel">Cancel</button>
                </form>
            </div>      
        </div>
    </div> <!--container-->
    <script>
    </script>
</body>
</html>
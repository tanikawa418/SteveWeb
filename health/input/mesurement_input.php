<?php
    require('../../common/php/dbconnect.php');
    session_start();


    if(!empty($_POST)){
        var_dump($_POST);
        //エラーチェック
        if($_POST['date'] === ''){
            $error['date'] = 'blank';
        }
        if($_POST['pet'] === ''){
            $error['pet'] = 'blank';
        }
        if($_POST['weight'] === ''){
            $error['weight'] = 'blank';
        }
        if($_POST['vertical'] === ''){
            $error['vertical'] = 'blank';
        }
        if($_POST['horizontal'] === ''){
            $error['horizontal'] = 'blank';
        }
        // if($_POST['height'] === ''){
        //     $error['height'] = 'blank';
        // }
        $_SESSION = $_POST;
            echo '$er : <br>';
            var_dump($error);
        if(empty($error)){
            echo 'エラーなし';
            $_SESSION = $_POST;
            $image = date('YmdHis') . $_FILES['image']['name'];
            echo '<br>';
            echo 'image : ' . $image;
            echo '<br>';
            echo '$_Files : ';
            var_dump($_FILES);
			move_uploaded_file($_FILES['image']['tmp_name'],'../images/mesurement_pics/' . $image);
			$_SESSION['join']['image'] = $image;
			// header('Location: mesurement_confirm.php');
            echo 'Session : <br>';
            var_dump($_SESSION);
			exit();

        }
    }else{
        // echo '初期表示です';
        echo date('Ymd');
    }
    // var_dump($error);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../common/css/reset.css">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">


    <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>">

    <title>Document</title>
</head>
<body>
    <div class="mycontainer">
        <div class="mycard">
            <div class="mycardheader">
                <!-- d<br> -->
                <!-- <br> -->
                <p><i class="fas fa-weight"></i> Health Data Entry</p>
                
            </div>            
            <form action="" method="post" enctype="multipart/form-data" class="form-group">
                <p class="field_label">Date</p>
                <input type="date" name="date" class="form-control input_nm  <?php if($error['date']=='blank'){echo 'field_error';} ?>" 
                value="<?php
                         if(empty($_POST)){echo date('Y-m-d');
                         }else{
                             echo $_POST['date'];
                         } ?>">
                <?php if($error['date']=='blank'){echo '<p class="error">・入力必須です</p>';}?>

                <p class="field_label">Name</p>
                <select class="form-control input_nm" name="pet">
                    <option value="1">Steve1</option>
                    <option value="2" selected>Steve2</option>
                </select>
                
                <p class="field_label">体重 (g)</p>
                <input type="text" name="weight" class="form-control input_sm <?php if($error['weight']=='blank'){echo 'field_error';} ?>" placeholder="体重を入力"
                value="<?php echo $_POST['weight']; ?>">
                <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                
                <p class="field_label">縦 (cm)</p>
                <input type="text" name="vertical" class="form-control input_sm <?php if($error['vertical']=='blank'){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                value="<?php echo $_POST['vertical']; ?>">
                <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                
                <p class="field_label">幅 (cm)</p>
                <input type="text" name="horizontal" class="form-control input_sm <?php if($error['horizontal']=='blank'){echo 'field_error';} ?>" placeholder="横幅を入力" 
                value="<?php echo $_POST['horizontal']; ?>">
                <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                
                <p class="field_label">高さ (cm)</p>
                <input type="text" name="height" class="form-control input_sm <?php if($error['height']=='blank'){echo 'field_error';} ?>" placeholder="高さを入力" 
                value="<?php echo $_POST['height']; ?>">
                
                <p class="field_label">コメント</p>
                <textarea name="note" id="" cols="30" rows="4" class="form-control" placeholder="コメントを入力"><?php echo $_POST['note']; ?></textarea>
                
                <p class="field_label">写真をアップロード</p>
                <input type="file" name="image" class="form-control" accept="image/jpeg">
                <hr>

                <button id="btn_submit" class="btn btn-secondary" type="submit" name="submit" value="登録">入力を終了して確認画面へ</button>
                <button id="btn_cancel" class="btn btn-light" type="cancel" name="cancel" value="cancel">キャンセル</button>
            </form>
        </div>
    </div>
</body>
</html>
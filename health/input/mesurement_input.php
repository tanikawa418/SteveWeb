<?php
    require('../../common/php/dbconnect.php');
    session_start();


    if(!empty($_POST)){
        var_dump($_POST);

        function numConvert($txt){
            $txt = str_replace('．','.',$txt);
            $txt = mb_convert_kana($txt,'n');
            return $txt;
        }

    //エラーチェック
    if ($_POST['date'] === '') {
        $error['date'] = 'blank';
    }
    if ($_POST['pet'] === '') {
        $error['pet'] = 'blank';
    }
    if ($_POST['weight'] === '') {
        $error['weight'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['weight'])) != 1) {
        $error['weight'] = 'type';
    }
    if ($_POST['vertical'] === '') {
        $error['vertical'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['vertical'])) != 1) {
        $error['vertical'] = 'type';
    }
    if ($_POST['horizontal'] === '') {
        $error['horizontal'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['horizontal'])) != 1) {
        $error['horizontal'] = 'type';
    }
    if ($_POST['height'] === '') {
        // $error['height'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['height'])) != 1) {
        $error['height'] = 'type';
    }
    echo '<br>is_numeric(weight) : ' . is_numeric($_POST['weight']);
    echo '<br> $error[weight] : ' . $error['weight'] . '<br>';
    $_SESSION = $_POST;
    echo '$er : <br>';
    var_dump($error);
    $_POST['weight'] = numConvert($_POST['weight']);
    $_POST['vertical'] = numConvert($_POST['vertical']);
    $_POST['horizontal'] = numConvert($_POST['horizontal']);
    $_POST['height'] = numConvert($_POST['height']);
    echo 'numConvert : '.numConvert($_POST['height']).'<br>';
    if (empty($error)) {
        $_SESSION = $_POST;
        $image = date('YmdHis') . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/mesurement_pics/' . $image);
        $_POST['image'] = $image;
        $sql = 'INSERT INTO `mesurement`(`date`, `pet_id`, `weight`, `vertical`, `horizontal`, `height`, `note`, `pic_filename`, `delete_flag`, `created`) VALUES (cast(:date as date),:pet_id,:weight,:vertical,:horizontal,:height,:note,:pic_filename,0,now())';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
        $stmt->bindValue(':pet_id',$_POST['pet'],PDO::PARAM_INT);
        $stmt->bindValue(':weight',$_POST['weight'],PDO::PARAM_INT);
        $stmt->bindValue(':vertical',$_POST['vertical'],PDO::PARAM_INT);
        $stmt->bindValue(':horizontal',$_POST['horizontal'],PDO::PARAM_INT);
        $stmt->bindValue(':height',$_POST['height'],PDO::PARAM_INT);
        $stmt->bindValue(':note',$_POST['note'],PDO::PARAM_STR);
        $stmt->bindValue(':pic_filename',$_POST['image'],PDO::PARAM_STR);
        $stmt->execute();

        // $stmt->execute(array(
        //    $_POST[('date')] ,
        //    $_POST['pet'] ,
        //    $_POST['weight'] ,
        //    $_POST['vertical'] ,
        //    $_POST['horizontal'] ,
        //    $_POST['height'] ,
        //    $_POST['note'] ,
        //    $_POST['image'] 
        //    ));
        header('Location: ../mesurement.php');
        
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
                <a href=""></a>
                <!-- d<br> -->
                <!-- <br> -->
                <p><i class="fas fa-weight"></i> Health Data Entry</p>
                
            </div>            
            <form action="" method="post" enctype="multipart/form-data" class="form-group">
                <p class="field_label">日付<span class="error">　必須</span></p>
                <input type="date" name="date" class="form-control input_nm  <?php if($error['date']=='blank'){echo 'field_error';} ?>" 
                value="<?php if(empty($_POST)){echo date('Y-m-d');}else{echo $_POST['date'];} ?>">
                <?php if($error['date']=='blank'){echo '<p class="error">・入力必須です</p>';}?>

                <p class="field_label">カメの名前<span class="error">　必須</span></p>
                <select class="form-control input_nm" name="pet">
                    <option value="1">Steve1</option>
                    <option value="2" selected>Steve2</option>
                </select>
                
                <p class="field_label">体重 (g)<span class="error">　必須</span></p>
                <input type="text" name="weight" class="form-control input_sm <?php if($error['weight']!=''){echo 'field_error';} ?>" placeholder="体重を入力"
                value="<?php  echo htmlspecialchars($_POST['weight'],ENT_QUOTES); ?>">
                <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['weight']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                
                <p class="field_label">縦 (cm)<span class="error">　必須</span></p>
                <input type="text" name="vertical" class="form-control input_sm <?php if($error['vertical']!=''){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                value="<?php echo htmlspecialchars($_POST['vertical'],ENT_QUOTES); ?>">
                <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['vertical']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">幅 (cm)<span class="error">　必須</span></p>
                <input type="text" name="horizontal" class="form-control input_sm <?php if($error['horizontal']!=''){echo 'field_error';} ?>" placeholder="横幅を入力" 
                value="<?php echo htmlspecialchars($_POST['horizontal'],ENT_QUOTES); ?>">
                <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['horizontal']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">高さ (cm)</p>
                <input type="text" name="height" class="form-control input_sm <?php if($error['height']!=''){echo 'field_error';} ?>" placeholder="高さを入力" 
                value="<?php echo htmlspecialchars($_POST['height'],ENT_QUOTES); ?>">
                <?php if($error['height']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                
                <p class="field_label">コメント</p>
                <textarea name="note" id="" cols="30" rows="4" class="form-control" placeholder="コメントを入力"><?php echo htmlspecialchars($_POST['note'],ENT_QUOTES); ?></textarea>
                
                <p class="field_label">写真をアップロード</p>
                <img id="myPreview" src="#" alt="">
                <p id="file_change_guide">画像を変更するにはもう一度ファイル選択ボタンを押してください</p>
                <input id="myImage" type="file" name="image" accept="image/jpeg">
                <hr>

                <button id="btn_submit" class="btn btn-secondary" type="submit" name="submit" value="登録">登録する</button>
                <button id="btn_cancel" class="btn btn-light" type="cancel" name="cancel" value="cancel">キャンセル</button>
            </form>
        </div>
    </div>
    <script>
        //画像プレビュー
        var myImage = document.getElementById('myImage');
        myImage.addEventListener('change',function(e){
            var file = e.target.files[0];
            document.getElementById('file_change_guide').style.display = 'block';
            var blobUrl = window.URL.createObjectURL(file);
            var img = document.getElementById('myPreview');
            img.src = blobUrl;
        })
        
    </script>
</body>
</html>
<?php
    session_start();
    require('../../common/php/dbconnect.php');

    function numConvert($txt){
        $txt = str_replace('．','.',$txt);
        $txt = mb_convert_kana($txt,'n');
        return $txt;
    }

    $mode = 'add';
    $pic_path = '../images/mesurement_pics/';
    $def_date = date('Y-m-d');
    $def_weight = '';
    $def_vertical = '';
    $def_horizontal = '';
    $def_height = '';
    $def_note = '';
    $def_preview = '#';
    $def_filename = '';
    // $_SESSION['mesurement_id']=$_POST['mesurement_id'];
    echo '<br>';
    echo '$_SESSION[mesurement_id] : '.$_SESSION['mesurement_id'];
    echo '<br>';


    if(!empty($_POST)){
        //Cancel押下時
        if($_POST['cancel']!=''){
            header('Location: ../mesurement.php');
            exit();
        
        //Editモード
        }elseif($_POST['mode']=='edit'){   //遷移後のイニシャル処理
            
            echo 'Editモードで開きます';
            echo $_SESSION['mesurement_id'];
            $mode = 'edit';
            
            
            // $_SESSION = $_POST;
            // echo '<br>';
            echo '<br>';
            echo '$_session #43 :';
            var_dump($_SESSION);
            // echo '<br>';
            
            if($_POST['submit']==''){
                $sql = 'SELECT * FROM mesurement WHERE mesurement_id = ?';
                $stmt = $db->prepare($sql);
                $stmt->execute(array($_POST['mesurement_id']));
                $response = $stmt->fetch();
                
                //Editモードの初期表示をDBから取得した値に設定
                $def_date = $response['date'];
                $def_weight = $response['weight'];
                $def_vertical = $response['vertical'];
                $def_horizontal = $response['horizontal'];
                $def_height = $response['height'];
                $def_note = $response['note'];
                $def_preview = $pic_path . $response['pic_filename'];
                $def_filename = $response['pic_filename'];
                
                $_SESSION['filename'] = $response['pic_filename'];
                $_SESSION['mesurement_id'] = $response['mesurement_id'];
            } 
                echo '<br>';
            echo '#64 $_SESSION[filename] : ' . $_SESSION['filename'];


            if($_POST['submit'] == 'submit'){   //編集後の更新処理
                // echo 'upしますわ';
                // echo '<br>';
                // echo '$_POST[filename] : ' . $_POST['filename'];
                // echo '<br>';
                // echo '#72$_SESSION[filename] : ' . $_SESSION['filename'];

                //エラーチェック、numConvert
                require('check.php');
                //POSTされた値を出力用変数に格納
                require('default_set.php');
                // echo "\n";
                // echo '$_FILES : '.$_FILES['image']['name'];
                if($_FILES['image']['name']==''){
                    // echo '<br>';
                    // echo 'empty';
                    // echo '<br>';
                    $_POST['image'] = $_SESSION['filename'];
                    $_POST['mesurement_id'] = $_SESSION['mesurement_id'];
                    // $_POST['image'] = '20200525221631CiX_logo (2).jpg';
                    // echo '<br>';
                    // echo 'postImage : ' . $_POST['image'];
                    // echo '<br>';
                    
                }else{
                    // echo 'no empty';
                    $image = date('YmdHis') . $_FILES['image']['name'];
                    $_POST['image'] = $image;
                }
                if(empty($error)){
                    move_uploaded_file($_FILES['image']['tmp_name'], '../images/mesurement_pics/' . $image);
                    
                    
                    $sql = 'UPDATE `mesurement` SET `date`=cast(:date as date),`pet_id`=:pet_id,`weight`=:weight,`vertical`=:vertical,`horizontal`=:horizontal,`height`=:height,`note`=:note,`pic_filename`=:pic_filename WHERE mesurement_id=:mesurement_id';
                    echo $sql;
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
                    $stmt->bindValue(':pet_id',$_POST['pet'],PDO::PARAM_STR);
                    $stmt->bindValue(':weight',$_POST['weight'],PDO::PARAM_STR);
                    $stmt->bindValue(':vertical',$_POST['vertical'],PDO::PARAM_STR);
                    $stmt->bindValue(':horizontal',$_POST['horizontal'],PDO::PARAM_STR);
                    if($_POST['height']==''){
                        $stmt->bindValue(':height',null,PDO::PARAM_NULL);
                    }else{
                        $stmt->bindValue(':height',$_POST['height'],PDO::PARAM_STR);
                    }
                    $stmt->bindValue(':note',$_POST['note'],PDO::PARAM_STR);
                    $stmt->bindValue(':pic_filename',$_POST['image'],PDO::PARAM_STR);
                    $stmt->bindValue(':mesurement_id',$_POST['mesurement_id'],PDO::PARAM_INT);  //todo IDが固定
                    $stmt->execute();

                    echo 'UPDATE `mesurement` SET `date`=cast(' . $_POST['date'] .' as date),pet_id`='
                    . $_POST['pet_id'].',`weight`=' . $_POST['weight'].',`vertical`='.$_POST['vertical'].',`horizontal`='. $_POST['horizontal'].',`height`='. $_POST['height'].',`note`='.$_POST['note'].',`pic_filename`='.$_POST['pic_filename'].' WHERE mesurement_id=23';

                    //セッションの破棄
                    $_SESSION = array();
                    
                    if (isset($_COOKIE["PHPSESSID"])) {
                        setcookie("PHPSESSID", '', time() - 1800, '/');
                    }
                    session_destroy();

                    header('Location: ../mesurement.php');
                    exit();

                }
            }

        //新規登録
        }elseif($_POST['submit']=='submit'){
                // var_dump($_POST);
                echo '$mode : '.$mode;
        
            //エラーチェック、numConvert
            require('check.php');
            var_dump($error);

            //POSTされた値を出力用変数に格納
            require('default_set.php');

            if($_post['mode'] = 'add'){
                //INSERT処理
                if (empty($error)) {
                    // $_SESSION = $_POST;
                    $image = date('YmdHis') . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], '../images/mesurement_pics/' . $image);
                    $_POST['image'] = $image;
                    $sql = 'INSERT INTO `mesurement`(`date`, `pet_id`, `weight`, `vertical`, `horizontal`, `height`, `note`, `pic_filename`, `delete_flag`, `created`) VALUES (cast(:date as date),:pet_id,:weight,:vertical,:horizontal,:height,:note,:pic_filename,0,now())';
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
                    $stmt->bindValue(':pet_id',$_POST['pet'],PDO::PARAM_INT);
                    $stmt->bindValue(':weight',$_POST['weight'],PDO::PARAM_STR);
                    $stmt->bindValue(':vertical',$_POST['vertical'],PDO::PARAM_STR);
                    $stmt->bindValue(':horizontal',$_POST['horizontal'],PDO::PARAM_STR);
                    if($_POST['height']==''){
                        $stmt->bindValue(':height',null,PDO::PARAM_NULL);
                    }else{
                        $stmt->bindValue(':height',$_POST['height'],PDO::PARAM_STR);
                    }
                    $stmt->bindValue(':note',$_POST['note'],PDO::PARAM_STR);
                    $stmt->bindValue(':pic_filename',$_POST['image'],PDO::PARAM_STR);
                    $stmt->execute();
            
                    header('Location: ../mesurement.php');
                    exit();
                }
            }


        }
    }else{
        // echo '初期表示です';
        echo date('Ymd');
    }
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
                <input type="date" name="date" class="form-control input_nm  <?php if($error['date']=='blank'){echo 'field_error';} ?>" value="<?php echo $def_date; ?>">
                <?php if($error['date']=='blank'){echo '<p class="error">・入力必須です</p>';}?>

                <p class="field_label">カメの名前<span class="error">　必須</span></p>
                <select class="form-control input_nm" name="pet">
                    <option value="1">Steve1</option>
                    <option value="2" selected>Steve2</option>
                </select>
                
                <p class="field_label">体重 (g)<span class="error">　必須</span></p>
                <input type="text" name="weight" class="form-control input_sm <?php if($error['weight']!=''){echo 'field_error';} ?>" placeholder="体重を入力"
                value="<?php echo $def_weight; ?>">
                <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['weight']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                
                <p class="field_label">縦 (cm)<span class="error">　必須</span></p>
                <input type="text" name="vertical" class="form-control input_sm <?php if($error['vertical']!=''){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                value="<?php echo $def_vertical; ?>">
                <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['vertical']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">幅 (cm)<span class="error">　必須</span></p>
                <input type="text" name="horizontal" class="form-control input_sm <?php if($error['horizontal']!=''){echo 'field_error';} ?>" placeholder="横幅を入力" 
                value="<?php echo $def_horizontal; ?>">
                <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['horizontal']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">高さ (cm)</p>
                <input type="text" name="height" class="form-control input_sm <?php if($error['height']!=''){echo 'field_error';} ?>" placeholder="高さを入力" 
                value="<?php echo $def_height;?>">
                <?php if($error['height']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                
                <p class="field_label">コメント</p>
                <textarea name="note" id="" cols="30" rows="4" class="form-control" placeholder="コメントを入力"><?php echo $def_note;?></textarea>
                
                <p class="field_label">写真をアップロード</p>
                <img id="myPreview" src="<?php echo $def_preview; ?>" alt="">
                <p id="file_change_guide">画像を変更するにはもう一度ファイル選択ボタンを押してください</p>
                <input id="myImage" type="file" name="image" accept="image/jpeg">
                <hr>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="filename" value="<?php echo $def_filename; ?>">
                <button id="btn_submit" class="btn btn-secondary" type="submit" name="submit" value="submit">登録する</button>
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
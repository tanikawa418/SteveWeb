<?php
    function numConvert($txt){ //全角入力対応
        $txt = str_replace('．','.',$txt);
        $txt = mb_convert_kana($txt,'n');
        return $txt;
    }

    //各変数のdefault設定
    $mode = 'add';
    $btn_caption = '登録する';
    $pic_path = '../images/measurement_pics/';
    $def_date = date('Y-m-d');
    $def_weight = '';
    $def_vertical = '';
    $def_horizontal = '';
    $def_height = '';
    $def_note = '';
    $def_preview = '#';
    $def_filename = '';

    if(!empty($_POST)){
        //Cancel押下時
        if($_POST['cancel']!=''){
            header('Location: ../measurement.php');
            exit();
        
        //Editモード
        }elseif($_POST['mode']=='edit'){
            //編集アイコンから遷移後のイニシャル処理
            $mode = 'edit';
            $btn_caption = '更新する';
            
            if($_POST['submit']==''){
                $sql = 'SELECT * FROM measurement WHERE measurement_id = ?';
                $stmt = $db->prepare($sql);
                $stmt->execute(array($_POST['measurement_id']));
                $response = $stmt->fetch();
                
                //各項目の初期表示をDBから取得した値に設定
                $def_date = $response['date'];
                $def_weight = $response['weight'];
                $def_vertical = $response['vertical'];
                $def_horizontal = $response['horizontal'];
                $def_height = $response['height'];
                $def_note = $response['note'];
                $def_preview = $pic_path . $response['pic_filename'];
                $def_filename = $response['pic_filename'];
                
                //更新ボタン押下時にmeasurement_idをPostさせていないので、Sessionに保存しておく
                $_SESSION['measurement_id'] = $response['measurement_id'];

                //画像を変更しなかった場合、$_FILESから取得できないので、元画像ファイル名をSessionに保存しておく
                $_SESSION['filename'] = $response['pic_filename'];
            } 

            //更新ボタン押下時の処理
            if($_POST['submit'] == 'submit'){   

                //エラーチェック、numConvert
                require('check.php');
                //POSTされた値を出力用変数に格納
                require('default_set.php');
                
                $_POST['measurement_id'] = $_SESSION['measurement_id'];

                if($_FILES['image']['name']==''){
                    //画像が変更されなかった場合
                    $_POST['image'] = $_SESSION['filename'];
                }else{
                    // 画像が変更され、再添付された場合
                    $image = date('YmdHis') . $_FILES['image']['name'];
                    $_POST['image'] = $image;
                }

                //エラーなしの場合、DB更新する
                if(empty($error)){
                    //ファイルを所定ディレクトリに格納
                    move_uploaded_file($_FILES['image']['tmp_name'], '../images/measurement_pics/' . $_POST['image']);

                    //画像がuploadされている場合、元の画像ファイルをディレクトリから削除
                    if(!($_FILES['image']['name']=='')){
                        if(unlink('../images/measurement_pics/' . $_SESSION['filename'])){
                            echo '<br>ファイル削除に成功しました<br>';
                        }else{
                            echo '<br>ファイル削除に失敗しました<br>';
                        }
                    }

                    $sql = 'UPDATE `measurement` SET `date`=cast(:date as date),`pet_id`=:pet_id,`weight`=:weight,`vertical`=:vertical,`horizontal`=:horizontal,`height`=:height,`note`=:note,`pic_filename`=:pic_filename WHERE measurement_id=:measurement_id';

                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
                    $stmt->bindValue(':pet_id',$_POST['pet'],PDO::PARAM_STR);
                    $stmt->bindValue(':weight',$_POST['weight'],PDO::PARAM_STR);
                    $stmt->bindValue(':vertical',$_POST['vertical'],PDO::PARAM_STR);
                    $stmt->bindValue(':horizontal',$_POST['horizontal'],PDO::PARAM_STR);
                    if($_POST['height']==''){ //heightは必須じゃないのでNull=>Intの対策
                        $stmt->bindValue(':height',null,PDO::PARAM_NULL);
                    }else{
                        $stmt->bindValue(':height',$_POST['height'],PDO::PARAM_STR);
                    }
                    $stmt->bindValue(':note',$_POST['note'],PDO::PARAM_STR);
                    $stmt->bindValue(':pic_filename',$_POST['image'],PDO::PARAM_STR);
                    $stmt->bindValue(':measurement_id',$_POST['measurement_id'],PDO::PARAM_INT); 
                    $stmt->execute();

                    header('Location: ../measurement.php');
                    exit();
                }else{
                    $jsondata = json_encode($error);
                }
            }

        //登録ボタン押下時
        }elseif($_POST['submit']=='submit'){
            //エラーチェック、全角Convert
            require('check.php');

            //POSTされた値を出力用変数に格納
            require('default_set.php');

            if (empty($error)) {
                //画像ファイルの処理
                if(!empty($_FILES['image']['name'])){
                    $path = '../images/measurement_pics/';
                    $image = date('YmdHis') . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $path . $image);
                    $_POST['image'] = $image;

                    require('../../common/php/create_thumb.php');
                    create_thumbnail(600,600,$path,$image,60);

                }

                //SQL実行
                $sql = 'INSERT INTO `measurement`(`date`, `pet_id`, `weight`, `vertical`, `horizontal`, `height`, `note`, `pic_filename`, `delete_flag`, `created`) VALUES (cast(:date as date),:pet_id,:weight,:vertical,:horizontal,:height,:note,:pic_filename,0,now())';
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
                $stmt->bindValue(':pet_id',$_POST['pet'],PDO::PARAM_INT);
                $stmt->bindValue(':weight',$_POST['weight'],PDO::PARAM_STR);
                $stmt->bindValue(':vertical',$_POST['vertical'],PDO::PARAM_STR);
                $stmt->bindValue(':horizontal',$_POST['horizontal'],PDO::PARAM_STR);
                if($_POST['height']==''){ //heightは必須じゃないのでNull=>Intの対策
                    $stmt->bindValue(':height',null,PDO::PARAM_NULL);
                }else{
                    $stmt->bindValue(':height',$_POST['height'],PDO::PARAM_STR);
                }
                $stmt->bindValue(':note',$_POST['note'],PDO::PARAM_STR);
                $stmt->bindValue(':pic_filename',$_POST['image'],PDO::PARAM_STR);
                $stmt->execute();
                
                header('Location: ../measurement.php');
                exit();
            }else{
                $jsondata = json_encode($error);
            }
        }
    }else{
        // 一覧から新規作成ボタンを押して遷移してきた場合
        //特に処理なし
    }

?>
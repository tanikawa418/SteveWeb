<?php
    session_start();
    require("../../common/php/login_check.php");
    require('../../common/php/dbconnect.php');
    require('main.php');
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

    <title>Health Data Entry</title>
    <link rel="stylesheet" href="styles/style.css">

</head>
<body>
    <div class="mycontainer">
        <div class="mydialog">
            <div class="mydialog_header">
                <a href=""></a>
                <p><i class="fas fa-weight"></i> Health Data Entry</p>
            </div>            
            <form action="" method="post" enctype="multipart/form-data" class="form-group">
                
                <p class="field_label">日付<span class="required">　(必須)</span></p>
                <input id="date" type="date" name="date" class="form-control input_nm  <?php if($error['date']=='blank'){echo 'field_error';} ?>" value="<?php echo $def_date; ?>">
                <?php if($error['date']=='blank'){echo '<p class="error">・入力必須です</p>';}?>

                <p class="field_label">カメの名前<span class="required">　(必須)</span></p>
                <select  id="pet" class="form-control input_nm" name="pet">
                    <option value="1">Steve1</option>
                    <option value="2" selected>Steve2</option>
                </select>
                
                <div id="field_wrp_weight">
                    <p class="field_label">体重 (g)<span class="required">　(必須)</span></p>
                    <input id="weight" type="text" name="weight" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['weight']!=''){echo 'field_error';} ?>" placeholder="体重を入力"
                    value="<?php echo $def_weight; ?>">
                    <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['weight']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>

                <div>
                    <p class="field_label">縦 (cm)<span class="required">　(必須)</span></p>
                    <input id="vertical" type="text" name="vertical" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['vertical']!=''){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                    value="<?php echo $def_vertical; ?>">
                    <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['vertical']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    

                <div>
                    <p class="field_label">幅 (cm)<span class="required">　(必須)</span></p>
                    <input id="horizontal" type="text" name="horizontal" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['horizontal']!=''){echo 'field_error';} ?>" placeholder="横幅を入力" 
                    value="<?php echo $def_horizontal; ?>">
                    <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['horizontal']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    

                <div>
                    <p class="field_label">高さ (cm)</p>
                    <input id="height" type="text" name="height" data-req="0" data-type="num" class="form-control validation input_sm <?php if($error['height']!=''){echo 'field_error';} ?>" placeholder="高さを入力" 
                    value="<?php echo $def_height;?>">
                    <?php if($error['height']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    
                
                <div>
                    <p class="field_label">コメント</p>
                    <textarea name="note" cols="30" rows="4" class="form-control validation" data-min="5" data-max="10" placeholder="コメントを入力"><?php echo $def_note;?></textarea>
                </div>
                
                <p class="field_label">写真をアップロード</p>
                <img id="myPreview" src="<?php echo $def_preview; ?>" alt="">
                <p id="file_change_guide">画像を変更するにはもう一度ファイル選択ボタンを押してください</p>
                <input id="myImage" type="file" name="image" accept="image/jpeg">
                <hr>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="filename" value="<?php echo $def_filename; ?>">
                <button id="btn_submit" class="btn btn-secondary" type="submit" name="submit" value="submit"><?php echo $btn_caption; ?></button>
                <button id="btn_cancel" class="btn btn-light" type="cancel" name="cancel" value="cancel">キャンセル</button>
            </form>
        </div>
    </div>
    <script src="../../common/js/ErrorMsg.js"></script>
    <script src="../../common/js/InputObserver.js"></script>
    <script>
        //画像プレビュー処理
        var myImage = document.getElementById('myImage');
        myImage.addEventListener('change',function(e){
            var file = e.target.files[0];
            document.getElementById('file_change_guide').style.visibility = 'visible';
            var blobUrl = window.URL.createObjectURL(file);
            var img = document.getElementById('myPreview');
            img.src = blobUrl;
        })
        
        //バリデーション入力監視を設定
        document.addEventListener('DOMContentLoaded',function(){
            const els = document.querySelectorAll('.validation');
            const iptObv = new InputObserver(els);
            iptObv.setEventLinstener();

            //PHPからエラー配列を受け取る
            // let submit_error = {};
            const submit_error = <?php if(isset($jsondata)){echo $jsondata;}else{echo '{}';} ?>;
            if(submit_error){
                console.log(submit_error);
                for (const key in submit_error) {
                    if (submit_error.hasOwnProperty(key)) {
                        const element = submit_error[key];
                        er = new ErrorMsg(`#${key}`,element,'error');
                        er.viewMessage();
                    }
                }
            }
        })

    </script>
</body>
</html>
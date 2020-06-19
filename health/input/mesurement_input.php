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
                <input type="date" name="date" class="form-control input_nm  <?php if($error['date']=='blank'){echo 'field_error';} ?>" value="<?php echo $def_date; ?>">
                <?php if($error['date']=='blank'){echo '<p class="error">・入力必須です</p>';}?>

                <p class="field_label">カメの名前<span class="required">　(必須)</span></p>
                <select class="form-control input_nm" name="pet">
                    <option value="1">Steve1</option>
                    <option value="2" selected>Steve2</option>
                </select>
                
                <p class="field_label">体重 (g)<span class="required">　(必須)</span></p>
                <input type="text" name="weight" class="form-control input_sm <?php if($error['weight']!=''){echo 'field_error';} ?>" placeholder="体重を入力"
                value="<?php echo $def_weight; ?>">
                <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['weight']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                
                <p class="field_label">縦 (cm)<span class="required">　(必須)</span></p>
                <input type="text" name="vertical" class="form-control input_sm <?php if($error['vertical']!=''){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                value="<?php echo $def_vertical; ?>">
                <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['vertical']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">幅 (cm)<span class="required">　(必須)</span></p>
                <input type="text" name="horizontal" class="form-control input_sm <?php if($error['horizontal']!=''){echo 'field_error';} ?>" placeholder="横幅を入力" 
                value="<?php echo $def_horizontal; ?>">
                <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                <?php if($error['horizontal']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                <p class="field_label">高さ (cm)</p>
                <input type="text" name="height" class="form-control input_sm <?php if($error['height']!=''){echo 'field_error';} ?>" placeholder="高さを入力" 
                value="<?php echo $def_height;?>">
                <?php if($error['height']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>

                
                <p class="field_label">コメント</p>
                <textarea name="note" cols="30" rows="4" class="form-control" placeholder="コメントを入力"><?php echo $def_note;?></textarea>
                
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
    <script>
        //画像プレビュー
        var myImage = document.getElementById('myImage');
        myImage.addEventListener('change',function(e){
            var file = e.target.files[0];
            document.getElementById('file_change_guide').style.visibility = 'visible';
            var blobUrl = window.URL.createObjectURL(file);
            var img = document.getElementById('myPreview');
            img.src = blobUrl;
        })
        
    </script>
</body>
</html>
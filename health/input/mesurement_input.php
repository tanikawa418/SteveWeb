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
                
                <div id="field_wrp_weight">
                    <p class="field_label">体重 (g)<span class="required">　(必須)</span></p>
                    <input type="text" name="weight" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['weight']!=''){echo 'field_error';} ?>" placeholder="体重を入力"
                    value="<?php echo $def_weight; ?>">
                    <?php if($error['weight']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['weight']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>

                <div>
                    <p class="field_label">縦 (cm)<span class="required">　(必須)</span></p>
                    <input type="text" name="vertical" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['vertical']!=''){echo 'field_error';} ?>" placeholder="縦の長さを入力" 
                    value="<?php echo $def_vertical; ?>">
                    <?php if($error['vertical']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['vertical']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    

                <div>
                    <p class="field_label">幅 (cm)<span class="required">　(必須)</span></p>
                    <input type="text" name="horizontal" data-req="1" data-type="num" class="form-control validation input_sm <?php if($error['horizontal']!=''){echo 'field_error';} ?>" placeholder="横幅を入力" 
                    value="<?php echo $def_horizontal; ?>">
                    <?php if($error['horizontal']=='blank'){echo '<p class="error">・入力必須です</p>';}?>
                    <?php if($error['horizontal']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    

                <div>
                    <p class="field_label">高さ (cm)</p>
                    <input type="text" name="height" data-req="0" data-type="num" class="form-control validation input_sm <?php if($error['height']!=''){echo 'field_error';} ?>" placeholder="高さを入力" 
                    value="<?php echo $def_height;?>">
                    <?php if($error['height']=='type'){echo '<p class="error">・数値で入力してください</p>';}?>
                </div>    
                
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
        
        document.addEventListener('DOMContentLoaded',function(){
            const els = document.querySelectorAll('.validation');
            const iptObv = new InputObserver(els);
        })


        class ErrorMsg{
            constructor(target, type, level){
                this.parent = target instanceof HTMLElement ? target : document.querySelector(target);
                this.type = type;
                this.level = level;
                this.msg = this._getMessage(type);
            }
            _getMessage(type){
                if(type == 'num'){return '数値で入力してください'};
                if(type == 'blank'){return '入力必須だよ'};
            }
            viewMessage(){
                let msg_el = document.createElement('span');
                msg_el.className = this.level;
                msg_el.dataset.err_type = this.type;
                msg_el.innerHTML = this.msg;
                this.parent.appendChild(msg_el);
                let field_el = msg_el.previousElementSibling;
                field_el.classList.add('field_error');
            }
        }
        
        class InputObserver{
            constructor(els){
                this.DOM = {};
                this.DOM.els = els;
                this._init();
            }
            //TODO:cbをinitにするのではなく、クラスメソッドにして、バックエンドからの処理でも使えるようにすべき
            //TODO:keyupのEventListener設定もクラスメソッドにし、DOMContentLoadedからそれを呼ぶようにする
            _init() {
                const cb = function(){
                    //親Nodeの取得
                    let parent_node = this.parentNode;
                    //既に表示されているエラーメッセージを削除
                    let err_span = parent_node.querySelectorAll('span.error');
                    err_span.forEach(element => {
                        parent_node.removeChild(element);
                    });
                    this.classList.remove('field_error');

                    //チェック処理（今後の拡張に備えて配列で保持する）
                    let err_arr = [];
                    if(this.dataset.type == 'num' && isNaN(this.value)){
                        err_arr.push([parent_node,this.dataset.type,'error']);
                    }
                    if(this.dataset.req == 1 && !this.value){
                        err_arr.push([parent_node,'blank','error']);
                    }
                    //TODO:この部分も独立したクラスメソッドにして、PHPから配列を渡してそれを呼ぶようにする
                    err_arr.forEach(element => {
                        //ErrorMsgをインスタンス化
                        let em = new ErrorMsg(element[0],element[1],element[2]);
                        em.viewMessage();
                    });
                };
                
                //渡ってきたすべてのelsに対してEventListener設定（コールバックでcbを指定）
                this.DOM.els.forEach(element => {
                    element.addEventListener('keyup',cb);
                });
            };
        }
        
    </script>
</body>
</html>
<?php
require("../common/php/login_check.php");

require('../common/php/dbconnect.php');
if(!empty($_POST)){
    if($_POST['category'] !== ''){ //カテゴリを選ばせるまではDBへの問い合わせをしない
        $category = $_POST['category'];
        $refresh = $_POST['refresh'];

        if($category == 'youtube'){
            if($refresh == 'on'){ //初期表示など、DB接続リフレッシュの時
                $stmt = $db->query('SELECT * FROM youtube_rss WHERE load_default<>0 ORDER BY display_order');
                $arr_feed = array(); //空配列の定義
    
                foreach($stmt as $value){
                    //urlを配列に格納
                    array_push($arr_feed,$value['rss_url']);
                }
        
                unset($stmt);
                unset($value);

            }elseif($_POST['preview']!=''){ //RSSプレビューの時
                $arr_feed = array(); //空配列の定義
                $channel_id = $_POST['channel_id']; //プレビュー対象だけを配列にセット
                $is_prev_mode = '1';
                array_push($arr_feed,'https://www.youtube.com/feeds/videos.xml?channel_id=' . $_POST['channel_id']);
            }elseif($_POST['submit'] == '登録する'){

                $sql = 'INSERT INTO `youtube_rss`(`youtube_name`, `rss_url`, `note`, `display_order`, `load_default`) VALUES ("",?,"",1,1)';
                $stmt = $db->prepare($sql);
                $stmt->execute(array('https://www.youtube.com/feeds/videos.xml?channel_id=' . $_POST['channel_id']));
                $channel_id='';
                $is_prev_mode = '0';
                header('Location:links.php');
                exit();
            }


        }elseif($category == 'website'){
            if($_POST['submit']=='登録する'){
                $sql = 'INSERT INTO `websites`(`site_name`, `site_url`, `title`, `note`, `display_order`, `load_default`) VALUES (?,?,?,?,1,1)';
                $stmt = $db->prepare($sql);
                $stmt->execute(array(
                    $_POST['site_name'],
                    $_POST['site_url'],
                    $_POST['title'],
                    $_POST['note']
                ));
                header('Location:links.php');
                exit();
            }
            $stmt = $db->query('SELECT * FROM websites WHERE load_default<>0 ORDER BY display_order');
            $arr_weblink = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $jsonData = json_encode($arr_weblink);
            unset($stmt);
            unset($value);
        }
    }
}else{
    // print '$_POSTがカラです';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../common/css/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <title>Links</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            <p>Steve the tortoise</p>
            <h1>Links</h1>
        </div>
        <a href="..\home\index.php">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>

    </header>

    <div class="mycontainer">
        <div class="categorywrapper">
            <p>カテゴリを選んでください</p>
            <form action="" method="post">
            <input type="hidden" name="category" value="youtube">
            <input type="hidden" name="refresh" value="on">
                <!-- <input type="submit" value="送信する"> -->
                <input id="pic_btn_youtube" class="picbutton" type="submit" name="submit" value="">
            </form>
            <form action="" method="post">
                <!-- <input class="picbutton" type="image" name="submit" src="images/tortoise_shape.png" value="SUBMIT2"> -->
                <input type="hidden" name="category" value="website">
                <input type="hidden" name="refresh" value="on">
                <input id="pic_btn_website" class="picbutton" type="submit" name="submit" value="Website">
            </form>
            <div class="cb"></div>
        </div>

        <p class="<?php if(isset($category) && $category == 'youtube'){echo 'reveal';}else{echo 'hidden';}?>">
        
        <? echo $is_prev_mode;?>
        <!-- <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#add_youtube" aria-expanded="false" id="collapse_btn_yt" aria-controls="add_youtube"> -->
            <button id="collapse_btn_yt">
                Youtube RSSを追加する
            </button>
        <!-- </button> -->
        </p>
        <!-- <div class="collapse" id="add_youtube"> -->
            <div class="card card-body" style="display:<?php if($is_prev_mode=='1'){echo 'flex';}else{echo 'none';}?>" id="yt_form">
                <form action="" method="post">
                    チャンネルID
                    <input type="hidden" name="refresh" value="off">
                    <input type="hidden" name="category" value="youtube">
                    <input type="text" name="channel_id" <?php if(isset($channel_id)){print('value='.$channel_id);}?>>
                    <!-- <input type="button" name="preview" value="確認する"><br> -->
                    <button type="submit" name="preview" value="チェック">チェックする</button>
                    
                    <button type="submit" name="submit" value="登録する">登録する</button>
                    <p>
                        <?php if($is_prev_mode=='1'){
                            echo '<br>';
                            echo '下にプレビューが正しく表示されたら登録可能です';
                        }else{
                            echo '<br>';
                            echo 'YoutubeのチャンネルページのURLの最後の部分(「channel/」の後の部分)をコピペして、チェックするを押してください';
                            echo '<br>';
                            echo '記入例 : https://www.youtube.com/channel/<span class="example">UCRstW1gxiR0tHJ7dSJJWv4Q</span>';
                        }?>
                    </p>
                </form>
            </div>
        <!-- </div> -->
        <p class="<?php if(isset($category) && $category == 'website'){echo 'class="reveal"';}else{echo 'hidden';}?>">
            <button id="collapse_btn_ws">
                リンクを追加する
            </button>
        </p>
        <div class="collapse" id="ws_form">
            <div class="card card-body">
                <form action="" method="post" id="ws_form">
                    <input type="hidden" name="category" value="website">
                    <span class="fieldlabel">サイト名</span> 
                    <input type="text" name="site_name"><br>
                    <span class="fieldlabel">サイトURL</span> 
                    <input type="text" name="site_url"><br>
                    <span class="fieldlabel">タイトル</span> 
                    <input type="text" name="title">※画面に表示されるタイトルです<br>
                    <span class="fieldlabel">内容</span> 
                    <input type="text" name="note">※キーワード検索対象です。サイトから内容をコピペしてください。<br>
                    <button type="submit" name="submit" value="登録する">登録する</button>
                </form>
            </div>
        </div>
        <?php
            // $xmlTree = simplexml_load_file('https://h2o-space.com/feed/');
            // FeedのURLをセット
            if(isset($category) && $category == 'youtube'){

                for($x=0; $x<count($arr_feed); $x++){
                    //RSSフィードの数だけ順に繰り返す

                    //RSSフィードのURLを取得
                    $feed=$arr_feed[$x];
                    
                    // xmlファイルの読み込み
                    $xmlTree = simplexml_load_file($feed);
                    
                    // 読み込んだ内容を配列に変換
                    $obj = get_object_vars($xmlTree);
                    
                    // YoutubeのRSSはentryタグに情報が入ってるので、それを変数に格納
                    $obj_entry=$obj["entry"];
                    $obj_channel_title = $obj["title"];
                    
                    //件数を取得
                    $obj_count = count($obj_entry);
                
                    //forで処理
                    if($obj_count != 0){
                        echo '<div class="channelwrapper cf">';
                        //チャンネルタイトル
                        echo '<p class="channeltitle">' .$obj_channel_title . '</p>';
                        
                        // for($i=0; $i<$obj_count; $i++){
                        for($i=0; $i<4; $i++){  //重いので一時的に件数制限
                            foreach($obj_entry[$i] as $key => $value){ //全てのタグを参照し、その都度$valueに設定し直す
                                
                                if($key == "id"){
                                    $video_id = str_replace('yt:video:','',$value[0]); //邪魔な文字列を削除
                                }elseif($key == 'title') {
                                    $video_title = $value[0];
                                }else{
                                    continue;
                                }
                            }
                            // echo '<li>';
                            echo '<div class="moviebox">';
                            echo '<iframe width="330" height="187" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0"></iframe>'; 
                        echo '</div>'; //moviebox
                        }
                        echo '</div>'; //channelwrapper
                    }
                }
            }elseif(isset($category) && $category == 'website'){
                // print 'website<br>';
                echo '<div>検索</div>';
                echo '<input type="text" id="site_kw">';
                echo '<div id="card"></div>';                
            }

        ?>
        <div id="card"></div>
            
    </div> <!--mycontainer -->

    
    <script type="text/javascript">
        function removeElm(){
            var target = document.getElementsByClassName('sitewrapper');
            console.log('target.length : ' + target.length);
            // for(var i = 0; i < target.length; i++){
            while(target.length){
                target[0].remove();
                // console.log(i + 'removed');
            }
        }

        function websiteLinkMark(key){
            removeElm();
            console.log('called');
            var mywrapper;
            var mytitleDiv;
            var mytitle;
            var mycb;
            var mycontents;
            var mydl;
            var mydt;
            var mydd;
            var weblinks = <?php echo $jsonData;?>;
    
        
            for (var i=0; i<weblinks.length; i++){
                var note = weblinks[i]['note'];
                var result = note.match(key);
                console.log('result : ' + result);
                if(!result){
                    console.log(weblinks[i]['site_id'] + ' : unmatched');
                    
                }else{
    
                    console.log(weblinks[i]['site_id'] + ' : matched');
    
    
                mywrapper = document.createElement('div');
                mywrapper.className = 'sitewrapper';
                //create Div.sitetitle
                mytitleDiv = document.createElement('div');
                mytitleDiv.className = 'sitetitle';
                //create span.sitetitle
                mytitle = document.createElement('span');
                mytitle.className = 'span_title';
                mytitle.innerHTML = weblinks[i]['title'];
    
                // create span.span_link_icon
                myicon = document.createElement('span');
                myicon.className = 'span_link_icon';
                myicon.innerHTML = '<a href="#"><i class="fas fa-external-link-alt"></i></a>';
    
                // div.cb
                mycb = document.createElement('div');
                mycb.className = 'cb';
    
                //Div.sitetitleにappend
                mytitleDiv.appendChild(mytitle);
                // mytitleDiv.appendChild(myicon);
                mytitleDiv.appendChild(mycb);
    
                //create div.sitecontents
                mycontents = document.createElement('div');
                mycontents.className = 'sitecontents';
    
                //dl
                mydl = document.createElement('dl');
                // URL
                mydt = document.createElement('dt');
                mydt.innerHTML = 'URL';
                mydd = document.createElement('dd');
                mydd.innerHTML = '<a href="' + weblinks[i]['site_url'] + '" target="_blank">' + weblinks[i]['site_url'] + '</a>';
                mydl.appendChild(mydt);
                mydl.appendChild(mydd);
                
                // Notes
                mydt = document.createElement('dt');
                mydt.innerHTML = 'Notes';
                mydd = document.createElement('dd');
                mydd.innerHTML = weblinks[i]['note'];
                mydd.className = 'notecontents';
                mydl.appendChild(mydt);
                mydl.appendChild(mydd);
    
                //dlをdiv.sitecontentsにappend
                mycontents.appendChild(mydl);
    
                mywrapper.appendChild(mytitleDiv);
                mywrapper.appendChild(mycontents);
                document.getElementById('card').appendChild(mywrapper);
                }  
            }
            console.log('end of weblinkmark()');

        }

        websiteLinkMark();
        //リアルタイム検索
        let input_kw = document.getElementById('site_kw');
        var s;
        input_kw.addEventListener('keyup',function(){
            console.log('before s : ' + s);
            if(s != input_kw.value){
                s = input_kw.value;
                console.log('after s : ' + s);
                console.log('websiteLinkMark() is called with parameter : ' + s);
                websiteLinkMark(s);
    
            }
            // removeElm();
            
        },false);
        </script>

        <script>    
            //Collapse Menu
            document.getElementById('collapse_btn_yt').addEventListener('click',function(){
                console.log('clicked');
                var disp_status = document.defaultView.getComputedStyle(document.getElementById('yt_form'),null).display;
                console.log('status : ' + disp_status);
                if(disp_status != 'none'){
                    document.getElementById('yt_form').style.display = 'none';
                }else{
                    document.getElementById('yt_form').style.display = 'flex';                    
                }            
            })

            document.getElementById('collapse_btn_ws').addEventListener('click',function(){
                console.log('clicked');
                var disp_status = document.defaultView.getComputedStyle(document.getElementById('ws_form'),null).display;
                console.log('status : ' + disp_status);
                if(disp_status != 'none'){
                    document.getElementById('ws_form').style.display = 'none';
                }else{
                    document.getElementById('ws_form').style.display = 'flex';                    
                }
            })
        </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>



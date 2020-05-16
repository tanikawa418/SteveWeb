<?php

require('../common/php/dbconnect.php');

if(!empty($_POST)){
    if($_POST['category'] !== ''){
        $category = $_POST['category'];

        if($category == 'youtube'){
            $stmt = $db->query('SELECT * FROM youtube_rss WHERE load_default<>0 ORDER BY display_order');
            $arr_feed = array();
            foreach($stmt as $value){
                print('<p>');
                print($value['youtube_id']) . ':';
                print($value['rss_url']);
                print('</p>');

                array_push($arr_feed,$value['rss_url']);
            }
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
    <link rel="stylesheet" href="../common/css/reset.css">
    <link rel="stylesheet" href="style.css">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <title>Links</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            Links
        </div>
        <a href="..\home\index.html">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>

    </header>

    <div class="mycontainer">
        <div class="categorywrapper">
            <p>カテゴリを選んでください</p>
            <form action="" method="post">
                <input type="hidden" name="category" value="youtube">
                <!-- <input type="submit" value="送信する"> -->
                <input id="pic_btn_youtube" class="picbutton" type="submit" name="submit" value="">
            </form>
            <form action="" method="post">
                <!-- <input class="picbutton" type="image" name="submit" src="images/tortoise_shape.png" value="SUBMIT2"> -->
                <input type="hidden" name="category" value="website">
                <input id="pic_btn_website" class="picbutton" type="submit" name="submit" value="Website">
            </form>
            <div class="cb"></div>
        </div>

    <?php
        // $xmlTree = simplexml_load_file('https://h2o-space.com/feed/');
        // FeedのURLをセット
        if(isset($category) && $category == 'youtube'){

            // var_dump($_POST);
            // exit();

            // $arr_feed=array(
            //     "https://www.youtube.com/feeds/videos.xml?channel_id=UCri4bglAZURuJVgYQAFwjHA",
            //     "https://www.youtube.com/feeds/videos.xml?channel_id=UConWtiDi5UKJ-dmZdCUCXyQ",
            //     "https://www.youtube.com/feeds/videos.xml?channel_id=UC3MdojXyKFqEQqNhfxiQZCQ",
                
            // );
            
            // echo '<ol>';
            
            
            for($x=0; $x<count($arr_feed); $x++){
                //RSSフィードの数だけ順に繰り返す

                //RSSフィードのURLを取得
                $feed=$arr_feed[$x];
                
                // xmlファイルの読み込み
                $xmlTree = simplexml_load_file($feed);
                
                // 配列に変換
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
                    for($i=0; $i<4; $i++){  //重いので一時的に2件ずつに
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
        
            // echo '<a href="https://woriver.com/8601/" target="_blank">リクガメの飼育方法</a>';
            
        }

    ?>

    <div class="sitewrapper">
        <div class="sitetitle">
            <span class="span_title">title</span>
            <span class="span_link_icon"><a href="#"><i class="fas fa-external-link-alt"></i></a></span>
            <div class="cb"></div>
        </div>
        <div class="sitecontents">
            <dl>
                <dt>URL</dt>
                <dd><a href="http://www.sample/home/" target="_blank">http://www.sample/home/</a></dd>
                <dt>Notes</dt>
                <dd>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia repellendus aut quibusdam nostrum pariatur eos odio, explicabo quis quo iure commodi! Aliquam inventore delectus suscipit architecto ab exercitationem molestias incidunt?</dd>
                <dd><a href="https://webliker.info/13381/"><img title="HTMLの説明リストタグ【dl・dt・dd】の使い方を徹底解説 | webliker" src="http://capture.heartrails.com/free/1589612975069?https://webliker.info/13381/" alt="https://webliker.info/13381/" width="200" height="300" /></a></dd>
            </dl>
        </div>
    </div>
    </div> <!--mycontainer -->

</body>
</html>
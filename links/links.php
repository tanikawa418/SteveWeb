<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../common/reset.css" media="screen and (min-width: 1025px)">
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

    <?php
        // $xmlTree = simplexml_load_file('https://h2o-space.com/feed/');
        // FeedのURLをセット
        $arr_feed=array(
            "https://www.youtube.com/feeds/videos.xml?channel_id=UCri4bglAZURuJVgYQAFwjHA",
            "https://www.youtube.com/feeds/videos.xml?channel_id=UConWtiDi5UKJ-dmZdCUCXyQ",
            "https://www.youtube.com/feeds/videos.xml?channel_id=UC3MdojXyKFqEQqNhfxiQZCQ",
            
        );

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
                //チャンネルタイトル（olのli）
                // echo '<li>'.$obj_channel_title.'</li>';
                echo '<div class="channelwrapper cf">';
                echo '<p class="channeltitle">' .$obj_channel_title . '</p>';
                //ulタグの開始
                // echo '<ul>';
                
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
                    // echo '<a href="https://www.youtube.com/watch?v='.$video_id.'">';
                    // echo $video_title;
                    // echo '</a>';
                    // echo '</li>';
                    echo '</div>'; //moviebox
                }
                // echo '</ul><br>';
                // echo '<div class="cb"></div>';
                echo '</div>'; //channelwrapper
            }
        }
        // echo '</ol>';
        ?>
        
    
    </div> <!--mycontainer -->

</body>
</html>
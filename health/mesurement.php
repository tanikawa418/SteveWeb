<?php

require('../common/php/dbconnect.php');

if(!empty($_POST)){
    if($_POST['category'] !== ''){ //カテゴリを選ばせるまではDBへの問い合わせをしない
        $category = $_POST['category'];

        if($category == 'youtube'){
            $stmt = $db->query('SELECT * FROM youtube_rss WHERE load_default<>0 ORDER BY display_order');
            
            $arr_feed = array(); //空配列の定義

            foreach($stmt as $value){
                //urlを配列に格納
                array_push($arr_feed,$value['rss_url']);
            }
            unset($stmt);
            unset($value);
        }elseif($category == 'website'){
            $stmt = $db->query('SELECT * FROM websites WHERE load_default<>0 ORDER BY display_order');
            $arr_weblink = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($arr_weblink);
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
    <link rel="stylesheet" href="../common/css/reset.css">
    <!-- bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!-- lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" type="text/javascript" ></script>
    <link rel="stylesheet" href="style.css">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    


    <title>Health Data</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            Health Data
        </div>
        <a href="..\home\index.html">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>

    </header>

    <div class="mycontainer cf">

        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="images/DSC_0707.JPG" data-lightbox = "lb"><img class="thumbnails" src="images/DSC_0707.JPG" alt=""></a>
            </div>
            <div class="cardright">
                <div class="cardheader cf">
                    <div class="carddate">2019/8/25</div>
                    <div class="cardprofile">
                        <span>Steve1世</span>
                        <div class="profile_pic_frame">
                            Dummy
                            <img src="#" alt="">
                        </div>
                    </div>
                </div>
                <div class="cardcontents cf">
                    <div class="carddata">
                        <table>
                            <tr>
                                <th>体重</th>
                                <td>109.3 g</td>
                            </tr>
                            <tr>
                                <th>長さ</th>
                                <td>10.4 cm</td>
                            </tr>
                            <tr>
                                <th>幅</th>
                                <td>7.4 cm</td>
                            </tr>
                            <tr>
                                <th>高さ</th>
                                <td>- cm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="cardnotes">
                        初めての身体測定！少しびっくりしてたみたいだけど、無事終了！元気に大きくなってね。
                    </div>
                </div>
            </div>
        </div>
 
        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="images/DSC_0707.JPG" data-lightbox = "lb"><img class="thumbnails" src="images/DSC_0707.JPG" alt=""></a>
            </div>
            <div class="cardright">
                <div class="cardheader cf">
                    <div class="carddate">2019/8/25</div>
                    <div class="cardprofile">
                        <span>Steve1世</span>
                        <div class="profile_pic_frame">
                            Dummy
                            <img src="#" alt="">
                        </div>
                    </div>
                </div>
                <div class="cardcontents cf">
                    <div class="carddata">
                        <table>
                            <tr>
                                <th>体重</th>
                                <td>109.3 g</td>
                            </tr>
                            <tr>
                                <th>長さ</th>
                                <td>10.4 cm</td>
                            </tr>
                            <tr>
                                <th>幅</th>
                                <td>7.4 cm</td>
                            </tr>
                            <tr>
                                <th>高さ</th>
                                <td>- cm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="cardnotes">
                        初めての身体測定！少しびっくりしてたみたいだけど、無事終了！元気に大きくなってね。
                    </div>
                </div>
            </div>
        </div>

        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="images/DSC_0707.JPG" data-lightbox = "lb"><img class="thumbnails" src="images/DSC_0707.JPG" alt=""></a>
            </div>
            <div class="cardright">
                <div class="cardheader cf">
                    <div class="carddate">2019/8/25</div>
                    <div class="cardprofile">
                        <span>Steve1世</span>
                        <div class="profile_pic_frame">
                            Dummy
                            <img src="#" alt="">
                        </div>
                    </div>
                </div>
                <div class="cardcontents cf">
                    <div class="carddata">
                        <table>
                            <tr>
                                <th>体重</th>
                                <td>109.3 g</td>
                            </tr>
                            <tr>
                                <th>長さ</th>
                                <td>10.4 cm</td>
                            </tr>
                            <tr>
                                <th>幅</th>
                                <td>7.4 cm</td>
                            </tr>
                            <tr>
                                <th>高さ</th>
                                <td>- cm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="cardnotes">
                        初めての身体測定！少しびっくりしてたみたいだけど、無事終了！元気に大きくなってね。
                    </div>
                </div>
            </div>
        </div>

        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="images/DSC_0707.JPG" data-lightbox = "lb"><img class="thumbnails" src="images/DSC_0707.JPG" alt=""></a>
            </div>
            <div class="cardright">
                <div class="cardheader cf">
                    <div class="carddate">2019/8/25</div>
                    <div class="cardprofile">
                        <span>Steve1世</span>
                        <div class="profile_pic_frame">
                            Dummy
                            <img src="#" alt="">
                        </div>
                    </div>
                </div>
                <div class="cardcontents cf">
                    <div class="carddata">
                        <table>
                            <tr>
                                <th>体重</th>
                                <td>109.3 g</td>
                            </tr>
                            <tr>
                                <th>長さ</th>
                                <td>10.4 cm</td>
                            </tr>
                            <tr>
                                <th>幅</th>
                                <td>7.4 cm</td>
                            </tr>
                            <tr>
                                <th>高さ</th>
                                <td>- cm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="cardnotes">
                        初めての身体測定！少しびっくりしてたみたいだけど、無事終了！元気に大きくなってね。
                    </div>
                </div>
            </div>
        </div>
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

        // function removeElm(){
        //     var target = document.getElementById('card');
        //     target.removeChild();
        // }
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
    
        
    
            // console.log('length:' + weblinks.length);
    
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

</body>
</html>



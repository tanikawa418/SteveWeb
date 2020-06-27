<?php
    require("../common/php/login_check.php");
    require('../common/php/dbconnect.php');

    $dir = 'images/';
    $files = glob($dir . '*');

    // var_dump($files);

    



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" type="text/javascript" ></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="styles/style.css">
    <title>Gallery</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            <p>Steve the tortoise</p>
            <h1>Gallery</h1>
            <!-- <span class="tooltoggle" id="toolopen"><img src="icons/arrow_down.jpg" alt="" onclick="openTool()"></span>
            <span class="tooltoggle" id="toolclose" onclick="closeTool()"><img src="icons/arrow_up.jpg" alt=""></span> -->
            <a href="..\home\index.php">
                <span class="hometxt">Home</span>
                <i class="fas fa-igloo" id="homeicon"></i>
            </a>
            <div class="clearf"></div>
        </div>
    </header>
    
    <div class="mycontainer">
        <!-- <div class="toolwrapper" id="toolwrapper">
            <div class="toolbar" id="toolbar">
                キーワードで絞り込む
                <input type="text"><br>
                お気に入り
                <i class="fas fa-star"></i>
                身体測定画像
                <i class="fas fa-weight"></i>
                <button id="small_btn">small</button>
                <button id="normal_btn">normal</button>
                <button id="large_btn">large</button>
                
            </div>
            <div></div>
        </div> -->
        <div class="slide_wrapper">
            <span>small</span>
            <input id="slider" class="input-range" type="range" value=2 min=1 max=4 step="1">
            <span>large</span>
        </div>


        <div class="category clearf" data-num = "1">
            <h2>2019 September</h2>
            <!-- <div class="collapseicon"  id="category1">＜＜クリックで開閉＞＞</div> -->
            <!-- <div class="clearf"></div> -->
        </div>

        <div class="photarea">
            <ul>
                 <li class="size_normal">
                    <a href="images/2019-08-25 20.21.00_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="thumbnail.php" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 20.21.00_preview.jpeg" data-lightbox = "lb" ><img class="thumbnails size-nrm" src="thumbnail.php" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.18.27_preview.jpeg" data-lightbox="lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.18.27_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
            </ul>

            <div class="category clearf" data-num = "1">
                <h2>2019 August</h2>
                <div class="collapseicon"  id="category1">＜＜クリックで開閉＞＞</div>
                <div class="clearf"></div>
            </div>

            <ul>
                 <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                 <li class="size_normal">
                    <a href="images/2019-08-25 20.21.00_preview.jpeg" data-lightbox = "lb" ><img class="thumbnails size-nrm" src="images/2019-08-25 20.21.00_preview.jpeg" alt=""></a>
                </li>
                 <li class="size_normal">
                    <a href="images/2019-08-25 17.18.27_preview.jpeg" data-lightbox="lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.18.27_preview.jpeg" alt=""></a>
                </li>
                 <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                 <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                 <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
                <li class="size_normal">
                    <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                </li>
            </ul>
        </div>

        <!-- <div class="photoarea" id="area1">
            <div class="photoframe size-nrm">
                <a href="images/2019-08-25 17.17.20_preview.jpeg" data-lightbox = "lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.17.20_preview.jpeg" alt=""></a>
                <div class="picnote">testnote</div>
            </div>
            <div class="photoframe size-nrm">
                <a href="images/2019-08-25 17.18.27_preview.jpeg" data-lightbox="lb"><img class="thumbnails size-nrm" src="images/2019-08-25 17.18.27_preview.jpeg" alt=""></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="images/2019-08-25 20.21.00_preview.jpeg" data-lightbox = "lb" ><img class="thumbnails size-nrm" src="images/2019-08-25 20.21.00_preview.jpeg" alt=""></a>
                <div class="picnote">testnotetestnoteeeeeeeeddddddddddddddddeeeee</div>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-09-16 15.21.03-3_preview.jpeg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                    <a href="#"><img class="thumbnails" src="images/2019-11-17 08.43.55_preview.jpeg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-11-24 09.17.50_preview.jpeg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-11-30 10.18.58.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-12-15 09.58.10.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-12-15 17.38.19.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-12-15 09.58.38.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-12-31 09.57.18.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2020-05-11 09.43.38.jpg" alt="" loading="lazy"></a>
            </div>
            <div class="clearf"></div> -->
        </div> <!--photoarea-->

        <!-- <div class="photoarea" id="area2">
            <div class="photoframe size-nrm">
                <a href="#"><img class="thumbnails" src="images/2019-11-24 09.18.04_preview.jpeg" alt=""></a>
            </div>
        </div> -->


    </div>
    <script>
        /*
        var target_wr = document.getElementById('toolwrapper');
        var target_bar = document.getElementById('toolbar');
        var target_op = document.getElementById('toolopen');
        var target_cl = document.getElementById('toolclose');
        
        function openTool(){
            target_wr.style.display = 'block';
            target_bar.style.transform.transalteY = 0;
            target_op.style.display = 'none';
            target_cl.style.display = 'block';
        }
        function closeTool(){
            target_wr.style.display = 'none';
            target_bar.style.transform.transalteY = 0;
            target_op.style.display = 'block';
            target_cl.style.display = 'none';
        }

        document.querySelector('#large_btn').addEventListener('click',function(){
            li.forEach(element => {
                element.className='size_large';
            });
        })
        document.querySelector('#normal_btn').addEventListener('click',function(){
            li.forEach(element => {
                element.className='size_normal';
            });
        })
        document.querySelector('#small_btn').addEventListener('click',function(){
            li.forEach(element => {
                element.className='size_small';
            });
        })
        */
        let slider = document.querySelector('#slider').addEventListener('input',function(){
            console.log(this.value);
            let val = Number(this.value);
            let class_changeto = '';
            switch(val){
                case 1:
                    class_changeto = 'size_small'; 
                    break;
                case 2:
                    class_changeto = 'size_normal';
                    break;
                case 3:
                    class_changeto = 'size_large';
                    break;
                case 4:
                    class_changeto = 'size_max';
                    break;
            }
            console.log(class_changeto);
            let li = document.querySelectorAll('li');
            li.forEach(element => {
                element.className=class_changeto;
        })
        })
    </script>
    <script src="main.js"></script>

</body>
</html>
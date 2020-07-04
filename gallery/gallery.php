<?php
    require("../common/php/login_check.php");
    require('../common/php/dbconnect.php');

    $dir = 'images/';
    $files = glob($dir . '*');

    require('php/gallery_main.php');
    
    //TODO:DBからファイル名を取得してHTMLを生成する処理
        //Categoryに入れるYearmonthの降順を1stkeyにすること
        //例によってPHPからJSに配列で渡して処理する（YearmonthごとにBreakすること）

    



    //特定のディレクトリからファイル群を取得
    //それぞれのファイルからファイル名、撮影日などを取得してDBにINSERTする処理
    //
    



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
            <a href="..\home\index.php">
                <span class="hometxt">Home</span>
                <i class="fas fa-igloo" id="homeicon"></i>
            </a>
            <div class="clearf"></div>
        </div>
    </header>
    
    <div class="mycontainer" id="mycontainer">
        <div class="slide_wrapper">
            <span>small</span>
            <input id="slider" class="input-range" type="range" value=2 min=1 max=4 step="1">
            <span>large</span>
        </div>


        <!-- <div class="category clearf" data-num = "1">
            <h2>2019 September</h2>
            
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
                </ul>
            </div>
        </div> -->
    </div>


    <script>
        const db_data = <?php echo $jsondata; ?>;
    </script>
    <script src="main.js"></script>

</body>
</html>
<?php
    require("../common/php/login_check.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <link rel="stylesheet" href="../common/css/reset.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../common/images/favicon/favicon.ico">
    <title>Steve Home</title>
</head>
<body>
    <div class="container">
        <div class="wrapper" onclick="stopEffect()">
            <div class="title">
                <p id="steve">Steve</p>
                <p id="subtitle">t<span class="hero">he</span> to<span class="hero">r</span>t<span class="hero">o</span>ise</p>
            </div>
            <div class="menu" id="menu">
                <ul>
                    <li>
                        <span class="menuicon"><i class="fas fa-camera-retro"></i></span>
                        <span class="menuname"><a href="..\gallery\gallery.php">Gallery</a></span>
                    </li>
                    <li>
                        <span class="menuicon"><i class="fas fa-weight"></i></span>
                        <span class="menuname"><a href="..\health\mesurement.php">Health Data</a></span>
                    </li>
                    <li>
                        <span class="menuicon"><i class="fas fa-thermometer-half"></i></span>
                        <span class="menuname"><a href="../conditions/conditions.php">Cage Conditions</a></span>
                    </li>
                    <li>
                        <span class="menuicon"><i class="fas fa-external-link-alt"></i></span>
                        <span class="menuname"><a href="../Links/links.php">Links</a></span>
                    </li>
                    <li>
                        <span class="menuicon"><i class="fas fa-cog"></i></span>
                        <span class="menuname"><a href="#">Settings</a></span>
                    </li>
                </ul>
            </div>
            <div class="cf"></div>
        </div>
    </div> <!--container-->
    <script>
        var i = 0;
        var y=0;
        var str = 'Steve';
        var is_stopped = false;

        function typeWriter(){
            document.getElementById('steve').innerHTML = str.substr(0,i++);
            if(i <= str.length){
                setTimeout("typeWriter()",600);
            }else{
                setTimeout("subtitleShow()",500);
            }
        }

        function subtitleShow(){
            document.getElementById('subtitle').style.display='block';
            setTimeout("showHero()",1000);
        }

        function showHero(){
            var elm = document.getElementsByClassName('hero');
            for(var x = 0; x<elm.length;x++){
                elm[x].style.color = "rgb(0,170,0)";
            }
            setTimeout("showMenu()",300);
        }
        function showMenu(){
            var elm = document.getElementById('menu');
                if(is_stopped){
                    y=1;
                    elm.style.opacity=y;
                }else{
                y = y + 0.01;
                }
                
                if(y<1){
                elm.style.opacity=y;
                setTimeout("showMenu()",30);
                }
        }
        function stopEffect(){
            is_stopped = true;
            document.getElementById('steve').innerHTML = str;
            document.getElementById('subtitle').style.display='block';
            var elm = document.getElementsByClassName('hero');
            for(var x = 0; x<elm.length;x++){
                elm[x].style.color = "rgb(0,170,0)";
            }
            document.getElementById('menu').style.opacity=1;

        }

        showMenu();
        // stopEffect();
    </script>
</body>
</html>
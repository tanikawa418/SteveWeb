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
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="../common/images/favicon/favicon.ico">
    <title>Steve Home</title>
</head>
<body>
    <div class="mycontainer">
        <div class="mywrapper" onclick="stopEffect()">
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
    </div> <!--mycontainer-->
</body>
</html>
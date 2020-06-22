<?php
    require("../common/php/login_check.php");
    require('../common/php/dbconnect.php');


    //データ取得処理
    $sql = 'SELECT * FROM cage_conditions';
    $response = $db->query($sql,PDO::FETCH_ASSOC);
    $arr_conditions = $response->fetchAll(PDO::FETCH_ASSOC);

    $max_date_str = str_replace('-','/',substr(end($arr_conditions)['date'],0,10));

    // JSに配列渡し
    $jsonData = json_encode($arr_conditions);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../common/css/reset.css">
    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <!-- lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" type="text/javascript" ></script>
    <link rel="stylesheet" href="styles/style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <!-- toastr.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    
    <title>Cage Conditions</title>
</head>
<body>
    <header>
        <div class="headercontainer cf">
        <p>Steve the tortoise</p>
            <h1>Cage Conditions</h1>
        </div>
        <a href="..\home\index.php">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>
        
    </header>
    <div class="mycontainer cf" id="mycontainer">
        <span id="async_msg"></span>
        <button id="reload_btn">Reload</button>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Daily</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Weekly</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <!-- <h2>Daily Data</h2> -->
                <div class="summary graph_wrapper">
                    <button id="prev_btn">Prev</button>
                    <span id="date_d"></span> <!--phpで最大日を設定する -->
                    <button id="next_btn">Next</button>
                    <br>
                    <i class="fas fa-thermometer-half"></i>  Ave : <span class="summary_d" id="tmp_ave"></span>
                ℃ (<span class="summary_d" id="tmp_min"></span>
                -><span class="summary_d" id="tmp_max"></span>)<br>
                <i class="fas fa-tint"></i>  Ave : <span class="summary_d" id="hmd_ave"></span>
                ％ (<span class="summary_d" id="hmd_min"></span>
                -><span class="summary_d" id="hmd_max"></span>)<br>
                <button onclick="tglZoom()">Change View</button>
            </div>
            <div class="graph_wrapper" id="graph_wrapper">
                <canvas id="temp_d" height="400" width="3000"></canvas>
                <canvas id="hmd_d" height="400" width="3000"></canvas>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">This is profile pain.</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">This is cantact pain.</div>
        </div>
        
    </div> <!--mycontainer -->

    <script>
    //PHPからのデータ授受
        const conditionData = <?php echo $jsonData; ?>;
        console.log(conditionData[conditionData.length -1]['date']);
    </script>
    <script src="js/graph.js"></script>
    <script src="js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>



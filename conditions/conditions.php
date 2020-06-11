<?php
require("../common/php/login_check.php");
require('../common/php/dbconnect.php');


//データ取得処理
$sql = 'SELECT * FROM cage_conditions';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_conditions = $response->fetchAll(PDO::FETCH_ASSOC);

// JSに配列渡し
$jsonData = json_encode($arr_conditions);
// print_r($jsonData);

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
    <link rel="stylesheet" href="style.css?dummy">

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
                <h2>Daily Data</h2>
                <div class="summary graph_wrapper">
                <p id="date_d">2020/06/09</p> <!--phpで最大日を設定する -->
                    Ave : 29.8 <br>
                    Max : 32.3 <br>
                    Min : 27.4 <br>
                    <button onclick="tglZoom()">Zoom Change</button>
                </div>
                <div class="graph_wrapper" id="graph_wrapper">
                    <canvas id="temp_d" height="400" width="2200"></canvas>
                <!-- </div> -->
                <!-- <div class="graph_wrapper"> -->
                    <canvas id="hmd_d" height="400" width="2200"></canvas>
                </div>
                <button id="randomizeData">Randomize Data</button>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">This is profile pain.</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">This is cantact pain.</div>
        </div>



        
    </div> <!--mycontainer -->

    
    <script type="text/javascript">
    //各グラフ領域の高さ設定
    var graphHeight = 350;
    var graphWidth = 3000;
 
    //PHPからのデータ授受
    var conditionData = <?php echo $jsonData; ?>;
    // console.log(conditionData);

    //htmlから基準日を取得
    var mydate = new Date(document.getElementById('date_d').innerHTML);

    //指定日付のデータをtmp_dataに格納する
    var tmp_data={};
    var hmd_data={};
    for(var i = 0; i<conditionData.length; i++){
        var cond_date = new Date(conditionData[i]['date']);
        if(mydate.getDate() - cond_date.getDate() == 0){
            var mytime = ('0' + cond_date.getHours()).slice(-2)+':'+('0' + cond_date.getMinutes()).slice(-2);
            //日付=>温度 の連想配列として格納
            tmp_data[mytime] = conditionData[i]['temperature'];
            //日付=>湿度 の連想配列として格納
            hmd_data[mytime] = conditionData[i]['humidity'];
        }
    }

    //X軸ラベル用の配列を生成（00:00,...,23:50)
    var mylabels = [];
    for(var h = 0; h<24; h++){
        for(var m = 0; m<60; m +=10){
            mylabels.push(('0' + h).slice(-2) + ':' + ('0' + m).slice(-2));
        }
    }
    
    //X軸ラベルと等しいデータを連想配列tmp_dataから取得し新しい配列に格納する
    var tmp_graph_data = [];
    var hmd_graph_data = [];
    for(var x = 0; x<mylabels.length; x++){
        var lab_time = mylabels[x];
        tmp_graph_data[x] = null; //データ欠損に備えて、要素を作っておき、Nullを入れておく
        if(tmp_data[lab_time]){
            tmp_graph_data[x] = tmp_data[lab_time];
            hmd_graph_data[x] = hmd_data[lab_time];
        }
    }

    //Responsiveモードの既定値
    var isResponsive = false;

    //Zoomボタンによるグラフ幅の切り替え処理
    function tglZoom(){
        if(isResponsive){
            isResponsive = false;
            // document.getElementById('temp_d').setAttribute('width','3000');
            // document.getElementById('hmd_d').setAttribute('width','3000');
        }else{
            isResponsive = true;
            // var wrapper_w = document.getElementById('graph_wrapper').clientWidth;
            // document.getElementById('temp_d').setAttribute('width',wrapper_w * 0.9);
            // document.getElementById('hmd_d').setAttribute('width',wrapper_w * 0.9);
        }
        // if (myChart_t) {
        //             console.log('destroy');
        //             myChart_t.destroy();
        //         }

            drawTmpGraph();
            drawHmdGraph();
    }

    //ウィンドウのリサイズによるグラフ幅の切り替え処理（Responsive時のみ再描画）
    var resizeTimer; 
    window.addEventListener('resize', function (event) {
        //タイマー設定中に呼び出された場合はタイマーを振り出しに戻す
        if (resizeTimer !== false) {
            clearTimeout(resizeTimer);
        }
        //タイムアウトした時の処理
        resizeTimer = setTimeout(function () {
            if(isResponsive){
                drawTmpGraph();
                drawHmdGraph();
            }
        }, 500);
    });
    
    //Temperature graphの描画
    var lineChartData_temp = {
        labels: mylabels,
        datasets: [{
            label: '温度',
            fill: false,
            data: tmp_graph_data,
            yAxisID: 'y-axis-1',
            spanGaps:true, //欠損データ対応
            // lineTension:0.8
        }]
    };

    function drawTmpGraph(){
        //同一のCanvasに再描画した時に前のインスタンスが残存してるので要素ごと再作成する
        //   https://stackoverflow.com/questions/40056555/destroy-chart-js-bar-graph-to-redraw-other-graph-in-same-canvas
        document.getElementById('temp_d').remove();
        document.getElementById('hmd_d').remove();
        document.getElementById('graph_wrapper').innerHTML = '<canvas id="temp_d" height="400" width="2200"></canvas><canvas id="hmd_d" height="400" width="2200"></canvas>';


        if(isResponsive){
            var wrapper_w = document.getElementById('graph_wrapper').clientWidth;
            document.getElementById('temp_d').setAttribute('width',wrapper_w * 0.9);
            document.getElementById('hmd_d').setAttribute('width',wrapper_w * 0.9);
        }else{
            document.getElementById('temp_d').setAttribute('width',3000);
            document.getElementById('hmd_d').setAttribute('width',3000);
        }


        var ctx_t = document.getElementById('temp_d').getContext('2d');
        ctx_t.canvas.height = graphHeight;

        window.myLine = Chart.Line(ctx_t, {
        // window.myChart_t = new Chart.Line(ctx_t,{
            data: lineChartData_temp,
            options: {
                responsive: false,
                maintainAspectRatio: false,
                hoverMode: 'index',
                // showTooltips: false,
                stacked: false,
                title: {
                    display: true,
                    text: 'Temperature  - 温度 -'
                },
                scales: {
                    yAxes: [{
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        suggestedMax:28,
                        // beginAtZero:true,
                        display: true,
                        ticks: {
                            beginAtZero: false,
                            min: 25,
                            max: 35
                        },
                        position: 'left',
                        id: 'y-axis-1'
                    }]
                }
            }
        });
    }

    // window.onload = function() {
        window.addEventListener("load",function(){
            drawTmpGraph();
            drawHmdGraph();
    },false)
    

    //Humidity graphの描画
    var lineChartData_hmd = {
        labels: mylabels,
        datasets: [{
            label: '湿度',
            fill: false,
            data: hmd_graph_data,
            yAxisID: 'y-axis-1',
            spanGaps:true, //欠損データ対応
            // lineTension:0.8
        }]
    };

    // lineChartData_hmd['datasets'][0]['data'] = hmd_graph_data;
    // lineChartData_hmd['labels'] = mylabels;


    // var xAxisWidthUnit = 20;
    // var graphWidth = 3000; = xAxisWidthUnit * hmd_graph_data.length;
    // console.log(graphWidth = 3000;);

    // document.getElementById('temp_d').style.width = graphWidth = 3000; + 'px';
    // document.getElementById('temp_d').style.width = '1500px';
    // document.getElementById('temp_d').style.height = '800px';

    // window.onload = function() {

    function drawHmdGraph(){
        // window.addEventListener("load",function(){

        var ctx_h = document.getElementById('hmd_d').getContext('2d');
        ctx_h.canvas.height = graphHeight;
        window.myLine = Chart.Line(ctx_h, {
            data: lineChartData_hmd,
            options: {
                responsive: false,
                maintainAspectRatio: false,
                hoverMode: 'index',
                stacked: false,
                title: {
                    display: true,
                    text: 'Cage Conditions  - Daily -'
                },
                scales: {
                    yAxes: [{
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        suggestedMax:28,
                        beginAtZero:true,
                        display: true,
                        ticks: {
                            beginAtZero: false,
                            min: 30,
                            max: 70
                        },
                        position: 'left',
                        id: 'y-axis-1'
                    }]
                }
            }
        });
    }

 
    </script>
        
        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>



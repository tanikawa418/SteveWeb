<?php
require("../common/php/login_check.php");
require('../common/php/dbconnect.php');


//データ取得処理
$sql = 'SELECT * FROM cage_conditions';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_conditions = $response->fetchAll(PDO::FETCH_ASSOC);

// print_r(str_replace('-','/',substr(end($arr_conditions)['date'],0,10)));

$max_date_str = str_replace('-','/',substr(end($arr_conditions)['date'],0,10));

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
        <button id="reload_btn" onclick="location.reload(true)">Reload</button>
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
                    <button onclick="changeDate(-1)">Prev</button>
                    <span id="date_d"><?php echo $max_date_str ?></span> <!--phpで最大日を設定する -->
                    <button onclick="changeDate(1)">Next</button>
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

    
    <script type="text/javascript">
    //各グラフ領域のサイズ設定
    var graphHeight = 350; //共通
    var graphWidth = 3000; //非レスポンシブの時の横幅
    //Responsiveモードの既定値
    var isResponsive = true;
 
    //PHPからのデータ授受
    var conditionData = <?php echo $jsonData; ?>;

    //時刻のパターン文字列配列を生成（00:00,...,23:50)
    var timePattern = [];
    for(var h = 0; h<24; h++){
        for(var m = 0; m<60; m +=10){
            timePattern.push(('0' + h).slice(-2) + ':' + ('0' + m).slice(-2));
        }
    }


    //基準日のデータを格納する配列の定義
    var tmp_data={};
    var hmd_data={};

    //欠損データ対応済みのグラフ基礎データ配列
    var tmp_graph_data = [];
    var hmd_graph_data = [];

    function createData(){
        //htmlから基準日を取得
        var mydate = new Date(document.getElementById('date_d').innerHTML);

        //初期化
        tmp_data={};
        hmd_data={};

        //指定日付のデータをtmp_dataに格納する
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

        //初期化
        tmp_graph_data = [];
        hmd_graph_data = [];
        var tmp_sum = 0;
        var hmd_sum = 0;
        var counter = 0;
        var tmp_max = 0;
        var hmd_max = 0;
        var tmp_min = 100;
        var hmd_min = 100;
        
        //時刻パターンと等しいデータを連想配列tmp_dataから取得し新しい配列に格納する
        for(var x = 0; x<timePattern.length; x++){
            var lab_time = timePattern[x];
            tmp_graph_data[x] = null; //データ欠損に備えて、Nullで要素を作っておく
            if(tmp_data[lab_time]){
                tmp_graph_data[x] = tmp_data[lab_time];
                hmd_graph_data[x] = hmd_data[lab_time];
                console.log(tmp_data[lab_time]);
                tmp_sum += Number(tmp_data[lab_time]);
                hmd_sum += Number(hmd_data[lab_time]);
                counter += 1;
                tmp_max = Math.max(tmp_max,Number(tmp_data[lab_time]));
                hmd_max = Math.max(hmd_max,Number(hmd_data[lab_time]));
                tmp_min = Math.min(tmp_min,Number(tmp_data[lab_time]));
                hmd_min = Math.min(hmd_min,Number(hmd_data[lab_time]));
            }
        }
        var myAve_tmp = Math.round(tmp_sum / counter * 100) / 100;
        var myAve_hmd = Math.round(hmd_sum / counter * 100) / 100;
        if(counter){
            document.getElementById('tmp_ave').innerHTML = myAve_tmp.toFixed(2);
            document.getElementById('tmp_max').innerHTML = tmp_max.toFixed(2);
            document.getElementById('tmp_min').innerHTML = tmp_min.toFixed(2);
            document.getElementById('hmd_ave').innerHTML = myAve_hmd.toFixed(2);
            document.getElementById('hmd_max').innerHTML = hmd_max.toFixed(2);
            document.getElementById('hmd_min').innerHTML = hmd_min.toFixed(2);
        }else{
            document.getElementById('tmp_ave').innerHTML = '-';
            document.getElementById('tmp_max').innerHTML = '-';
            document.getElementById('tmp_min').innerHTML = '-';
            document.getElementById('hmd_ave').innerHTML = '-';
            document.getElementById('hmd_max').innerHTML = '-';
            document.getElementById('hmd_min').innerHTML = '-';

        }
    }


    //X軸ラベル用の配列を生成
    Xlabels = [];
    for(var h = 0; h<24; h++){
        for(var m = 0; m<60; m += 10){
            if(m == 0){
                Xlabels.push(h + ':00');
            }else{
                Xlabels.push('');
            }
        }
    }

    //Zoomボタンによるグラフ幅の切り替え処理
    function tglZoom(){
        if(isResponsive){
            isResponsive = false;
        }else{
            isResponsive = true;
        }
            drawGraph();
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
                drawGraph();
            }
        }, 500);
    });
    

    //グラフ描画処理
    function drawGraph(){
        //同一のCanvasに再描画した時に前のインスタンスが残存してるので要素ごと再作成する
        //   https://stackoverflow.com/questions/40056555/destroy-chart-js-bar-graph-to-redraw-other-graph-in-same-canvas
        document.getElementById('temp_d').remove();
        document.getElementById('hmd_d').remove();
        document.getElementById('graph_wrapper').innerHTML = '<canvas id="temp_d" height="400" width="2200"></canvas><canvas id="hmd_d" height="400" width="2200"></canvas>';

        //レスポンシブモードに合わせて要素サイズを変更
        if(isResponsive){
            var wrapper_w = document.getElementById('graph_wrapper').clientWidth;
            document.getElementById('temp_d').setAttribute('width',wrapper_w * 0.9);
            document.getElementById('hmd_d').setAttribute('width',wrapper_w * 0.9);
        }else{
            document.getElementById('temp_d').setAttribute('width',3000);
            document.getElementById('hmd_d').setAttribute('width',3000);
        }

        //Temperature graphの描画設定
        var lineChartData_temp = {
            labels: Xlabels,
            datasets: [{
                label: '温度',
                fill: false,
                data: tmp_graph_data,
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
            }]
        };

        //Humidity graphの描画設定
        var lineChartData_hmd = {
            labels: Xlabels,
            datasets: [{
                label: '湿度',
                fill: false,
                data: hmd_graph_data,
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
            }]
        };

        //TemperatureGraphの描画処理
        var ctx_t = document.getElementById('temp_d').getContext('2d');
        ctx_t.canvas.height = graphHeight;

        window.myLine = Chart.Line(ctx_t, {
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

        //HumidityGraphの描画処理
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
                    text: '湿度'
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

    //初期表示
    window.addEventListener("load",function(){

        var req = new XMLHttpRequest();
        req.onreadystatechange = function() {
        var result = document.getElementById('async_msg');
            // if (req.readyState == 4) { // 通信の完了時
            //     if (req.status == 200) { // 通信の成功時
            //     var myresult = JSON.parse(req.responseText);
            //     result.innerHTML = req.response;
            //     result.innerHTML = myresult['res_msg'];
            //     }
            // }else{
            //     result.innerHTML = "Loading new data...";
            // }

            if(req.readyState != 4){
                result.innerHTML = 'Checking new data...';
            }else{
                if(req.status == 200){
                    var myresult = JSON.parse(req.responseText);
                    result.innerHTML = req.response;
                    result.innerHTML = myresult['res_msg'];
                    var is_added = myresult['success'];
                    if(is_added > 0){
                        document.getElementById('reload_btn').style.display = 'inline-block';
                    }else{
                        // setTimeout(document.getElementById('async_msg').style.visibility = 'hidden',500);
                        // setTimeout(document.getElementById('async_msg').innerHTML = 'hohoho',20010);
                    }
                }else{
                    result.innerHTML = 'Bad request.';
                }
            }
        }
        req.open('POST', 'load_csv.php',true);
        req.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        req.send(1);

        createData();
        drawGraph();
    },false)

    function changeDate(n){
        var target_date = new Date(document.getElementById('date_d').innerHTML);
            target_date.setDate(target_date.getDate() + n);
        
        var newDateStr = createDateStr(target_date);
        document.getElementById('date_d').innerHTML = newDateStr;

        createData();
        drawGraph();
    }

    function createDateStr(date){
        var year_str = date.getFullYear();
        var month_str = 1 + date.getMonth();
        var day_str = date.getDate();

        month_str = ('0' + month_str).slice(-2);
        day_str = ('0' + day_str).slice(-2);
        
        format_str = 'YYYY/MM/DD';
        format_str = format_str.replace(/YYYY/g, year_str);
        format_str = format_str.replace(/MM/g, month_str);
        format_str = format_str.replace(/DD/g, day_str);
    
        return format_str;
    }
    </script>
        
        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>



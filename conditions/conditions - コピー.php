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
                    Ave : 29.8 <br>
                    Max : 32.3 <br>
                    Min : 27.4 <br>
                </div>
                <div class="graph_wrapper">
                    <canvas id="temp_d"></canvas>
                </div>
                <div class="graph_wrapper">
                    <canvas id="hmd_d"></canvas>
                </div>
                <button id="randomizeData">Randomize Data</button>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">This is profile pain.</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">This is cantact pain.</div>
        </div>



        
    </div> <!--mycontainer -->

    
    <script type="text/javascript">

    var conditionData = <?php echo $jsonData; ?>;
    console.log(conditionData);
    console.log(conditionData.length);

    var add_tmp=[];
    for(var i = 0; i<conditionData.length; i++){
        add_tmp[i] = conditionData[i]['temperature'];
    }
    console.log(add_tmp);

    var add_hmd=[];
    for(var i = 0; i<conditionData.length; i++){
        add_hmd[i] = conditionData[i]['humidity'];
    }


	// var randomScalingFactor = function() {
    //     return (28 + Math.ceil(Math.random() * 5) - Math.ceil(Math.random() * 5));
	// 	// return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
	// };
    var lineChartData_temp = {
        labels: ['0','3','6', '9', '12', '15', '18', '21','0','3','6', '9', '12', '15', '18', '21','0','3','6', '9', '12', '15', '18', '21','0','3','6', '9', '12', '15', '18', '21'],

        datasets: [{
            label: '温度（左の目盛）',
            // borderColor: window.chartColors.red,
            // backgroundColor: window.chartColors.red,
            fill: false,
            data: [],
            yAxisID: 'y-axis-1',
        }
        // , {

        // label: '湿度（右の目盛）',
        //     // borderColor: window.chartColors.blue,
        //     // backgroundColor: window.chartColors.blue,
        // fill: false,
        // data: [
        // ],

        // yAxisID: 'y-axis-2'
        // }
        ]
    };

    lineChartData_temp['datasets'][0]['data'] = add_tmp;

    // lineChartData_temp['datasets'][1]['data'] = add_hmd;


        // console.log(lineChartData_temp);
    window.onload = function() {
        var ctx = document.getElementById('temp_d').getContext('2d');
        window.myLine = Chart.Line(ctx, {
            data: lineChartData_temp,
            options: {
                responsive: true,
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
                            min: 15,
                            max: 35
                        },
                        position: 'left',
                        id: 'y-axis-1'
                    }
                    // , {
                    //     type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    //     suggestedMax:28,
                    //     beginAtZero:true,

                    //     display: true,
                    //     ticks: {
                    //         beginAtZero: false,
                    //         min: 30,
                    //         max: 100
                    //     },

                    //     position: 'right',
                    //     id: 'y-axis-2',

                    //     // grid line settings
                    //     gridLines: {
                    //         drawOnChartArea: false, // only want the grid lines for one axis to show up
                    //     }
                    // }
                    ]
                }
            }
        });
    };

    // document.getElementById('randomizeData').addEventListener('click', function() {
    //     lineChartData_temp.datasets.forEach(function(dataset) {
    //         dataset.data = dataset.data.map(function() {
    //             return randomScalingFactor();
    //         });
    //     });

    //     window.myLine.update();
    // });

 
    </script>
        

        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>



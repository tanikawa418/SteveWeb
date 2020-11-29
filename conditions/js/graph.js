    //各グラフ領域のサイズ設定
    var graphHeight = 350; //共通
    var graphWidth = 3000; //非レスポンシブの時の横幅
    //Responsiveモードの既定値
    var isResponsive = true;
 

    //時刻のパターン文字列配列を生成（00:00,...,23:50)
    var timePattern = [];
    for(var h = 0; h<24; h++){
        for(var m = 0; m<60; m +=10){
            timePattern.push(('0' + h).slice(-2) + ':' + ('0' + m).slice(-2));
        }
    }


    //基準日のデータを格納するobject定義
    var tmp_data={};
    var hmd_data={};
    
    // TODO:configにdevice_nameを登録し、それをキーに異なる配列を作れるようにする。
    
    //欠損データ対応済みのグラフ基礎データ配列の定義
    var tmp_graph_data = [];
    var hmd_graph_data = [];
    
    
    
    function createData(){
        devices = ['Hot Light','Shelter'];
        
        //DOMから基準日を取得
        var mydate = new Date(document.getElementById('date_d').innerHTML);
        
        
        
        
        //初期化
        tmp_data={};
        hmd_data={};
        tmp_graph_data = [];
        // tmp_graph_data2 = [];
        hmd_graph_data = [];
        
        console.log('foreach開始');
        device_num = 0;
        
        devices.forEach(dvc_name => {
            console.log('name : ' + dvc_name);
            console.log('1device_num = ' + device_num);
            
            
            //指定日付のデータをtmp_dataに格納する
            for(var i = 0; i<conditionData.length; i++){
                var cond_date = new Date(conditionData[i]['date']);
                // console.log('(conditionData[i]["device_name"] , dvc_name) = ' + conditionData[i]['device_name'] + ' , ' + dvc_name);
                if(mydate.toDateString() == cond_date.toDateString() && conditionData[i]['device_name']==dvc_name){
                    console.log(mydate.toDateString() + cond_date.toDateString());
                    var mytime = ('0' + cond_date.getHours()).slice(-2)+':'+('0' + cond_date.getMinutes()).slice(-2);
                    //日付=>温度 の連想配列として格納
                    tmp_data[mytime] = conditionData[i]['temperature'];
                    //日付=>湿度 の連想配列として格納
                    hmd_data[mytime] = conditionData[i]['humidity'];
                }
            }
            //初期化
            var tmp_sum = 0;
            var hmd_sum = 0;
            var counter = 0;
            var tmp_max = 0;
            var hmd_max = 0;
            var tmp_min = 100;
            var hmd_min = 100;
            
            console.log('graph_data[' + device_num + ']を初期化します');
            tmp_graph_data[device_num] = [];
            hmd_graph_data[device_num] = [];
            
            //時刻パターンと等しいデータを連想配列tmp_dataから取得し新しい配列に格納する
            for(var x = 0; x<timePattern.length; x++){
                var lab_time = timePattern[x];
                tmp_graph_data[device_num][x] = null; //データ欠損に備えて、Nullで要素を作っておく
                // tmp_graph_data2[device_num][x] = null; //データ欠損に備えて、Nullで要素を作っておく
                if(tmp_data[lab_time]){
                    tmp_graph_data[device_num][x] = tmp_data[lab_time];
                    // tmp_graph_data2[device_num][x] = tmp_data[lab_time]-1;
                    hmd_graph_data[device_num][x] = hmd_data[lab_time];
                    // console.log(tmp_data[lab_time]);
                    tmp_sum += Number(tmp_data[lab_time]);
                    hmd_sum += Number(hmd_data[lab_time]);
                    counter += 1;
                    tmp_max = Math.max(tmp_max,Number(tmp_data[lab_time]));
                    hmd_max = Math.max(hmd_max,Number(hmd_data[lab_time]));
                    tmp_min = Math.min(tmp_min,Number(tmp_data[lab_time]));
                    hmd_min = Math.min(hmd_min,Number(hmd_data[lab_time]));
                }
            }
            console.log('graph_data[' + device_num + ']設定完了');
            console.log(tmp_graph_data[device_num]);
            
            
            var myAve_tmp = Math.round(tmp_sum / counter * 100) / 100;
            var myAve_hmd = Math.round(hmd_sum / counter * 100) / 100;
            
            if(counter){
                //グラフ上部のstatsを削除(日付移動のたびに増殖してしまうため)
                old_summary = document.querySelector('#device' + device_num);
                if(old_summary){
                    old_summary.remove();
                }
                

                summary = document.createElement('div');
                summary.id = 'device' + device_num;
                summary.className = 'device_summary';
                
                summary.innerHTML =  dvc_name + '<br>';
                summary.innerHTML += '<i class="fas fa-thermometer-half"></i>  Ave : <span class="summary_d" id="tmp_ave">';
                summary.innerHTML += myAve_tmp.toFixed(2);
                summary.innerHTML += '</span>℃ (<span class="summary_d" id="tmp_min">';
                summary.innerHTML += tmp_min.toFixed(2);
                summary.innerHTML += '</span>-><span class="summary_d" id="tmp_max">';
                summary.innerHTML += tmp_max.toFixed(2);
                summary.innerHTML += '</span>)<br>';
                summary.innerHTML += '<i class="fas fa-tint"></i>  Ave : <span class="summary_d" id="hmd_ave">';
                summary.innerHTML += myAve_hmd.toFixed(2);
                summary.innerHTML += '</span>％ (<span class="summary_d" id="hmd_min">';
                summary.innerHTML += hmd_min.toFixed(2);
                summary.innerHTML += '</span>-><span class="summary_d" id="hmd_max">';
                summary.innerHTML += hmd_max.toFixed(2);
                summary.innerHTML += '</span>)';
                
                
        
                wrapper = document.querySelector('#stats_wrapper');
                wrapper.appendChild(summary);

                

                // document.getElementById('tmp_ave').innerHTML = myAve_tmp.toFixed(2);
                // document.getElementById('tmp_max').innerHTML = tmp_max.toFixed(2);
                // document.getElementById('tmp_min').innerHTML = tmp_min.toFixed(2);
                // document.getElementById('hmd_ave').innerHTML = myAve_hmd.toFixed(2);
                // document.getElementById('hmd_max').innerHTML = hmd_max.toFixed(2);
                // document.getElementById('hmd_min').innerHTML = hmd_min.toFixed(2);
            }else{
                document.getElementById('tmp_ave').innerHTML = '-';
                document.getElementById('tmp_max').innerHTML = '-';
                document.getElementById('tmp_min').innerHTML = '-';
                document.getElementById('hmd_ave').innerHTML = '-';
                document.getElementById('hmd_max').innerHTML = '-';
                document.getElementById('hmd_min').innerHTML = '-';
                
            }
            device_num++;
            console.log('device_num = ' + device_num);
        })
    }
    
    
    //X軸ラベル用の配列を生成（10分単位では細かすぎるのでラベルは1hごとにする
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
                label: devices[0],
                fill: false,
                data: tmp_graph_data[0],
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
                backgroundColor: "rgba(180,50,50,0.4)",
                borderColor: "rgba(230,120,120,1)"
            },{
                label: devices[1],
                fill: false,
                data: tmp_graph_data[1],
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
                backgroundColor: "rgba(50,180,50,0.4)",
                borderColor: "rgba(120,230,120,1)"
            }]
        };

        //Humidity graphの描画設定
        var lineChartData_hmd = {
            labels: Xlabels,
            datasets: [{
                label: devices[0],
                fill: false,
                data: hmd_graph_data[0],
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
                backgroundColor: "rgba(180,50,50,0.4)",
                borderColor: "rgba(230,120,120,1)"
            },{
                label: devices[1],
                fill: false,
                data: hmd_graph_data[1],
                yAxisID: 'y-axis-1',
                spanGaps:true, //欠損データ対応
                // lineTension:0.8
                backgroundColor: "rgba(50,180,50,0.4)",
                borderColor: "rgba(120,230,120,1)"
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
                    text: 'Humidity　- 湿度'
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


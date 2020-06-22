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


//非同期データ更新処理
window.addEventListener("load",function(){
    //asyncによるNewData更新処理
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
    var result = document.getElementById('async_msg');
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


//Prev,Nextボタン押下時の処理
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

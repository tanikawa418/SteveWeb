// alert("hello");

// *****************************
// 画像ファイルサイズの変更
// *****************************

var picSizeElms = document.getElementsByName("options");

function getSize(){
    for (var i = 0; i < picSizeElms.length; i++){
        if (picSizeElms[i].checked){
            return i;
            }
    }
}

// 押されたボタン位置とクラス名の関連付け
var picSetting = {0:"size-lg", 1:"size-nrm", 2:"size-sm"};

var changeSize = function(){
    var curSize = getSize();
    var elm = document.getElementsByClassName("photoframe");
    for(var i = 0; i < elm.length; i++){
        elm[i].className = "photoframe " + picSetting[curSize];
    }
}
document.getElementById("picsize").onchange = changeSize;


// *****************************
// Collapse
// *****************************

var collapseTarget = document.getElementsByClassName("category");
console.log(collapseTarget.length);

for(var i = 0; i < collapseTarget.length; i++){
    collapseTarget[i].addEventListener('click',function(){
        console.log(this.dataset.num);
        if(document.getElementById("area" + this.dataset.num).style.display == "none"){
            document.getElementById("area" + this.dataset.num).style.display = "block";
        }else{
            document.getElementById("area" + this.dataset.num).style.display = "none";
        }
    })
}




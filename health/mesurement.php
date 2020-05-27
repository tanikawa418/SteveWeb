<?php

require('../common/php/dbconnect.php');


//削除ボタン押下時処理
if(!empty($_POST) && $_POST['mode']='delete'){
    
    //pic_filenameの取得
    $sql = 'SELECT * FROM mesurement WHERE mesurement_id=?';
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_POST['mesurement_id']));
    $response = $stmt->fetch();
    $delete_filename = $response['pic_filename'];
    
    // DB Delete
    $sql = 'DELETE FROM mesurement WHERE mesurement_id=?';
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_POST['mesurement_id']));
    $result_db_delete = $stmt->rowCount();
    
    //File Delete
    if(unlink('images/mesurement_pics/' . $delete_filename)){
        $result_file_delete = 1;
    }else{
        $result_file_delete = 0;
    }
    
    //トーストメッセージの作成
    if(isset($result_db_delete)){
        if($result_db_delete==1){
            $toast_message_db = 'データを削除しました';
            $toast_type_db = 'success';
        }else{
            $toast_message_db = 'データ削除に失敗しました';
            $toast_type_db = 'error';
        }
        if($result_file_delete==1){
            $toast_message_file = '画像を削除しました';
            $toast_type_file = 'success';
        }else{
            $toast_message_file = '画像削除に失敗しました';
            $toast_type_file = 'error';
        }




    }
    
}

//データ取得処理
$sql = 'SELECT * FROM mesurement ms INNER JOIN pets pt ON pt.pet_id = ms.pet_id ORDER BY ms.created DESC';
$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_health = $response->fetchAll(PDO::FETCH_ASSOC);
// JSに配列渡し
$jsonData = json_encode($arr_health);


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


    


    <title>Health Data</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            Health Data
        </div>
        <a href="..\home\index.html">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>

    </header>
    <div class="mycontainer cf" id="mycontainer">
        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="images/mesurement_pics/20200522174522PC040677.jpg" data-lightbox = "lb"><img class="thumbnails" src="images/mesurement_pics/20200522174522PC040677.jpg" alt=""></a>
            </div>
            <div class="cardright">
                <div class="cardheader cf">
                    <div class="carddate">2019/8/25</div>
                    <div class="cardprofile">
                        <div class="profile_pic_frame">
                            
                            <img src="#" alt="">
                        </div>
                        <span>Steve1世</span>
                    </div>
                </div>
                <div class="cardcontents cf">
                    <div class="carddata">
                        <table>
                            <tr>
                                <th>体重</th>
                                <td>109.3 g</td>
                            </tr>
                            <tr>
                                <th>長さ</th>
                                <td>10.4 cm</td>
                            </tr>
                            <tr>
                                <th>幅</th>
                                <td>7.4 cm</td>
                            </tr>
                            <tr>
                                <th>高さ</th>
                                <td>- cm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="cardnotes">
                        静的生成のカードです
                    </div>
                    <div class="action">
                        <div class="iconwrap">
                            <!-- <a href="input/mesurement_input.php?mode=edit"><i class="fas fa-edit"></i></a> -->
                            <form action="input/mesurement_input.php" method="post">
                                <input type="hidden" name="mode" value="edit">
                                <input type="hidden" name="mesurement_id" value="23">
                                <label>
                                    <button type="submit" class="hidden_btn">隠しボタン</button>
                                    <i class="fas fa-edit"></i>
                                </label>
                                
                            </form>
                        </div>

                        <div class="iconwrap">
                            <form action="" onsubmit="return deleteConfirm()" method="post">
                                <input type="hidden" name="mesurement_id" value="57">
                                <input type="hidden" name="mode" value="delete">
                                <label>
                                    <button type="submit" class="hidden_btn">隠しボタン</button>
                                    <i class="far fa-trash-alt"></i>
                                </label>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="addmark">
            <a href="input/mesurement_input.php"><i class="fas fa-plus"></i></a>    
        </div>
        
    </div> <!--mycontainer -->

    
    <script type="text/javascript">

        function healthDataMark(){
            var healthData = <?php echo $jsonData; ?>;
            console.log(healthData);

            for(var i = 0; i<healthData.length; i++){
                var myCard = document.createElement('div');
                myCard.className = 'card cf';

                var myCardLeft = document.createElement('div');
                myCardLeft.className = 'cardleft';
                var fileName = healthData[i]['pic_filename'];
                myCardLeft.innerHTML ='<a href="images/mesurement_pics/' + fileName + '" data-lightbox = "lb"><img class="thumbnails" src="images/mesurement_pics/' + fileName + '" alt=""></a>';
                
                var myCardRight = document.createElement('div');
                myCardRight.className = 'cardright';

                    var myCardHeader = document.createElement('div');
                    myCardHeader.className = 'cardheader cf';

                        var myCardDate = document.createElement('div');
                        myCardDate.className = 'carddate';
                        myCardDate.innerHTML = healthData[i]['date'];

                        var myCardProfile = document.createElement('div');
                        myCardProfile.className = 'cardprofile';

                            var myProfilePicFrame =document.createElement('div');
                            myProfilePicFrame.className = 'profile_pic_frame';
                            myProfilePicFrame.style.background = 'url(../common/images/profile/' + healthData[i]['profile_filename'] + ') no-repeat';
                            myProfilePicFrame.style.backgroundPosition = 'center';
                            myProfilePicFrame.style.backgroundSize = 'cover';

                        myCardProfile.appendChild(myProfilePicFrame);

                    myCardHeader.appendChild(myCardDate);
                    myCardHeader.appendChild(myCardProfile);

                    var myCardContents = document.createElement('div');
                    myCardContents.className = 'cardcontents';

                        var myCardData = document.createElement('div');
                            myCardData.className = 'carddata';
                            var myTable = document.createElement('table');
                                var tableStr = "";
                                tableStr += '<tr>';
                                tableStr += '<th>体重</>';
                                tableStr += '<td class="tdData">';
                                tableStr += healthData[i]['weight'];
                                tableStr += '</td>';
                                tableStr += '<td class="tdUnit">g</td>';
                                tableStr += '</tr>'

                                tableStr += '<tr>';
                                tableStr += '<th>長さ</>';
                                tableStr += '<td class="tdData">';
                                tableStr += healthData[i]['vertical'];
                                tableStr += '</td>';
                                tableStr += '<td class="tdUnit">cm</td>';
                                tableStr += '</tr>'

                                tableStr += '<tr>';
                                tableStr += '<th>幅</>';
                                tableStr += '<td class="tdData">';
                                tableStr += healthData[i]['horizontal'];
                                tableStr += '</td>';
                                tableStr += '<td class="tdUnit">cm</td>';
                                tableStr += '</tr>'

                                tableStr += '<tr>';
                                tableStr += '<th>高さ</>';
                                tableStr += '<td class="tdData">';
                                tableStr += healthData[i]['height'];
                                tableStr += '</td>';
                                tableStr += '<td class="tdUnit">cm</td>';
                                tableStr += '</tr>'

                            myTable.innerHTML = tableStr;

                        myCardData.appendChild(myTable);

                        var myCardnotes = document.createElement('div');
                            myCardnotes.className = 'cardnotes';
                        myCardnotes.innerHTML = healthData[i]['note'];

                        var myAction = document.createElement('div');
                            myAction.className = 'action';
                                var myiconwrap1 = document.createElement('div');
                                    myiconwrap1.className = 'iconwrap';

                                    var formStr = "";
                                    formStr += '<form action="input/mesurement_input.php" method="post">';
                                    formStr += '<input type="hidden" name="mode" value="edit">';
                                    formStr += '<input type="hidden" name="mesurement_id" value="';
                                    formStr += healthData[i]['mesurement_id'];
                                    formStr += '">';
                                    formStr += '<label>';
                                    formStr += '<button type="submit" class="hidden_btn">隠しボタン</button>';
                                    formStr += '<i class="fas fa-edit"></i>';
                                    formStr += '</label>';
                                    formStr += '</form>';
                                myiconwrap1.innerHTML = formStr;

                                var myiconwrap2 = document.createElement('div');
                                    myiconwrap2.className = 'iconwrap';
                                myiconwrap2.innerHTML = '<i class="far fa-trash-alt"></i>';
                            myAction.appendChild(myiconwrap1);
                            myAction.appendChild(myiconwrap2);

                    myCardContents.appendChild(myCardData);
                    myCardContents.appendChild(myCardnotes);
                    myCardContents.appendChild(myAction);

                myCardRight.appendChild(myCardHeader);
                myCardRight.appendChild(myCardContents);

                myCard.appendChild(myCardLeft);
                myCard.appendChild(myCardRight);

                var myContainer = document.getElementById('mycontainer');
                myContainer.appendChild(myCard);
            }
        }

        healthDataMark();

        function deleteConfirm(){
            if(window.confirm("本当に削除しますか？アップロードした画像も削除されます。")){
                return true;
            }else{
                window.alert('キャンセルしました');
                return false;
            }
        }

        <?php 

        echo 'window.onload = function(){';
            if(isset($result_db_delete)){
                echo 'toastr.' . $toast_type_db . '("' . $toast_message_db . '");'."\n";
            }
            if(isset($result_file_delete)){
                echo 'toastr.' . $toast_type_file . '("' . $toast_message_file . '");'."\n";
            }
            echo '}';
        
        ?>
        </script>
        

        

</body>
</html>



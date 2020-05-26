<?php

require('../common/php/dbconnect.php');

if(!empty($_POST)){
    if($_POST['category'] !== ''){ //カテゴリを選ばせるまではDBへの問い合わせをしない
        $category = $_POST['category'];

        if($category == 'youtube'){
            $stmt = $db->query('SELECT * FROM youtube_rss WHERE load_default<>0 ORDER BY display_order');
            
            $arr_feed = array(); //空配列の定義

            foreach($stmt as $value){
                //urlを配列に格納
                array_push($arr_feed,$value['rss_url']);
            }
            unset($stmt);
            unset($value);
        }elseif($category == 'website'){
            $stmt = $db->query('SELECT * FROM websites WHERE load_default<>0 ORDER BY display_order');
            $arr_weblink = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($arr_weblink);
            $jsonData = json_encode($arr_weblink);
            unset($stmt);
            unset($value);
        }

    }
}else{
    // print '$_POSTがカラです';
}


$sql = 'SELECT * FROM mesurement ms INNER JOIN pets pt ON pt.pet_id = ms.pet_id ORDER BY ms.created DESC';

$response = $db->query($sql,PDO::FETCH_ASSOC);
$arr_health = $response->fetchAll(PDO::FETCH_ASSOC);
// print_r($arr_health);
$jsonData = json_encode($arr_health);




?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../common/css/reset.css">
    <!-- bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!-- lightbox -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" type="text/javascript" ></script>
    <link rel="stylesheet" href="style.css?dummy">
    <!-- font awesome -->

    


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
                            <i class="far fa-trash-alt"></i>
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
        // function removeElm(){
        //     var target = document.getElementsByClassName('sitewrapper');
        //     console.log('target.length : ' + target.length);
        //     // for(var i = 0; i < target.length; i++){
        //     while(target.length){
        //         target[0].remove();
        //         // console.log(i + 'removed');
        //     }
        // }

        // function removeElm(){
        //     var target = document.getElementById('card');
        //     target.removeChild();
        // }

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



                        // myCardProfile.innerHTML = healthData[i]['nickname'];

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




        </script>

</body>
</html>



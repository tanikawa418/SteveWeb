<?php
require("../common/php/login_check.php");
require("../common/php/dbconnect.php");
require("php/_mesurement_main.php");
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
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <!-- toastr.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <link rel="stylesheet" href="styles/style.css">
    <title>Health Data</title>
</head>
<body>
    <header>
        <div class="headercontainer cf">
        <p>Steve the tortoise</p>
            <h1>Health Data</h1>
        </div>
        <a href="..\home\index.php">
            <span class="hometxt">Home</span>
            <i class="fas fa-igloo" id="homeicon"></i>
        </a>

    </header>
    <div class="mycontainer cf" id="mycontainer">
        <div class="card cf">
            <div class="cardleft">
                <!-- <img src="images/DSC_0707.JPG" alt=""> -->
                <a href="#" data-lightbox = "lb"><img class="thumbnails" src="#" alt=""></a>
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

    <script src="../common/js/delete_confirm.js"></script>
    <script src="js/mesurement_main.js"></script>
    <script type="text/javascript">
        //phpからJSON受け取ってループでマークアップ
        var healthData = <?php echo $jsonData; ?>;
        healthDataMark(healthData);

        //データ削除処理からこの画面に戻った場合に処理結果をトースト表示する
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



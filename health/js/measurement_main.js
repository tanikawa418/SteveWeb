//PHPから受け取ったデータを基にマークアップするfunction

function healthDataMark(healthdata){
    for(var i = 0; i<healthData.length; i++){
        var myCard = document.createElement('div');
        myCard.className = 'card cf';

        var myCardLeft = document.createElement('div');
        myCardLeft.className = 'cardleft';
        var fileName = healthData[i]['pic_filename'];
        myCardLeft.innerHTML ='<a href="images/measurement_pics/' + fileName + '" data-lightbox = "lb"><img class="thumbnails" src="images/measurement_pics/thumb/' + fileName + '" alt=""></a>';
        
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

                            var formStr1 = "";
                            formStr1 += '<form action="input/measurement_input.php" method="post">';
                            formStr1 += '<input type="hidden" name="mode" value="edit">';
                            formStr1 += '<input type="hidden" name="measurement_id" value="';
                            formStr1 += healthData[i]['measurement_id'];
                            formStr1 += '">';
                            formStr1 += '<label>';
                            formStr1 += '<button type="submit" class="hidden_btn">隠しボタン</button>';
                            formStr1 += '<i class="fas fa-edit"></i>';
                            formStr1 += '</label>';
                            formStr1 += '</form>';
                        myiconwrap1.innerHTML = formStr1;

                        var myiconwrap2 = document.createElement('div');
                            myiconwrap2.className = 'iconwrap';

                            var formStr2 = "";
                            formStr2 += '<form action="" onsubmit="return deleteConfirm()" method="post">';
                            formStr2 += '<input type="hidden" name="measurement_id" value="';
                            formStr2 += healthData[i]['measurement_id'];
                            formStr2 += '">';
                            formStr2 += '<input type="hidden" name="mode" value="delete">';
                            formStr2 += '<label>';
                            formStr2 += '<button type="submit" class="hidden_btn">隠しボタン</button>';
                            formStr2 += '<i class="far fa-trash-alt"></i>';
                            formStr2 += '</label>';
                            formStr2 += '</form>';
                        myiconwrap2.innerHTML = formStr2;

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


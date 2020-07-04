
let yearmonth = '';
const path = 'images/';

for(var i=0; i<db_data.length; i++){

    console.log(db_data[i]['yearmonth']);
    if(db_data[i]['yearmonth'] !=yearmonth){
        yearmonth = db_data[i]['yearmonth'];

        let category = document.createElement('div');
        category.className = 'category';
        category.dataset['txt'] = db_data[i]['yearmonth'];
        category.innerHTML = '<h2>' + db_data[i]['yearmonth'] + '</h2>';
        
        let photoarea = document.createElement('div');
        photoarea.className = 'photoarea';
        
        var myul = document.createElement('ul');
        myul.innerHTML = '';
        
        photoarea.appendChild(myul);
        category.appendChild(photoarea);
        document.querySelector('#mycontainer').appendChild(category);

    }
    myul.innerHTML += ` <li class="size_normal"><a href="${path}${db_data[i]["pic_filename"]}" data-lightbox = "lb"><img class="thumbnails size-nrm" src="thumbnail.php?file=${path}${db_data[i]["pic_filename"]}" alt="no thumbs"></a></li>`;

};


let slider = document.querySelector('#slider').addEventListener('input',function(){
    let val = Number(this.value);
    let class_changeto = '';
    switch(val){
        case 1:
            class_changeto = 'size_small'; 
            break;
        case 2:
            class_changeto = 'size_normal';
            break;
        case 3:
            class_changeto = 'size_large';
            break;
        case 4:
            class_changeto = 'size_max';
            break;
    }
    let target_li = document.querySelectorAll('li');
    target_li.forEach(element => {
        element.className=class_changeto;
    })
})

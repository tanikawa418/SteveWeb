

function openingAnimation(){
    let loader = document.querySelector('#loader-wrap');
    loader.style.display = 'none';
    anm_steve = new TextAnimation('#steve');
    anm_steve.animate();
    setTimeout("subtitleShow()",2500);
}

function subtitleShow(){
    document.querySelector('#subtitle').style.display='block';
    setTimeout("showHero()",500);
}

function showHero(){
    let elHero = document.querySelectorAll('.hero');
    elHero.forEach(element => element.classList.add('startAnimation'));
    setTimeout("showCrawl()",600);
}

function showCrawl(){
    let elCr = document.querySelector('#crawl-wrapper');
    elCr.style.visibility = 'visible';
}

document.addEventListener('DOMContentLoaded', function(){
    setTimeout("openingAnimation()",3000);
})
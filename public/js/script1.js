var main = document.getElementsByClassName('main')[0];
var progressBarNum = document.getElementById('progressBarNum');
var progressBar = document.getElementById('progressBar');
var progressBarClass = document.getElementsByClassName('progressBar');
var squid = document.getElementById('squid');
var player = document.getElementById('player');
var hiddenLayer = document.getElementById('hiddenLayer');
var touchH1 = document.getElementById('touchH1');
var bingo = document.getElementsByClassName('bingo');
var clickBtn = document.getElementsByClassName('clickBtn');
var randomBtnClass = document.getElementsByClassName('randomBtn');
var ran = document.querySelector('#clickBtn');
var second = document.getElementById('second');
var addscore = document.getElementById('addscore');
// hiddenLayer.addEventListener("click",addBar);
// var randomBtn1 = document.getElementById('randomBtn1');

var secondTime=0;
clacSenend = setInterval(() => {
    secondTime+=1;
}, 1000);

function ST(){

}
var nb = Math.floor(Math.random()*5)+1;
html = '';
times = 0;
src=1;
pos = 0;
squid.src="/images/boss.png";
player.src="/images/playerA1.png";
arms.src = "/images/arms1.png";
touchH1.addEventListener("click",run);

touchH1.addEventListener("click",()=>{
    touchH1.style.opacity="0";
    hiddenLayer.style.transition=".5s";
    setTimeout(()=>{
        hiddenLayer.style.display="none";
    },500)
});

function Appear(){
    var randomBtn = document.getElementById('randomBtn'+(Math.floor(Math.random()*1)+1));
    randomBtn.style.display = "block";
}
for(var a=0;a<clickBtn.length;a++){
    clickBtn[a].addEventListener("click",disappear);
}

function disappear(){
    arms.style.display = "block";
    player.src="/images/playerA2.png";
    player.style.width = "90px";
    setTimeout(()=>{
        squid.src="/images/boss2.png";
        addscore.style.opacity="1";
        addscore.style.transition=".3s";
        addscore.style.top="10px";
    },300)

    setTimeout(()=>{
        arms.style.display = "none"
        player.src="/images/playerA1.png";
        player.style.width = "120px";
    },500)
    setTimeout(()=>{
        squid.src="/images/boss.png";
    },600)

    times+=1;
    // console.log(times);
    start();
    setTimeout(()=>{
        addscore.style.opacity="0";
        addscore.style.top="30px";
    },700)
    html += '<div class="progressBarItem"></div>';
    progressBar.innerHTML = html;
    // progressBarNum.textContent = Number(progressBarNum.textContent)+1;
    progressBarNum.innerHTML = (100- times*4) +"/100";

    for(var d=0;d<randomBtnClass.length;d++){
        randomBtnClass[d].style.display="none";
    }
}
function clearAppear(){
    for(var d=0;d<randomBtnClass.length;d++){
        randomBtnClass[d].style.display="none";
    }
}
function run(){
    touchH1.removeEventListener("click",run);
    cycle=setInterval(() => {
        clearAppear();
        Appear();
        swap();
    }, 900)
}
for(var v=0;v<bingo.length-1;v++){
    bingo[v].addEventListener("click",run);

}

function swap(){
   ran.style.left = Math.floor(Math.random()*300)+1+"px";
   ran.style.top = Math.floor(Math.random()*600)+1+"px";
}
function start(){

    if(times==4){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[0].style.display = "flex";
    }
    if(times==8){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[1].style.display = "flex";

    }
    if(times==13){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[2].style.display = "flex";

    }
    if(times==18){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[3].style.display = "flex";

    }
    if(times==22){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[4].style.display = "flex";

    }
    if(times==25){
        times+=1;
        html += '<div class="progressBarItem"></div>';
        progressBar.innerHTML = html;
        clearInterval(cycle);
        qaAll[5].style.display = "flex";

    }
}
bingo[bingo.length-1].addEventListener("click",()=>{
    clearInterval(clacSenend);
    second.innerHTML = "共花了"+secondTime+"秒";
})

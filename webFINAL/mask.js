//for index and discuss
(function() {
    'use strict';
    function elasticArea() {
    $('.js-elasticArea').each(function(index, element) {
        var elasticElement = element,
            $elasticElement = $(element),
            initialHeight = initialHeight || $elasticElement.height(),
            delta = parseInt( $elasticElement.css('paddingBottom') ) + parseInt( $elasticElement.css('paddingTop') ) || 0,
            resize = function() {
            $elasticElement.height(initialHeight);
            $elasticElement.height( elasticElement.scrollHeight - delta );
        };
        
        $elasticElement.on('input change keyup', resize);
        resize();
    });
    
    };
    //Init function in the view
    elasticArea();
    })();

var xhr;
// 設定物件
if(window.ActiveXObject){
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}
else if(window.XMLHttpRequest){
    xhr = new XMLHttpRequest();
}   

  
var mask = document.getElementsByClassName('mask')[0];
var new_mask = document.getElementsByClassName("new_mask")[0];
//一開始隱藏遮罩
mask.setAttribute("hidden", "hidden");
new_mask.setAttribute("hidden", "hidden");

var c_height = document.documentElement.clientHeight;
var c_width = document.documentElement.clientWidth;

mask.style.height = c_height + "px";
new_mask.style.left = c_width / 2 - 300 + "px";
new_mask.style.top = c_height / 2 - 400 + "px";
//顯示遮罩
function show_new_forum() {
    mask.removeAttribute("hidden");
    new_mask.removeAttribute("hidden");

    document.documentElement.style.overflowY = 'hidden'; 
    var tops = $(document).scrollTop();//当页面滚动时，把当前距离赋值给页面，这样保持页面滚动条不动
    $(document).bind("scroll",function (){$(document).scrollTop(tops); });
}           
//視窗大小變動
window.onresize = function() {
    var c_height = document.documentElement.clientHeight;
    var c_width = document.documentElement.clientWidth;

    mask.style.height = c_height + "px";
    new_mask.style.left = c_width / 2 - 300 + "px";
    new_mask.style.top = c_height / 2 - 380 + "px";
}
//隱藏遮罩
function del_new_forum(){
    mask.setAttribute("hidden", "hidden");
    new_mask.setAttribute("hidden", "hidden");
    
    document.documentElement.style.overflowY = 'scroll'; 
    $(document).unbind("scroll");   
}





//for index and discuss
//彈性textarea
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


var upIMG_URL;
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

function upload(){
    var formData = new FormData(document.getElementById('uploadForm'));
    var xhr = new XMLHttpRequest();
    xhr.upload.addEventListener('progress', function(e){
        console.log(e.loaded, e.total);
    });
    xhr.upload.addEventListener('load', function(){
        console.log('File Uploaded');
    });
    xhr.upload.addEventListener('error', function(){
        console.log('Error.');
    });
    xhr.upload.addEventListener('abort', function(){
        console.log('Aborted.');
    });
    xhr.addEventListener('readystatechange', function(e){
        if(e.target.readyState == 4 && e.target.status == 200){
            console.log(e.target.responseText);
        }
    });
    xhr.open('POST', 'upfile.php');
    xhr.send(formData);

    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            var jsonOBJ = $.parseJSON(xhr.responseText);
            //var jsonOBJ = JSON.parse(xhr.responseText);
            // 上傳成功
            if (jsonOBJ.result=="OK" ) {
                document.getElementById("upload result").innerHTML = jsonOBJ.message;
                upIMG_URL = jsonOBJ.url;  
                return;
            }				
            // 上傳失敗
            if (jsonOBJ.result=="ERROR" ) {
                alert(jsonOBJ.message);
                return;
            }
    
        }
    }
} 
//新增看板名稱
function new_forum(){                
    var forum_name = document.getElementById("new_forum_name").value;
    var animalType = document.getElementById("animalType").value;
    var introduction = document.getElementById("introduction").value;
    var nickname = document.getElementById("nickname").value;
    var feature = document.getElementById("feature").value;
    var characters = document.getElementById("characters").value;
    var places = document.getElementById("places").value;
    var href = document.getElementById("href").value;

    var formData = new FormData();
    formData.append("type", 3);
    formData.append("forum", forum_name);
    formData.append("animalType", animalType);
    formData.append("introduction", introduction);
    formData.append("nickname", nickname);
    formData.append("feature", feature);
    formData.append("characters", characters);
    formData.append("places", places);
    formData.append("href", href);
    formData.append("imageurl",upIMG_URL); 


    //資料傳送資料到後端
    xhr.open("POST", "ajax/srv_show_alter.php");
    xhr.send(formData);

    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            var jsonOBJ = $.parseJSON(xhr.responseText);
           // var jsonOBJ = JSON.parse(xhr.responseText);
            if (jsonOBJ.result=="OK" ) {                              	                        
                alert(jsonOBJ.message);                                
                //隱藏遮罩
                mask.setAttribute("hidden", "hidden");
                new_mask.setAttribute("hidden", "hidden");
                window.location.reload();
                return;
            }
            if (jsonOBJ.result=="ERROR" ){
                alert(jsonOBJ.message);
                document.getElementById(jsonOBJ.field).focus();                                
                return;
            }                             
        }
    }                                   
}

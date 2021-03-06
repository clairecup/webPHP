<?PHP
    session_start();
	include "ajax/tools.php";
	// 如果沒登入, 導回 LOGIN 頁面
    if( !isset($_SESSION['nickname']) ) {
		echo "<script>window.location.href='".$HOME_URL."'</script>";
		exit;
	}
    // 如未指定目前的討論版, 將第一個fid當作預設,
    if( !isset($_SESSION['fid'])  ) {
        $fid = 1;
        $_SESSION['fid'] = $fid;
    }

    

    // 找出目前 看板名稱
    $sql = "SELECT fid,forum,animal FROM forum WHERE fid=".$_SESSION['fid'];
	$sth = $db->prepare($sql);
	$sth->execute();
	$row=$sth->fetch();

    //不同動物有相對圖片
    $img = "";    
	$forum = $row["forum"];
    switch($forum)
    {
        case $orange:
            $img = "./images/icon_orange.png";
            break;
        case $huahua:
            $img = "./images/icon_huahua.png";
            break;
        case $tiger:
            $img = "./images/icon_tiger.png";
            break;
        default:
            $img ="./images/defalt.png";
            break;
    } 
    // 不同動物有不同聲音
    $type  = $row["animal"];
    $sound = "";
    switch($type)
    {
        case "cat":
            $sound = "喵";
            break;
        case "dog":
            $sound ="汪";
            break;
        default:
            $sound ="看";
            break;
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?PHP echo $HOME_TITLE;?> - 新增貼文</title>
    <!--leaflet-->    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

    <!--fullscreen-->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
          rel='stylesheet' /> 
    <!--jquery-->
    <script src="./jquery-3.6.0.js"></script>
    <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="hw05.css">
<body onload="initialize()">
    <div id="header">
            <div id="h_left">
                <button class="btn-word" onclick="location.href='<?PHP echo $HOME_URL?>';"><i class="fas fa-home fa-2x"></i></button>
                <button class="btn-word" onclick="location.href='<?PHP echo $DISCUSS_URL?>';"><i class="fas fa-comments fa-2x"></i></button>                        
            </div>           
            <span id="h_mid"><h1 align="center">剛剛發現了＿<?PHP echo $forum;?>＿，<?PHP echo $sound;?></h1></span>
			<span id="h_right">&nbsp;</span>               
    </div> 
	<div class="center">    
        <div class="center1">&nbsp;</div>
        <div class="center2">                    	    
            <div name="form1">                
                <div class="form-group">
                    <label for="username"><b>標題</b></label>
                    <input type="text" class="form-control" id="title" placeholder="title" name="title">
                </div>               
                <!--textarea id="content" class="textarea" placeholder="content" name="content"></textarea-->
                <div class="container">            
                    <span class="textarea-label"><b>文章內容</b></span>
                    <textarea rows="1"  id="content" class="form-control js-elasticArea" placeholder="content"></textarea>        
                </div>
                <label for="file"><b>請提供照片: </b></label>
                <form id="uploadForm" method="post" enctype="multipart/form-data" style="display:inner-flex;">
                    <input type="file" name="file" style="flex:3;">
                    <input type="button" value="上傳" onclick="upload();" style="flex:1;">                   
                </form>
                <center><span id = "upload result"></span></center>
                <br>
                <div class="form-group">
                    
                    你覺得<?PHP echo $forum;?>的狀態如何？&emsp;&emsp;
                    <input type="radio" name="health" value="healthy" id="healthy" checked><label for="healthy">健康 &emsp;&emsp;</label>
                    <input type="radio" name="health" value="unhealthy" id="unhealthy" ><label for="unhealthy">異常</label>
                    
                    <br>
                
                    請問你剛剛有餵食<?PHP echo $forum;?>嗎？&emsp;
                    <input type="radio" name="feed" value="feed" id="feed" ><label for="feed">有餵食&emsp;&nbsp;</label>
                    <input type="radio" name="feed" value="nofeed" id="nofeed" checked><label for="nofeed">無餵食</label>
                    
                </div>
                <div class="map">
                    <p><b><?PHP echo $forum;?>在哪裡呢？</b></p>
                    <div id="post_map" style="height:300px;" name="map"></div>

                </div>
                <br>
                <table width="100%">
                    <tr>
						<td width="20%"></td>                        
                        <td width="30%" align="center" ><button type="button" class="btn-primary" onclick='add()'>新增</button></td>
						<td width="30%" align="center" ><button type="button" onclick="window.history.back()">取消</button></td>
						<td width="20%"></td> 
                    </tr>                   
                </table>                
            </div>            
        </div>
        <div class="center3">&nbsp;</div>
    <div>
	     


<script>
    var upIMG_URL;
    var mymap,marker,lat,lng;
    var count=0;
    var xhr;
     // 設定物件
    if(window.ActiveXObject){
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if(window.XMLHttpRequest){
        xhr = new XMLHttpRequest();
    }
    //textarea彈性高度，https://codepen.io/tibomahe/pen/EKVmPq
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

    
    function initialize() {
        mymap = L.map(document.getElementById('post_map'), {
            center: [24.982940, 121.575910],//[24.981831, 121.575416],
            zoom: 15,        
            fullscreenControl: true,//加入fullscreen控制鈕
        });
        var attribution = mymap.attributionControl;
        attribution.setPrefix('<img class="mapicon" src="<?PHP echo $img?>">');
        // addAttribution 是在前缀后添加附属信息
        attribution.addAttribution('點擊滑鼠一次新增地點，點擊其他位置可更改座標位置；快速點擊滑鼠兩次可刪除位置座標');    
        
        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                minZoom: 13,                    
                maxZoom: 18
            }
        ).addTo(mymap);


        if(count == 0)
            mymap.on('click',onMapClick);
        else
            mymap.on('click',movePoint);
    }
    function movePoint(e) {
        marker.setLatLng(e.latlng);
        mymap.on('dblclick', function (e) {
            mymap.removeLayer(marker);
            mymap.off('click');//取消点击事件
            e.latlng.lat = undefined;
            e.latlng.lng = undefined;
            getMarkerValue(e);
            mymap.on('click',onMapClick);
        });
        getMarkerValue(e);
    }
    function onMapClick(e) {
        marker = L.marker(e.latlng,{
            title: '<?PHP echo $forum;?>',
            riseOnHover: true}
            ).addTo(mymap);
        getMarkerValue(e);
        mymap.off('click');//取消点击事件
        count++;        
        mymap.on('click',movePoint);           
    }
    function getMarkerValue(e){
        lat = e.latlng.lat;
        lng = e.latlng.lng;
        
  }  
	// 資料送到後端去
    function add() {
        var a = $("[name='health']:checked").val(); 
        var b = $("[name='feed']:checked").val();
		var formData = new FormData();
		formData.append("title", document.getElementById("title").value);
        formData.append("content", document.getElementById("content").value);
		formData.append("lat", lat);
        formData.append("lng", lng);
        formData.append("health", a);
        formData.append("feed", b);
        formData.append("imageurl",upIMG_URL); 
		
		// 傳送資料到後端
        xhr.open("POST", "ajax/srv_post.php");
        xhr.send(formData);	
		
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                var jsonOBJ = JSON.parse(xhr.responseText);

				// 更新失敗
				if (jsonOBJ.result=="ERROR" ) {
                    alert(jsonOBJ.message);
					var field = jsonOBJ.field;
					document.getElementById(field).focus();					
					return;
				}
				
				// 更新成功
				if (jsonOBJ.result=="OK" ) {
					var url = jsonOBJ.url;
					alert(jsonOBJ.message);
					window.history.back();
					return;
				}
            }
        }
		
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
</script>

</body>
</html>
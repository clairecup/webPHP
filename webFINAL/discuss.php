<?PHP
    session_start();
    if ( isset($_SESSION['uid']) ) {              
        $funcName = "<li><span class='icon-user'></span></li>";        
	    $funcName.= "<li>Hi, ".$_SESSION['nickname']."&nbsp;</li>";
        if( isset($_SESSION['admin'])){
            $funcName.= "<li><a href='admin.php' class='a'>管理</a></li>";
        } 		
		$funcName.= "<li><a href='modify.php' class='a'>修改帳戶</a></li>";
        $funcName.= "<li><a href='post.php' class='a'>新增貼文</a></li>";
        $funcName.= "<li><a href='signout.php' class='a'>登出</a></li>";        		
    }
    else {
	    $funcName = "<li><a href='signin.php' class='a'>登入</a></li>";
        $funcName.= "<li><a href='signup.php' class='a'>註冊</a></li>";
    }

    include "ajax/tools.php";
	
	//---------------------------------
	// 產出討論版區塊
	//---------------------------------
    $record=[];
	$sth = $db->prepare("SELECT fid,forum FROM forum ORDER BY fid");
    $sth->execute();
	$board_str = "";
    if( isset($_SESSION['admin']) && $_SESSION['admin']==0 ){
        $board_str.= "<tr><td width=100%>
                            <center><button onclick='show_new_forum()'><span class='icon-plus'></span></button><center>
                        </td></tr>  \n";
    }
    
    $first_forum = "";
    //$i = 0;
	while( ($row=$sth->fetch()) ) {
		$fid   = $row["fid"];
		$forum = $row["forum"];
       
		$board_str.= "<tr height=32px><td width=100%>\n";        
		$board_str.= "<input type='button' id='forum$fid' value='$forum' onclick=\"viewBoard($fid,'$forum')\">\n";
		$board_str.= "</td></tr>\n";
		
		// 如未指定目前的討論版, 將第一個fid當作預設, 利用最後面javascript來啟動
		if( !isset($_SESSION['fid'])  ) {
			$_SESSION['fid'] = $fid;
            $_SESSION['forum'] = $forum;
           //$i++;
		}   
	}
    
?>
<html>
    <head>
	    <meta charset="UTF-8">
        <title><?PHP echo $HOME_TITLE;?></title>
        <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
        <!--jquery-->
        <script src="./jquery-3.6.0.js"></script>
        <link rel="stylesheet" type="text/css" href="hw05.css">
        
    </head>   

    <body>        
        <div id="header">
            <div id="h_left">
                <button class="btn-word" onclick="location.href='<?PHP echo $HOME_URL?>';"><i class="fas fa-home fa-2x"></i></button>
                <button class="btn-word" disabled ><i class="fas fa-comments fa-2x" style="color:#2f5d62;"></i></button>
            </div>          
            <center><h2 id="h_mid" class="title"><?PHP echo $HOME_TITLE;?></h2></center>      
            <ul id="h_right" class="menu"><?PHP echo $funcName;?></ul>   
        </div>               
        <div class="mask" style="z-index:999;">
            <div class="new_mask" >                
                <p>輸入新動物：<p>
                <br>
                <div class="new-form">
                    <label for="new_forum_name">**請輸入名稱：</label>                                            
                    <input type="text"  class="form-control" id="new_forum_name" name="new_forum_name" placeholder="新動物名稱">                
                
                    <label for="animalType">**新動物種類：</label>
                        <select class="form-control" id="animalType">
                            <option value="" disabled selected>新動物種類</option>                            
                            <option value="dog">狗狗</option>
                            <option value="cat">貓貓</option>
                            <option value="others" >其他</option>                                               
                    </select>
                    
                    <label for="introduction">請輸入簡介：</label>
                    <textarea rows="1"  id="introduction" class="form-control js-elasticArea" placeholder="簡介" name="introduction"></textarea>
                    
                    <label for="nickname">請輸入別名：</label>
                    <input type="text"  class="form-control" id="nickname" name="nickname" placeholder="別名">
                    
                    <label for="file">請提供照片: </label>
                    <form id="uploadForm" method="post" enctype="multipart/form-data"" style="display:flex;">
                        <input type="file" name="file" style="flex:3;">
                        <input type="button" value="Upload" onclick="upload();" style="flex:1;">                   
                    </form>
                    <center><span id = "upload result"></span></center>
                    <br>
                    <label for="feature">請輸入特徵：</label>
                    <input type="text"  class="form-control" id="feature" name="feature" placeholder="特徵">
                    
                    <label for="characters">請輸入個性：</label>
                    <input type="text"  class="form-control" id="characters" name="characters" placeholder="個性">

                    <label for="places">請輸入出沒地：</label>
                    <input type="text"  class="form-control" id="places" name="places" placeholder="出沒地">

                    <label for="href">請輸入個人帳號網址：</label>
                    <input type="text"  class="form-control" id="href" name="href" placeholder="個人帳號網址">

                </div>
                <table width="100%">
                        <tr>
                            <td width="20%"></td>                        
                            <td width="30%" align="center" ><button type='button' class='btn-primary' onclick="new_forum();">確定新增</button></td>
                            <td width="30%" align="center" > <button type='button' class='btn-primary' onclick="del_new_forum();">取消新增</button></td>
                            <td width="20%"></td> 
                        </tr>                   
                </table>               
            </div>        
        </div>
        <div id="box">
            <div class="board">                
                <center><h3>看板</h3><center>
                <table>                                     
                    <?PHP // 顯示討論版區塊
                        echo $board_str;
                    ?>
                </table>
                
            </div>
            <div class="discuss">
                <div>
                    <ul class="discuss-header">
                        <li style="vertical-align: middle;"><span id='imgDiv' ></span></li>
                        <li><h2 style="margin-top:7px; vertical-align: middle;">討論版</h2></span></li>
                    </ul>                       
                </div>
				<div id="discussDiv" class="discuss-body"></div>
            </div>
            <div class="right"></div>
        </div> 
                   
        <script src="./mask.js"></script>
        <script>                 
			// 點選要看的討論版
			function viewBoard(fid,forum) {
                switch (forum) {
                    case '小橘':
                        document.getElementById("imgDiv").innerHTML ="<a href='./introduction/orange.php'><img src='./images/icon_orange.png' class='imgD'></a>";
                        break;
                    case '花花':
                        document.getElementById("imgDiv").innerHTML ="<a href='./introduction/huahua.php'><img src='./images/icon_huahua.png' class='imgD'></a>";
                        break;
                    case '胖虎':
                        document.getElementById("imgDiv").innerHTML ="<a href='./introduction/tiger.php'><img src='./images/icon_tiger.png' class='imgD'></a>";
                        break;
                    default:
                        document.getElementById("imgDiv").innerHTML = "<a href='#'><img src='./images/defalt.png' class='imgD'></a>";
                } 
            /*新增看板名稱
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
            */
                

		    var formData = new FormData();
		        formData.append("fid", fid);
                //formData.append("forum", forum);
		
		        // 傳送fid資料到後端
                xhr.open("POST", "ajax/srv_show_fid.php");
                xhr.send(formData);

                // 接收回傳
                xhr.onreadystatechange=function() {
                    if (xhr.readyState==4 && xhr.status==200) {
						document.getElementById("discussDiv").innerHTML = xhr.responseText;
                    }
                }
                
			}
			
			//處理回覆訊息
            function sendRespon(mid,responText,responDiv,n) {
				// alert(""+mid+" / "+responText);
		        var formData = new FormData();
		        formData.append("mid", mid);
		        formData.append("content", responText);
				formData.append("n", n);	
		       
                //如果回覆欄有資料，傳送資料到後端
                if(responText.length>0){
                    xhr.open("POST", "ajax/srv_show_respon.php");
                    xhr.send(formData);
                }
                else{
                    alert('[回覆內容]不能空白');
                }                
				
                // 接收回傳
                xhr.onreadystatechange=function() {
                    if (xhr.readyState==4 && xhr.status==200) {                        
                            document.getElementById(responDiv).innerHTML = xhr.responseText;
                        
						
                    }
                }
			}
            //刪除主題，底下回應會一併刪除
            function del_discuss(mid,fid){
                //fid=3;
                if(confirm("確定刪除該主題？\n**底下回應會一併刪除**")){
                    var formData = new FormData();
                    formData.append("type", 1);
                    formData.append("mid", mid);
                    formData.append("fid", fid);                

                    xhr.open("POST", "ajax/srv_show_alter.php");
                    xhr.send(formData);
                                            
                    // 接收回傳
                    xhr.onreadystatechange=function() {
                        if (xhr.readyState==4 && xhr.status==200) {                        
                            var jsonOBJ = JSON.parse(xhr.responseText);

                            if (jsonOBJ.result=="OK" ) {
                                viewBoard(fid,forum);	                        
                                alert(jsonOBJ.message);
                                return;
                            }
                            if (jsonOBJ.result=="ERROR" ) {
                                viewBoard(fid,forum);	                        
                                alert(jsonOBJ.message);
                                return;
                            }		
                        }
                    }
                }               
            }
            //刪除回應
            function del_respon(rid,fid){
                if(confirm("確定刪除該回應？")){
                    var formData = new FormData();
                    formData.append("type", 2);
                    formData.append("rid", rid);
                    formData.append("fid", fid);

                    xhr.open("POST", "ajax/srv_show_alter.php");
                    xhr.send(formData); 

                    // 接收回傳
                    xhr.onreadystatechange=function() {
                        if (xhr.readyState==4 && xhr.status==200) {                                                    
                            var jsonOBJ = JSON.parse(xhr.responseText);

                            if (jsonOBJ.result=="OK" ) {
                                viewBoard(fid,forum);                               	                        
                                alert(jsonOBJ.message);
                                return;
                            }
                            if (jsonOBJ.result=="ERROR" ) {                            	                        
                                alert(jsonOBJ.message);
                                return;
                            }		
                        }
                    }
                }    
            }    
        </script>
		
		<script>viewBoard(<?PHP echo $_SESSION['fid']?>, '<?PHP echo $_SESSION['forum']?>');</script>
 
    </body>
</html>

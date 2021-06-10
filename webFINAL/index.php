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
    $i = 0;
	while( ($row=$sth->fetch()) ) {
		$fid   = $row["fid"];
		$forum = $row["forum"];
       
		$board_str.= "<tr height=32px><td width=100%>\n";        
		$board_str.= "<input type='button' id='forum$fid' value='$forum' onclick=\"viewBoard($fid,'$forum')\">\n";
		$board_str.= "</td></tr>\n";
		
		// 如未指定目前的討論版, 將第一個fid當作預設, 利用最後面javascript來啟動
		if( $i==0 ) {
			$_SESSION['fid'] = $fid;
            $first_forum = $forum;
            $i++;
		}   
	}
    
?>
<html>
    <head>
	    <meta charset="UTF-8">
        <title><?PHP echo $HOME_TITLE;?></title>
        <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="hw05.css">
        
    </head>   

    <body>        
        <div id="header">
            <span id="h_left"><a href="<?PHP echo $MAP_URL;?>" class="title_href"><i class="fas fa-map-marked-alt fa-2x"></i></a></span>          
            <center><h1 id="h_mid" class="title"><?PHP echo $HOME_TITLE;?></h1></center>      
            <ul id="h_right" class="menu"><?PHP echo $funcName;?></ul>   
        </div>               
        <div class="mask">
            <form class="new_mask">                
                <label for="new_forum_name">輸入新動物：</label>
                <br>
                <br>
                <br>                                            
                <input type="text"  class="form-control" id="new_forum_name" placeholder="新動物名稱">                
                <br>
                <div class="form-group">
                    <select class="form-control" id="animalType" SIZE=4>
                        <optgroup label="新動物種類">                            
                            <option value="dog">狗狗</option>
                            <option value="cat">貓貓</option>
                            <option value="others" >其他</option>
                        <optgroup>                                                  
                    </select>
                </div>
                <table width="100%">
                        <tr>
                            <td width="20%"></td>                        
                            <td width="30%" align="center" ><button type='button' class='btn-primary' onclick="new_forum()">確定新增</button></td>
                            <td width="30%" align="center" > <button type='button' class='btn-primary' onclick="del_new_forum()">取消新增</button></td>
                            <td width="20%"></td> 
                        </tr>                   
                    </table>               
            </form>        
        </div>
        <div id="box">
            <div class="board">                
                <center><h2>看板</h2><center>
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
                   
        
        <script>     
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
            new_mask.style.left = c_width / 2 - 240 + "px";
            new_mask.style.top = c_height / 2 - 380 + "px";
            //顯示遮罩
            function show_new_forum() {
                mask.removeAttribute("hidden");
                new_mask.removeAttribute("hidden");
            }           
            //視窗大小變動
            window.onresize = function() {
                var c_height = document.documentElement.clientHeight;
                var c_width = document.documentElement.clientWidth;

                mask.style.height = c_height + "px";
                new_mask.style.left = c_width / 2 - 240 + "px";
                new_mask.style.top = c_height / 2 - 380 + "px";
            }
            //隱藏遮罩
            function del_new_forum(){
                mask.setAttribute("hidden", "hidden");
                new_mask.setAttribute("hidden", "hidden");
            }
            //新增看板名稱
            function new_forum(){                
                var forum_name = document.getElementById("new_forum_name").value;
                var animalType = document.getElementById("animalType").value;
                
                var formData = new FormData();
                formData.append("type", 3);
		        formData.append("forum", forum_name);
                formData.append("animalType", animalType);

                //資料傳送資料到後端
                xhr.open("POST", "ajax/srv_show_alter.php");
                    xhr.send(formData);

                    xhr.onreadystatechange=function() {
                        if (xhr.readyState==4 && xhr.status==200) {
                            var jsonOBJ = JSON.parse(xhr.responseText);
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
                

		        var formData = new FormData();
		        formData.append("fid", fid);
                formData.append("forum", forum);
		
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
                                viewBoard(fid);	                        
                                alert(jsonOBJ.message);
                                return;
                            }
                            if (jsonOBJ.result=="ERROR" ) {
                                viewBoard(fid);	                        
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
                                viewBoard(fid);                               	                        
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
		
		<script>viewBoard(<?PHP echo $_SESSION['fid']?>, '<?PHP echo $first_forum;?>');</script>
 
    </body>
</html>

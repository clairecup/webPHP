<?PHP
    include "ajax/tools.php";
    session_start();    
    // 如果主機session無admin或沒有login , 導回首頁
	if( !isset($_SESSION['admin']) || !isset($_SESSION['uid']) ){
		echo "<script>window.location.href='".$HOME_URL."'</script>";
	}
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?PHP echo $HOME_TITLE;?> - 管理論壇</title>
    <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="hw05.css">
</head>
<body>
    <div id="header">
            <span id="h_left">
                <a href="#" class="title_href" class='a'><i class="fas fa-map-marked-alt fa-2x"></i></a>
                <a href="<?PHP echo $HOME_URL;?>" class="title_href" class='a'><i class="fas fa-comments fa-2x"></i></a>                
            </span>           
            <span id="h_mid"><h1 align="center">管理</h1></span>
			<span id="h_right">&nbsp;</span>              
    </div> 
    <div class="mask">
        <form class="new_mask">
            新增管理員：
            <p>1.選擇使用者：</p>            
            <div class="selectBox">                
                <select name="user" id="all_user" class="select">
                    <option selected disabled>uid, username, nickname</option>                        
                </select>
            </div>
            <p>2.管理的看板：</p>
            <div class="selectBox">           
                <select name="forum" id="all_forum" class="select">
                    <option selected disabled>fid, forum</option>                         
                </select>
            </div>
            <br>
            <table width="100%">
                    <tr>
						<td width="20%"></td>                        
                        <td width="30%" align="center" ><button type='button' class='btn-primary' onclick="new_admin()">確定新增</button></td>
						<td width="30%" align="center" > <button type='button' class='btn-primary' onclick="del_new_admin()">取消新增</button></td>
						<td width="20%"></td> 
                    </tr>                   
                </table>               
        </form>        
    </div>
    <div class="ad_center">    
        <div class="ad_center1">&nbsp;</div>
        <div class="ad_center2">
            <h3><label for="ad_table">使用者權限</label></h3>
            <button type='button' class='btn-primary' onclick='show_new_admin()'>新增管理員</button>
            <br>
            <br>            
            <table  class="ad_table" cellpadding="7" border='1'>
                <tr>
                    <td width="20%">user id</td>
                    <td width="20%">user nickname</td>
                    <td width="20%">管理的看板</td>
                    <td width="20%">取消權限</td>
                </tr>                            
            </table>
            <table  id ="user_table" class="ad_table" cellpadding="7" border='1'>
                                            
            </table>                        
        </div>
        <div class="ad_center3">&nbsp;</div>
    <div>
    
</body>
<script>
    var xhr;
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
    
    //視窗大小變動
    window.onresize = function() {
        var c_height = document.documentElement.clientHeight;
        var c_width = document.documentElement.clientWidth;

        mask.style.height = c_height + "px";
        new_mask.style.left = c_width / 2 - 240 + "px";
        new_mask.style.top = c_height / 2 - 380 + "px";
    }
    //隱藏遮罩
    function del_new_admin(){
        mask.setAttribute("hidden", "hidden");
        new_mask.setAttribute("hidden", "hidden");
    }         


    function show(){ 
        xhr.open("POST", "ajax/srv_admin.php");
        xhr.send();               
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                document.getElementById("user_table").innerHTML = xhr.responseText;
            }
        }
    }
    
    function del(uid, fid){
        var session_uid = '<?php echo $_SESSION['uid']; ?>';      
        if(confirm("確定刪除？")){
            var formData = new FormData();
            formData.append("uid", uid);
            formData.append("fid", fid);
            

            // 傳送資料到後端
            xhr.open("POST", "ajax/srv_admin.php");
            
            if (uid == session_uid)
                alert("管理員不能自我免職");
            else
                xhr.send(formData);

            // 接收回傳
            xhr.onreadystatechange=function() {
                if (xhr.readyState==4 && xhr.status==200) {
                    document.getElementById("user_table").innerHTML = xhr.responseText;
                                    
                }
            }
        }              
    }
    function show_new_admin(){
        mask.removeAttribute("hidden");
        new_mask.removeAttribute("hidden");
        var formData = new FormData(); 
        formData.append("type", 1);      

        xhr.open("POST", "ajax/srv_adminU.php");
        xhr.send(formData);               
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                document.getElementById("all_user").innerHTML = xhr.responseText;
                choose_admin_fid();
            }
        }                 
    }
    
    function choose_admin_fid(){
        var formData = new FormData(); 
        formData.append("type", 2);      

        xhr.open("POST", "ajax/srv_adminU.php");
        xhr.send(formData);               
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                document.getElementById("all_forum").innerHTML = xhr.responseText;                
            }
        }

    }  

    function new_admin(){        
        var formData = new FormData(); 
        formData.append("type", 3);
        formData.append("user",document.getElementById("all_user").value);
        formData.append("forum",document.getElementById("all_forum").value);      


        xhr.open("POST", "ajax/srv_adminU.php");
        xhr.send(formData);               
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                var jsonOBJ = JSON.parse(xhr.responseText);

                if (jsonOBJ.result=="ERROR" ) {	
                    if(jsonOBJ.field=="all_user" )				
					    document.getElementById("all_user").focus();
                    if(jsonOBJ.field=="all_forum")
                        document.getElementById("all_forum").focus();
					alert(jsonOBJ.message);
					return;
				}
                if (jsonOBJ.result=="OK" ) {					
					alert(jsonOBJ.message);										
                    document.getElementsByClassName("mask")[0].style.display="none";
                    show();
                    return;
				}

                                
            }
        }
        
  
        
    }
    
    
		

</script>
<script>
    show()
    
</script>
</html>	
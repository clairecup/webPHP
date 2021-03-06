<?PHP
    include "ajax/tools.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?PHP echo $HOME_TITLE;?> - 登入會員</title>
    <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>    
	<link rel="stylesheet" type="text/css" href="hw05.css">
    <style>        
    </style>    
</head>
<body>
    
    <div id="header">
            <div id="h_left">
				<button class="btn-word" onclick="location.href='<?PHP echo $HOME_URL?>';"><i class="fas fa-home fa-2x"></i></button>
                <button class="btn-word" onclick="location.href='<?PHP echo $DISCUSS_URL?>';"><i class="fas fa-comments fa-2x"></i></button>               
			</div>               
            <span id="h_mid"><h1 align="center">登入</h1></span>
			<span id="h_right">&nbsp;</span>                
    </div>

    <div class="center">    
        <div class="center1">&nbsp;</div>
        <div class="center2">                    	    
            <form name="form1">                
                <div class="form-group">
                    <label for="username">帳號</label>
                    <input type="text" class="form-control" id="username" placeholder="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <br>
                <br>
                <br>
                <table width="100%">
                    <tr>                        
                        <td width="100%" align="center"><button type="button" class="btn-primary" onclick='signin()'>登入</button></td>   
                    </tr>
                    <tr>                        
                        <td width="100%" align="right"><button type="button" class="btn-word" onclick="window.location.href='signup.php'">無帳號註冊</button></td>                        
                    </tr>
                </table>                
            </form>            
        </div>
        <div class="center3">&nbsp;</div>
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
	
	// 資料送到後端去
    function signin() {
		var formData = new FormData();
		formData.append("username", document.getElementById("username").value);
		formData.append("password", document.getElementById("password").value);
		
		// 傳送資料到後端
        xhr.open("POST", "ajax/srv_signin.php");
        xhr.send(formData);	
		
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                var jsonOBJ = JSON.parse(xhr.responseText);
				
				// 註冊失敗
				if (jsonOBJ.result=="ERROR" ) {
					var field = jsonOBJ.field;
					document.getElementById(field).focus();
					alert(jsonOBJ.message);
					return;
				}
				
				// 註冊成功
				if (jsonOBJ.result=="OK" ) {
					var url = jsonOBJ.url                    
					window.location.href = url;
					return;
				}
            }
        }
		
	}
</script>


</body>
</html>
<?PHP
    session_start();

	$uid = 0;
    if ( isset($_SESSION['uid']) ) {
		$uid = $_SESSION['uid'];
	}

	// 如果沒登入, 導回 LOGIN 頁面
    if( !isset($_SESSION['nickname']) || $uid <= 0 ) {
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}

    include "ajax/tools.php";
	
	// 進資料庫 檢查 username 跟 password 是否存在
	$sth = $db->prepare("SELECT username,nickname FROM member WHERE uid=:uid");
    $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
    $sth->execute();
	$rows = $sth->fetchAll();
	
	$username = $rows[0]['username'];
	$password = "";
	$nickname = $rows[0]['nickname'];
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?PHP echo $HOME_TITLE;?> - 會員帳號</title>
	<script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="hw05.css">
</head>
<body>	
	<div id="header">
			<div id="h_left">
				<button class="btn-word" onclick="location.href='<?PHP echo $HOME_URL?>';"><i class="fas fa-home fa-2x"></i></button>
                <button class="btn-word" onclick="location.href='<?PHP echo $DISCUSS_URL?>';"><i class="fas fa-comments fa-2x"></i></button>               
			</div>             
            <span id="h_mid"><h1 align="center">修改資料</h1></span>
			<span id="h_right">&nbsp;</span>              
    </div> 

	<div class="center">    
        <div class="center1">&nbsp;</div>
        <div class="center2">                    	    
            <form name="form1">               
                <div class="form-group">
					<label for="username">帳號</label>
					<input type="text" class="form-control" id="username" name="username" value="<?PHP echo $username?>" style="background-color:rgba(93, 93, 93,0.1);">
            	</div>
				<div class="form-group">
					<label for="password">新密碼</label>
					<input type="password" class="form-control" id="password1" placeholder="Password" name="password1">
					<input type="password" class="form-control" id="password2" placeholder="Password" name="password2">
            	</div>
				<div class="form-group">
					<label for="name">綽號</label>
					<input type="text" class="form-control" id="nickname" placeholder="nickname" name="nickname" value="<?PHP echo $nickname;?>">
            	</div>
                <br>
                <br>
                <br>
                <table width="100%">
                    <tr>
						<td width="20%"></td>                        
                        <td width="30%" align="center" ><button type="button" class="btn-primary" onclick='save()'>儲存</button></td>
						<td width="30%" align="center" ><button type="button" onclick="history.back()">取消</button></td>
						<td width="20%"></td> 
                    </tr>                   
                </table>                 
            </form>            
        </div>
        <div class="center3">&nbsp;</div>
    <div>	
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
    function save() {
		
		// 先檢查密碼
		var p1 = document.getElementById("password1").value;
		var p2 = document.getElementById("password2").value;
		
		// 密碼不一樣
		if( p1!=p2 ) {
			document.getElementById("password2").focus();
			alert( "密碼不一樣" );
			return;
		}
		
		var formData = new FormData();
		formData.append("password1", document.getElementById("password1").value);
		formData.append("password2", document.getElementById("password2").value);
        formData.append("nickname", document.getElementById("nickname").value);
		
		// 傳送資料到後端
        xhr.open("POST", "ajax/srv_modify.php");
        xhr.send(formData);	
		
        // 接收回傳
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                var jsonOBJ = JSON.parse(xhr.responseText);

				// 更新失敗
				if (jsonOBJ.result=="ERROR" ) {
					var field = jsonOBJ.field;
					document.getElementById(field).focus();
					alert(jsonOBJ.message);
					return;
				}
				
				// 更新成功
				if (jsonOBJ.result=="OK" ) {
					var url = jsonOBJ.url;
					alert(jsonOBJ.message);
					window.location.href = url;
					return;
				}
            }
        }
		
	}
</script>

</body>
</html>
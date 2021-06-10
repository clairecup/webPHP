<?PHP
    include "tools.php";
	
    // 檢查是否有傳遞資料
    if( !isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['nickname']) ) {
		echo json_encode( array("result" => "ERROR", "message"=>"資料傳遞錯誤", "field"=>"username" ) );
	    exit;
	}

    // 取用資料並確認資料的正確性
    $username = check_input( $_POST['username'] );
	$password = check_input( $_POST['password'] );
	$nickname = check_input( $_POST['nickname'] );
	$preference = check_input( $_POST['preference'] );

/* json 格式
    {
		"result"  : "ERROR", 
		"message" : "[帳號]空白" ,
		"field"   : "username"
	}
*/

	if( $username=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[帳號]不能空白", "field"=>"username" ) );
		exit;
	}

	if( $password=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[密碼]不能空白", "field"=>"password" ) );
		exit;
	}

	if( $nickname=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[綽號]不能空白", "field"=>"nickname" ) );
		exit;
	}
	if( $preference=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"請填寫[喜愛哪種小動物]", "field"=>"preference" ) );
		exit;
	}
	
	// 進資料庫 檢查 username 不能重複
	$sth = $db->prepare("SELECT count(*) T FROM member WHERE username = :username");
    $sth->bindParam(':username', $username, PDO::PARAM_STR);
    $sth->execute();
	$rows = $sth->fetchAll();
	
	// 取出 username 的筆數 大於 0 --> 帳號重複
	$T = $rows[0]['T'];
	if( $T>0 ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[帳號重複] ".$username, "field"=>"username" ) );
		exit;
	}
	
	// 將註冊的資料 新增至 資料庫 member , 跳轉至首頁
	$password = md5($password);  // 密碼轉md5
    $sql = "INSERT INTO member (preference,username,password,nickname) values(?,?,?,?)"; //將需要過濾的欄位以?代替
    $sth = $db -> prepare($sql);
    $sth -> execute( array($preference,$username,$password,$nickname) );  //以字串陣列傳入
	
	echo json_encode( array("result" => "OK", "message"=>"註冊成功", "url"=>$HOME_URL ) );
?>
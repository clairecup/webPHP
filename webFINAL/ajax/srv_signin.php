<?PHP
    include "tools.php";
	
    // 檢查是否有傳遞資料
    if( !isset($_POST['username']) || !isset($_POST['password']) ) {
		echo json_encode( array("result" => "ERROR", "message"=>"資料傳遞錯誤", "field"=>"username" ) );
	    exit;
	}
	/* json 格式
    {
		"result"  : "ERROR", 
		"message" : 資料傳遞錯誤" ,
		"field"   : "username"→失敗後要回到哪個欄位
	}
*/

    // 取用資料並確認資料的正確性
    $username = check_input( $_POST['username'] );
	$password = check_input( $_POST['password'] );

	if( $username=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[帳號]不能空白", "field"=>"username" ) );
		exit;
	}

	if( $password=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[密碼]不能空白", "field"=>"password" ) );
		exit;
	}

    // 密碼轉md5加密
    $password = md5($password);
	
	// 進資料庫 檢查 username 跟 password 是否存在，用prepare、bindPara,避免SQL injection
	$sth = $db->prepare("SELECT uid,nickname FROM member WHERE username = :username AND password=:password");
    $sth->bindParam(':username', $username, PDO::PARAM_STR);
    $sth->bindParam(':password', $password, PDO::PARAM_STR);
    $sth->execute();
	$rows = $sth->fetchAll();
	
	// 檢查 array 的筆數 小於 1 --> 帳號、密碼 找不到
	if( count($rows)<1 ) {
		echo json_encode( array("result" => "ERROR", "message"=>"登入失敗\n\n[帳號 or 密碼] 錯誤", "field"=>"username" ) );
		exit;	}

	$uid = $rows[0]['uid'];
	$nickname = $rows[0]['nickname'];	
	
	
	// 寫入 session
	session_start();
	$_SESSION['uid'] = $uid;
	$_SESSION['nickname'] = $nickname;

	//-----------------------------------------------
	// 檢查 admin table 看是否為管理者
    //-----------------------------------------------
	$sth = $db->prepare("SELECT fid FROM admin WHERE uid = :uid");
    $sth->bindParam(':uid', $uid, PDO::PARAM_STR);
    $sth->execute();
	
	// 抓出來此使用者管理的forum
	$fid = "";
	while( ($row=$sth->fetch()) ) {
		if( $fid != ""){
			$fid.=",";
		}
		$fid.=$row["fid"];
	}
	
	// 確認有管理者權限，寫入 session
	if( $fid!="" ) {
	    $_SESSION['admin'] = $fid;		
	}
	
	echo json_encode( array("result" => "OK", "message"=>"登入成功", "url"=>$HOME_URL ) );
?>
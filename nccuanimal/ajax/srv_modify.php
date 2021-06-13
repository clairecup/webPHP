<?PHP
    include "tools.php";
    session_start();
	if ( !isset($_SESSION['uid']) ) {
	    session_destroy();
	    echo "<script>window.location.href='".$HOME_URL."'</script>";
		exit;
	}

    // 檢查是否有傳遞資料
    if( !isset($_POST['password1']) || !isset($_POST['password2']) || !isset($_POST['nickname']) ) {
		echo json_encode( array("result" => "ERROR", "message"=>"資料傳遞錯誤", "field"=>"password1" ) );
	    exit;
	}

    // 取用資料並確認資料的正確性
    $password1 = check_input( $_POST['password1'] );
	$password2 = check_input( $_POST['password2'] );
	$nickname  = check_input( $_POST['nickname'] );
	$uid       = $SESSION['uid'];

	if( $nickname=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[綽號]不能空白", "field"=>"nickname" ) );
		exit;
	}

	if( $password1!=$password2 ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[密碼]不一致", "field"=>"password1" ) );
		exit;
	}

    // 組更新 sql 語法
	$sql = "UPDATE member SET ";
	
	// 有修改密碼
	if( $password1!="" ) {
		$password = md5($password1);
		$sql.= "password=:password,";
	}
	$sql.= "nickname=:nickname WHERE uid=:uid";
    
	// 進資料庫 更新nickname
	$sth = $db->prepare($sql);
    $sth->bindParam(':nickname', $nickname, PDO::PARAM_STR);
	

	
	
	// 有修改密碼, 把新的password帶入
	if( $password1!="" ) {
	    $sth->bindParam(':password', $password, PDO::PARAM_STR);
	}	
    $sth->bindParam(':uid', $uid, PDO::PARAM_INT);



    $sth->execute();
	
	
	$result = $sth->rowCount();
    if( $result==1 ) {
        $_SESSION['nickname'] = $nickname;
	    echo json_encode( array("result" => "OK", "message"=>"更新成功", "url"=>$HOME_URL ) );
	}
	else {
		echo json_encode( array("result" => "ERROR", "message"=>"更新失敗\n\n".$sth->errorCode(), "field"=>"password1" ) );
	}
	
?>
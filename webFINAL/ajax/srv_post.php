<?PHP
    include "tools.php";
    session_start();
	if ( !isset($_SESSION['uid']) ) {
	    session_destroy();
	    echo "<script>window.location.href='".$HOME_URL."'</script>";
		exit;
	}

    // 檢查是否有傳遞資料
    if( !isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['lat']) || !isset($_POST['lng']) || !isset($_POST['health']) || !isset($_POST['feed'])) {
		echo json_encode( array("result" => "ERROR", "message"=>"資料傳遞錯誤", "field"=>"title" ) );
	    exit;
	}	


    // 取用資料並確認資料的正確性
    $title   = check_input( $_POST['title']  , 256  );
	$content = check_input( $_POST['content'], 1024 );
	$uid     = $_SESSION['uid'];
	$lat     = $_POST['lat'];
	$lng     = $_POST['lng'];
	$health  = $_POST['health'];
	$feed    = $_POST['feed'];

	if( $title=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[標題]不能空白", "field"=>"title" ) );
		exit;
	}

	if( $content=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[文章內容]不能空白", "field"=>"content" ) );
		exit;
	}

	// 將發文的資料 新增至 資料庫 message? , 跳轉至首頁
	$TABLENAME = "message".$_SESSION['fid'];
	$ip        = $_SERVER['REMOTE_ADDR'];

	$sql = "INSERT INTO $TABLENAME (uid,title,content,longitude, latitude,health, feed, ip) values(?,?,?,?,?,?,?,?)";//將需要過濾的欄位以?代替
	$sth = $db -> prepare($sql);
	$result = $sth -> execute( array($uid, $title, $content, $lng, $lat, $health, $feed, $ip) );  //以字串陣列傳入
    //$sql.= " VALUES($uid,'$title','$content','$ip')";
	
	//$result = $db->exec($sql);
	
    if( $result==1 ) {
	    echo json_encode( array("result" => "OK", "message"=>"貼文成功", "url"=>$HOME_URL ) );
	}
	else {
		echo json_encode( array("result" => "ERROR", "message"=>"貼文失敗\n\n", "field"=>"title" ) );
	}
?>
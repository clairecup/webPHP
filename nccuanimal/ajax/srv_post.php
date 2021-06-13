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
	$imageurl= $_POST['imageurl'];
	

	if( $title=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[標題]不能空白", "field"=>"title" ) );
		exit;
	}

	if( $content=="" ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[文章內容]不能空白", "field"=>"content" ) );
		exit;
	}
	if( $lat=="undefined" || $lng=="undefined") {
		$lat = 0;
		$lng = 0;
	}

	// 將發文的資料 新增至 資料庫 message? , 跳轉至首頁
	$TABLENAME = "message".$_SESSION['fid'];
	$ip        = $_SERVER['REMOTE_ADDR'];

	if( $imageurl!="undefined" ) {
		$oriPath = ".".$imageurl;
		$change =  "./uploadFile".$_SESSION['dir']."/";
		$newPath = str_replace( $change,"../images/", $imageurl);
		//echo "$oriPath $newPath";
		
		if(rename($oriPath, $newPath)){        
			//移動檔案之後，刪除該檔案和目錄
			$dir= "../uploadFile".$_SESSION['dir']."/";
			$files = glob($dir.'*');
			foreach ($files as $file) 
				@unlink($file);
			$imageurl = str_replace("../","./", $newPath);
			$sql="INSERT INTO $TABLENAME (uid,title,content,longitude, latitude,health, feed, imageurl,ip)";
			$sql.=" values(:uid, :title, :content, :lng, :lat, :health, :feed, :imageurl, :ip)";
			//$arr=array($uid, $title, $content, $lng, $lat, $health, $feed, $imageurl, $ip);
			$sth = $db->prepare($sql);
			$sth->bindParam(':imageurl'       , $imageurl       , PDO::PARAM_STR);
				
			
		}
	}
	else{
		$sql = "INSERT INTO $TABLENAME (uid,title,content,longitude, latitude,health, feed, ip) ";
		$sql.=" values(:uid, :title, :content, :lng, :lat, :health, :feed, :ip)";
		//$arr = array($uid, $title, $content, $lng, $lat, $health, $feed, $ip);
		$sth = $db->prepare($sql);	
	}
	

	$sth->bindParam(':uid'      , $uid       , PDO::PARAM_INT);
	$sth->bindParam(':title'    , $title     , PDO::PARAM_STR);
	$sth->bindParam(':content'  , $content   , PDO::PARAM_STR);
	$sth->bindParam(':lng'      , $lng       , PDO::PARAM_STR);
	$sth->bindParam(':lat'      , $lat       , PDO::PARAM_STR);
	$sth->bindParam(':health'   , $health    , PDO::PARAM_STR);
	$sth->bindParam(':feed'     , $feed      , PDO::PARAM_STR);
	$sth->bindParam(':ip'       , $ip        , PDO::PARAM_STR);

	
	$result = $sth->execute();  //以字串陣列傳入
    //$sql.= " VALUES($uid,'$title','$content','$ip')";
	
	//$result = $db->exec($sql);
	
    if( $result==1 ) {
	    echo json_encode( array("result" => "OK", "message"=>"貼文成功", "url"=>$HOME_URL ) );
	}
	else {
		echo json_encode( array("result" => "ERROR", "message"=>"貼文失敗\n\n$sql", "field"=>"title" ) );
	}

?>
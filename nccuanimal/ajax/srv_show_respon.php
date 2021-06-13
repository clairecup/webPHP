<?PHP
    include "tools.php";
	session_start();
	
    // 確定登入狀態
	if ( !isset($_SESSION['uid']) ) {
	    session_destroy();
	    echo "<script>window.location.href='".$HOME_URL."'</script>";
		exit;
	}

    // 檢查是否有傳遞資料
    if( !isset($_POST['mid']) || !isset($_POST['content']) ) {
	    echo "<script>window.location.href='".$HOME_URL."'</script>";
	    exit;
	}
	
	
	// 從資料庫中 找出看板的標題
	$TABLENAME = "message".$_SESSION['fid'];	
	$RESPONAME = "respon".$_SESSION['fid'];
	$uid     = $_SESSION['uid'];   // 會員id
	$mid     = $_POST['mid'];      // 文章id
	$fid     = $_SESSION['fid'];   //現在討論板id
	$content =  check_input($_POST['content']);  // 回覆內容、確認資料的正確性
	$ip      = $_SERVER['REMOTE_ADDR'];
	$n       = $_POST['n'];        // 原 input type=text id 值

		
	$sql = "INSERT INTO $RESPONAME (mid,uid,content,ip)";
	$sql.= " VALUES($mid,$uid,'$content','$ip')";
	
	$result = $db->exec($sql);

	// 有登入才能回覆
	if ( isset($_SESSION['nickname']) ) {
		$str="          <div class='replytext'>\n";
		$str.="             <div class='replytext1'><span class='icon-pencil2'></span></div>\n";
		$str.="             <input class='replytext2' type='text' size=80 id='respon$n' placeholder='立即回覆'  style='display:inline'>";
		$str.="             <input class='replytext3' type='button' value='回覆'  style='display:inline' onclick=sendRespon($mid,document.getElementById('respon$n').value,'responDiv$n',$n)>\n";
		$str.="         </div>\n";
		}
	
	// 重新找尋此文章 回覆內容的所有記錄	
	// 找出此文章的回覆內容
	$sql = "SELECT r.content,m.nickname,r.time,r.rid ";
	$sql.= "  FROM $RESPONAME as r";
	$sql.= " LEFT JOIN member as m";
	$sql.= " ON r.uid=m.uid";
	$sql.= " WHERE mid=$mid";
	$sql.= " ORDER BY r.rid";
	
	$stm = $db->prepare($sql);
	$stm->execute();
	while( ($row=$stm->fetch()) ) {
		$nickname = $row['nickname'];
		$content  = $row["content"];
		$time     = $row["time"];
		$rid      = $row["rid"];

		$str.="             <div class='replycontent'>\n";
		$str.="                 <div class='replycontent0'>&nbsp;</div>\n";
		$str.="                 <div class='replycontent1'>\n";
		$str.="                     <span class='icon-user'></span>&nbsp; user: $nickname\n";
		$str.="                     <p style='font-size: 12px; paddin:0px;'>(".$time.")</p>\n";
		$str.="                 </div>\n";
		$str.="                 <span class='replycontent2'><p>$content</p></span>\n";		
		
		//有登入、有管理權限，才會出現刪除按鈕
		if(isset($_SESSION['uid']) && isset($_SESSION['admin'])){
			if(checkAdminFid($fid) && is_numeric($rid) ||  $_SESSION['admin']==0) {
				$str.="          <button type='button' class='replycontent3' class='btn-primary' onclick='del_respon($rid,$fid)'>刪除</button>\n";	
				}
		}	
			
		$str.="              </div>\n";
		}
	
		

	
	echo $str;
?>


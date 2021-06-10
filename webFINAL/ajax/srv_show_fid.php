<?PHP
     include "tools.php";
	 
    // 不管有無登入, 都利用session存放要看的討論版代號
    session_start();
	$_SESSION['fid'] = Intval($_POST['fid']);
	$fid =  $_SESSION['fid'];
	;

    // 第2個 資料庫連線
	$rd = new PDO($dsn, $db_user,$db_passwd);
	
	// 從資料庫中 找出看板的標題
	$TABLENAME = "message".$_SESSION['fid'];
	$RESPONAME = "respon".$_SESSION['fid'];
	$sql = "SELECT f.mid,f.uid,f.title,f.content,f.time,f.longitude,f.latitude, f.health, f.feed, m.nickname
              FROM $TABLENAME as f 
              LEFT JOIN member as m
                ON f.uid=m.uid
            ORDER BY f.mid";

	$sth = $db->prepare($sql);
    $sth->execute();	
	$str = "";	

    $n = 1;
	while( ($row=$sth->fetch()) ) {
		$mid      = $row["mid"];
		$title    = $row["title"];
		$content  = $row["content"];
		$lat      = $row["latitude"];
		$lng      = $row["longitude"];
		$health   = $row["health"];
		$feed     = $row["feed"];
		$nickname = $row["nickname"];
		$time     = $row['time'];

		//處理換行排版		 
		$content = str_replace("\n", "<br>", $content);
		
		// 組出 討論區 區塊內容
		$str.="<div id='discuss_".$n.">\n";
		$str.="    <div class='discuss-body'>\n";
		$str.="        <div class='card'>\n";
		$str.="            <div class='card-header'>\n";
		$str.="                <div class='card-header-title'>\n";		
		$str.="                    <h3 class='card-header-title1'> $title </h3>\n";

		
		//如果是全域管理者或是有權力管理該看板，就會出現「刪除」按鈕
		if(isset($_SESSION['uid']) && isset($_SESSION['admin'])){
			if( checkAdminFid($fid) ||  $_SESSION['admin']==0 ) {
				$str.="            <button type='button' class='card-header-title2' class='btn-primary' onclick='del_discuss($mid,$fid)'><span class='icon-cross'></span></button>\n";	
				}
		}
		$str.="                </div>\n";
		//tags
		$str.="                <ul class='tags'>\n";
		//經緯度，四捨五入，取小數點後四位
		if($lat != 0 && $lng != 0){
			$lat = round($lat, 4);
			$lng = round($lng, 4);
			$str.="               <li><a href='#' class='tag'>#".$lat.", ".$lng."</a></li>\n"; 
		}
		//健康
		if($health == "unhealthy")
			$str.="               <li><a href='#' class='tag'>#不健康</a></li>\n"; 
		//餵食
		if($feed == "feed")
			$str.="               <li><a href='#' class='tag'>#有餵食</a></li>\n";		
		
		$str.="               </ul>\n";
		$str.="                <div class='card-header-user'>\n";
		$str.="                    <span class='icon-user'></span>&nbsp; user: $nickname\n";		
		$str.="            	       <p class='card-time'>$time </p>\n";		
		$str.="                </div>\n";		
		$str.="            </div>\n";		
		$str.="            <div class='card-body'>\n";		
		$str.="                <p class='card-text'>$content</p>\n";
        $str.="           </div>\n";        


		$str.="        <div class='replybody' id=responDiv$n>\n";
		// 有登入才能回覆
		if ( isset($_SESSION['nickname']) ) {
		    $str.="         <div class='replytext'>\n";
			$str.="             <div class='replytext1'><span class='icon-pencil2'></span></div>\n";
			$str.="             <input class='replytext2' type='text' size=80 id='respon$n' placeholder='立即回覆'  style='display:inline'>";
			$str.="             <input class='replytext3' type='button' value='回覆'  style='display:inline' onclick=sendRespon($mid,document.getElementById('respon$n').value,'responDiv$n',$n)>\n";
			$str.="         </div>\n";
			}
		//撈回覆資料
		$sql = "SELECT r.content,m.nickname,r.time,r.rid";
		$sql.= "  FROM $RESPONAME as r";
		$sql.= " LEFT JOIN member as m";
		$sql.= " ON r.uid=m.uid";
		$sql.= " WHERE r.mid=$mid";
		$sql.= " ORDER BY r.rid";	
		
        $stm = $rd->prepare($sql);
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
		
		$str.="             </div>\n";
        $str.="        </div>\n";
        $str.="    </div>\n";
        $str.="</div>\n";
		$n++;
		}
		
	
	echo $str;
	
?>
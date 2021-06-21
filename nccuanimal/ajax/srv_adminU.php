<?PHP

session_start();
include "tools.php";
if ( !isset($_SESSION['uid']) ) {
    session_destroy();
    echo "<script>window.location.href='".$HOME_URL."'</script>";
    exit;
}

if( !isset($_SESSION['admin']) && !isset($_POST["type"]) ){
    echo "<script>window.history.back();</script>";
    exit;
}    




if( $_POST["type"]==1 )
    showU();
    
else if( $_POST["type"]==2 )
    showF(); 
else if( $_POST["type"]==3 )
    confirm(); 

exit;

//下拉式選單 顯示所有使用者
function showU() {
    global $db;   
    
    $sql = "SELECT m.uid, m.username, m.nickname
	            FROM member m
                ORDER BY m.uid";    
    
    $sth = $db->prepare($sql);    
    $sth->execute();
    
    $str ="<option value=''>uid, username, nickname</option>\n";
    $n = 1;
    while( ($row=$sth->fetch()) ) {
        $uid      = $row["uid"];
        $username = $row["username"];
        $nickname = $row["nickname"];
        
        //不能新增自己
        if($uid == $_SESSION['uid'])
            continue;
    
        $str .=   "<option value=$uid>$uid, $username, $nickname</option>\n";          
        $n++;
    }
    echo $str;    
}

//下拉式選單 顯示管理權限內的看板
function showF() {
    global $db;

    if($_SESSION['admin']==0){
        $sql = "SELECT DISTINCT f.forum,f.fid
                    FROM forum f";               
                        
    }else{
        $sql = "SELECT DISTINCT f.forum,a.fid
            FROM admin a                
                LEFT JOIN forum f ON a.fid = f.fid";
        $sql .= "\nWHERE a.fid in( ".$_SESSION['admin']." )";
        $sql .= "\nORDER BY a.fid";  

    } 

    $sth = $db->prepare($sql);    
    $sth->execute();

    $str = "<option value=''>fid, forum</option>\n";
    $n = 1;
    while( ($row=$sth->fetch()) ) {
        $fid      = $row["fid"];
        $forum    = $row["forum"];
        
        if($fid == 0)
            $str .=   "<option value=$fid>$fid, 全域</option>\n"; 
        else    
            $str .=   "<option value=$fid>$fid, $forum</option>\n";          
        $n++;
    }
    echo $str;
}

//確認選取的使用者是否可成為管理員
function confirm(){
    global $db; 

    if(!isset($_POST["user"]) || !isset($_POST["forum"])){
        echo json_encode( array("result" => "ERROR", "message"=>"[資料傳輸錯誤]", "field"=>"all_user" ) );
        exit;
    }
    
    $uid = $_POST["user"];
    $fid = $_POST["forum"];

    //如果沒選使用者，
    if($uid == ""){
        echo json_encode( array("result" => "ERROR", "message"=>"[請選擇使用者]", "field"=>"all_user" ) );
        exit;
    }
    //如果沒選管理的看板，
    if($fid == ""){
        echo json_encode( array("result" => "ERROR", "message"=>"[請選擇管理的看板]", "field"=>"all_forum" ) );
        exit;
    }

    $uid = intval($uid);
    $fid = intval($fid);
    
    //檢查選擇的人是否已經能管理選擇的看板：透過uid、fid撈admin裡面的筆數，如果=1就代表已管理
    $sth = $db->prepare("SELECT count(*) T FROM admin WHERE uid = :uid AND fid = :fid");
    $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
    $sth->bindParam(':fid', $fid, PDO::PARAM_INT);
    $sth->execute();
	$rows = $sth->fetchAll();

    $T = $rows[0]['T'];
	if( $T>0 ) {
		echo json_encode( array("result" => "ERROR", "message"=>"[該使用者已能管理此看板，請另選使用者]", "field"=>"all_user" ) );
		exit;
	}
    else{       
        $sth = $db->prepare("INSERT INTO admin (uid,fid) VALUES(:uid,:fid)");
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
        $sth->bindParam(':fid', $fid, PDO::PARAM_INT);
        $sth->execute();
        
        echo json_encode( array("result" => "OK", "message"=>"[新增管理員成功]") );

    }
}

?>
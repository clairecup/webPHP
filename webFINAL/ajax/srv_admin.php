<?PHP

include "tools.php";
session_start();



if(isset($_SESSION['admin'])){
    if( isset($_POST["uid"]) && isset($_POST["fid"])){
        if($_POST["uid"] != $_SESSION['uid'])//管理員自我不能免職，session uid跟post過來的uid不同         
            del_admin(); 
        else
            show();  
    }else//沒有傳送東西過來，就單純顯示畫面
        show();    

}else{
    echo "<script>window.location.href='".$HOME_URL."'</script>";//沒有管理權限，跳回首面
    exit;
}


    

function del_admin() {
    global $db;

    $uid = $_POST["uid"];
    $fid = $_POST["fid"];

    if(checkAdminFid($fid) ||  $_SESSION['admin']==0 ){
        $sql = "DELETE FROM admin WHERE uid= :uid AND fid= :fid";

        $sth = $db->prepare($sql);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
        $sth->bindParam(':fid', $fid, PDO::PARAM_INT);    
        $sth->execute(); 
    }
    
    show();        
   
    

}

function show() {
    global $db;

    //從資料庫中 找出管理者的權限
    $sql = "SELECT a.uid,m.nickname,f.forum,a.fid
            FROM admin a
                LEFT JOIN member m ON a.uid = m.uid
                LEFT JOIN forum f ON a.fid = f.fid";
    
    if( $_SESSION['admin']!=0 )
        $sql .= "\nWHERE a.fid in( ".$_SESSION['admin']." )";
    
    $sql .= "\nORDER BY a.uid";
    //echo $sql;
    //exit;
    $sth = $db->prepare($sql);    
    $sth->execute();

    $n = 1;
    $str = "";
    while( ($row=$sth->fetch()) ) {
    $uid      = $row["uid"];
    $nickname = $row["nickname"];
    $forum    = $row["forum"];
    $fid      = $row["fid"];

    
    // 組出 管理者表單 內容
    $str .=   "<table class='user_".$n."' class='ad_table'>\n";
    $str .=    "<tr>\n";    
    $str .=      "<td width='20%'>$uid</td>\n";
    $str .=      "<td width='20%'>$nickname</td>\n";
    if( $fid==0)
        $str .=  "<td width='20%'>全域</td>\n";
    else
        $str .=  "<td width='20%'>$forum</td>\n";
    $str .=      "<td width='20%'><button type='button' class='btn-primary' onclick='del($uid, $fid)'>刪除</button></tr>\n";
    $str .=   "</tr>\n";
    $str .=   "</table>\n";   

    $n++;
    }   

    echo $str;   
}



?>
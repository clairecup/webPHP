<?PHP

include "tools.php";
	 
// 不管有無登入, 都利用session存放要看的討論版代號
session_start();
$_SESSION['fid'] = Intval($_POST['fid']);
$fid =  $_SESSION['fid'];
;

// 從資料庫中 找出看板的標題

$sql = "SELECT * FROM forum where fid=$fid";

$sth = $db->prepare($sql);
$sth->execute();	
$str = "";
$row=$sth->fetchAll();

    $name        = $row[0]["forum"];
    $animal       = $row[0]["animal"];
    $introduce   = $row[0]["introduce"];
    $nickname    = $row[0]["nickname"];
    $features    = $row[0]["features"];
    $characters  = $row[0]["characters"];
    $places      = $row[0]["places"];
    $socialmedia = $row[0]["socialmedia"];
    $imageurl    = $row[0]['imageurl'];
    $iconurl     = $row[0]['iconurl'];

    if($introduce=="") $introduce ='偶還沒有自我介紹（；へ：）';
    if($nickname=="") $nickname ='還沒有人幫偶取綽號（；へ：）';
    if($features=="") $features ='偶還沒有自我介紹（；へ：）';
    if($characters=="")$characters ='沒有人紀錄（；へ：）';
    if($places=="") $places ='沒有人紀錄（；へ：）';

    //處理換行排版		 
    $introduce = str_replace("\n", "<br>", $introduce);

    // 組出 介紹 區塊內容
    $str.="<div class='container'>\n";
    $str.="    <div id='namecard' class='row'>\n";
    $str.="        <div class='col-5' style='text-align: center;'>\n";
    $str.="           <div class='col'><h5>$name</h5></div>\n";
    $str.="            <img class='rounded float-start' src='$imageurl' alt='$animal' style='height: 250px;'>\n";
    $str.="        </div>\n";
    $str.="        <div class='col-7'>\n";
    $str.="            <p style='font-size: smaller;'>$introduce</p>\n";
    $str.="           <dl class='row' id='list'>\n";
    $str.="               <dt class='col-sm-3'>別名</dt>\n";
    $str.="                <dd class='col-sm-9'>$nickname</dd>\n";
    $str.="                <dt class='col-sm-3'>特徵</dt>\n";
    $str.="                <dd class='col-sm-9'>$features</dd>\n";
    $str.="                <dt class='col-sm-3'>個性</dt>\n";
    $str.="                <dd class='col-sm-9'>$characters</dd>\n";
    $str.="                <dt class='col-sm-3'>出沒地</dt>\n";
    $str.="                <dd class='col-sm-9'>$places</dd>\n";
    $str.="                <dt class='col-sm-3'>個人帳號</dt>\n";
    if($socialmedia=="")
        $str.="            <dd class='col-sm-9'>沒有人紀錄（；へ：）</dd>\n";
    else
        $str.="            <dd class='col-sm-9'><a href='$socialmedia' target='_blank'><i class='fab fa-instagram fa-3x' ></i></a></dd>\n";
    $str.="            </dl>\n";
    $str.="        </div>\n";
    $str.="    </div>\n";
    $str.="<div \n";   

echo $str;

?>
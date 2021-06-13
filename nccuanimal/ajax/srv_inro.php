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
    if($features=="") $features ='沒有人紀錄（；へ：）';
    if($characters=="")$characters ='沒有人紀錄（；へ：）';
    if($places=="") $places ='沒有人紀錄（；へ：）';

    //處理換行排版		 
    $introduce = str_replace("\n", "<br>", $introduce);

    // 組出 介紹 區塊內容
    $str.="<center>\n";
    $str.="<div class='container'>\n";
    $str.="    <div id='namecard' class='row'>\n";
    $str.="        <div style='text-align: center;'>\n";
    $str.="        </div>\n";
    $str.="        <div style='display:inline;'>\n";

    $str.="        <center>\n";
    $str.="        <p style='display:inline;'><h2>$name</h2></p>\n";
    $str.="           <table align='center' cellspacing='30'  style='display:inline;'>\n";
        $str.="           <tr>\n";
        $str.="               <td width='300px'>\n";
        $str.="                   <img class='rounded float-start' src='$imageurl' alt='$animal' style='height: 300px;' >\n";
        $str.="               </td>\n";

        $str.="               <td width='800px'>\n";
        $str.="                   <table align='center' cellspacing='30'  style='display:inline;'>\n";
        $str.="                       <tr><td colspan='2'>$introduce</td></tr>\n";
        $str.="                       <tr><td><strong>別名</strong></td><td>$nickname</td></tr>\n";
        $str.="                       <tr><td><strong>特徵</strong></td><td>$features</td></tr>\n";
        $str.="                       <tr><td><strong>個性</strong></td><td>$characters</td></tr>\n";
        $str.="                       <tr><td><strong>出沒地</strong></td><td>$places</td></tr>\n";
        $str.="                       <tr><td><strong>個人帳號</strong></td>\n";
        if($socialmedia=="")
            $str.="                       <td>沒有人紀錄（；へ：）</td></tr>\n";
        else
            $str.="                       <td><a href='$socialmedia' target='_blank'><i class='fab fa-instagram fa-3x' ></i></a></td>\n";
        $str.="                       </tr>\n";
        $str.="                    </table>\n";
        $str.="               </td>\n";
        $str.="           </tr>\n";
    $str.="            </table>\n";
    $str.="        </center>\n";

    $str.="        </div>\n";
    $str.="    </div>\n";
    $str.="<div>\n";
    $str.="<center>\n";

echo $str;

?>
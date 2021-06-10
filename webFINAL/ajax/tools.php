<?PHP
//PHP共用設定
    // 資料庫連接設定
    $db_server = "localhost";
    $db_user = "msgUser";
    $db_passwd = "msgUser123";
    $db_name = "webFINAL"; 
    
    try{
        $dsn = "mysql:host=$db_server;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_passwd);        
    }
    catch(Expection $E){
        die('無法對資料庫連線');
    } 

    // 定義網站的 相對路徑
	$HOME_TITLE = "政大小動物追蹤網";
	$HOME_URL = "/webFINAL";
    $DISCUSS_URL = $HOME_URL."/discuss.php";
    

    // 過濾輸入欄位的特殊字元
    function check_input($data, $max=0) {
        $data = trim($data);
        //$data = stripslashes($data);
        $data = addslashes($data);//將特殊字元前面加上導斜線，始之失去作用
        $data = htmlspecialchars($data);//將HTML特殊字元限制執行，只能看
		if( $max>0 && strlen($data)>$max ) {//如果開的字元空間長度大於0，且字串長度超過允許空間
			$data = substr($data,0,$max);//只允許使用者在允許範圍內輸入
		}
        return $data;
    }

    function checkAdminFid( $fid ) {
        $arrAdmin = explode(",",$_SESSION['admin']);
        return in_array($fid,$arrAdmin);
    }

    $orange="小橘";
    $huahua="花花";
    $tiger="胖虎";

?>
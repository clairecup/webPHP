<?PHP     
      include "tools.php";
      session_start();
    
    // 確定登入狀態
    if ( !isset($_SESSION['uid']) ) {
        session_destroy();
        echo "<script>window.location.href='".$HOME_URL."'</script>";
        exit;
    }
    //確定有資料傳遞
    if(  !isset($_SESSION['admin']) && !isset($_POST['type']) ){
        echo json_encode( array("result" => "ERROR", "message"=>"無權限" ) );
        exit;
    } 

    if( $_POST["type"]==1 )
        del_mes();
    else if ( $_POST["type"]==2 )
        del_res();
    else if ( $_POST["type"]==3 )
        new_forum();


    function del_mes(){
        global $db;
        $mid = Intval($_POST['mid']);
        $fid = Intval($_POST['fid']);

        $TABLENAME = "message".$fid;
        $RESPONAME = "respon".$fid;

        if(checkAdminFid($fid) ||  $_SESSION['admin']==0 ){//檢查權限
            //刪除主題
            $sql = "DELETE FROM $TABLENAME WHERE mid = :mid";      
            $sth = $db->prepare($sql);
            $sth->bindParam(':mid', $mid, PDO::PARAM_INT);           
            $sth->execute();

            //刪除回應
            $sql = "DELETE FROM $RESPONAME WHERE mid= :mid";
            $sth = $db->prepare($sql);
            $sth->bindParam(':mid', $mid, PDO::PARAM_INT);           
            $sth->execute();

            echo json_encode( array("result" => "OK", "message"=>"[成功刪出主題]") );
        }else{
            echo json_encode( array("result" => "ERROR", "message"=>"[無管理權限，刪出失敗]") );
            exit;
        }

        

    }

    function del_res(){
        global $db;
        $rid = Intval($_POST['rid']);
        $fid = Intval($_POST['fid']);

        $RESPONAME = "respon".$fid;
        if(checkAdminFid($fid) ||  $_SESSION['admin']==0 ){//檢查權限
            //刪除回應
            $sql = "DELETE FROM $RESPONAME WHERE rid= :rid";
            $sth = $db->prepare($sql);
            $sth->bindParam(':rid', $rid, PDO::PARAM_INT);           
            $n = $sth->execute();
            if( $n==1 )
                echo json_encode( array("result" => "OK", "message"=>"[成功刪出".$n."筆回應],\n") );
            else
                echo json_encode( array("result" => "ERROR", "message"=>"[刪出回應失敗]\n") );

        }else{
            echo json_encode( array("result" => "ERROR", "message"=>"[無管理權限，刪出失敗]") );
            exit;
        }
        
    }
    function new_forum(){
        global $db;

        //檢查權限
        if( $_SESSION['admin'] != 0 ){
            echo json_encode( array("result" => "ERROR", "message"=>"[無管理權限，無法新增看板]") );
            exit;
        }
        

        // 檢查是否有傳遞資料
        if(!isset($_POST['forum']) || !isset($_POST['animalType']) ) {
            echo json_encode( array("result" => "ERROR", "message"=>"資料傳遞錯誤", "field"=>"forum" ) );
            exit;
        }
      

        // 取用資料並確認資料的正確性
        $forum         = check_input( $_POST['forum'] , 20 );
        $animalType    = $_POST['animalType'];
        $introduction  = check_input($_POST['introduction'] ); 
        $nickname      = check_input($_POST['nickname']);
        $feature       = check_input($_POST['feature'] ); 
        $characters    = check_input($_POST['characters']); 
        $places        = check_input($_POST['places']); 
        $href          = check_input($_POST['href'] );         
        
        if( $forum=="" ) {
            echo json_encode( array("result" => "ERROR", "message"=>"請填寫[新動物名稱]", "field"=>"new_forum_name" ) );
            exit;
        }

        if( mb_strlen($forum, "utf-8") >= 7){
            echo json_encode( array("result" => "ERROR", "message"=>"[現為 ".mb_strlen($forum, "utf-8")." 個字，名稱過長，請設定7個字以內的名稱]", "field"=>"new_forum_name") );
            exit;
        }
        if( $animalType=="" ) {
            echo json_encode( array("result" => "ERROR", "message"=>"請填寫[新動物種類]", "field"=>"animalType") );
            exit;
        }

        //進資料庫檢查 forum 不能重複
        $sth = $db->prepare("SELECT count(*) T FROM forum WHERE forum = :forum");
        $sth->bindParam(':forum', $forum, PDO::PARAM_STR);
        $sth->execute();
        if( $sth->errorCode()==0 ) {
            $rows = $sth->fetchAll();

            // 取出 forum 的筆數 大於 0 --> 帳號重複
            $T = $rows[0]['T'];
            if( $T>0 ) {
                echo json_encode( array("result" => "ERROR", "message"=>"[看板名稱重複] ".$forum ) );
                exit;
            }
        }
        else {
            $errors = $sth->errorInfo();
            echo($errors[2]);
        }

        // 將輸入的資料 新增至 資料庫forum
        $sql = "INSERT INTO forum (forum, animal, introduce, nickname, features, characters, places, socialmedia)";
        $sql.= " VALUES(:forum,:animal,:introduce,:nickname,:features,:characters,:places,:socialmedia)";
        $sth = $db->prepare($sql);

		$sth->bindParam(':forum'      , $forum       , PDO::PARAM_STR);
		$sth->bindParam(':animal'     , $animalType  , PDO::PARAM_STR);
		$sth->bindParam(':introduce'  , $introduction, PDO::PARAM_STR);
		$sth->bindParam(':nickname'   , $nickname    , PDO::PARAM_STR);
		$sth->bindParam(':features'   , $feature     , PDO::PARAM_STR);
		$sth->bindParam(':characters' , $characters  , PDO::PARAM_STR);
		$sth->bindParam(':places'     , $places      , PDO::PARAM_STR);
		$sth->bindParam(':socialmedia', $href        , PDO::PARAM_STR);

        $sth->execute(); 
		
        //撈出該筆看板名稱的fid
        //$sth = $db->prepare("SELECT fid FROM forum WHERE forum = :forum");
        $sth = $db->prepare("SELECT fid FROM forum WHERE forum =:forum");
        $sth->bindParam(':forum', $forum, PDO::PARAM_STR);
        $sth->execute();        
        $rows = $sth->fetchAll();
        
        $fid =  $rows[0]['fid'];
        $messageTable = "message".$fid;
        $responTable = "respon".$fid;

        //在資料表中新增對應的message TABLE
        $createM = "CREATE TABLE $messageTable (
                        `mid` int(11) NOT NULL COMMENT '文章id',
                        `uid` int(11) NOT NULL COMMENT '貼文者id',
                        `title` varchar(256) NOT NULL COMMENT '標題',
                        `content` varchar(1024) NOT NULL COMMENT '內容',
                        `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
                        `longtitude` double NOT NULL COMMENT '經度',
                        `latitude` double NOT NULL COMMENT '緯度',
                        `health` varchar(11) NOT NULL COMMENT '健康狀態',
                        `feed` varchar(11) NOT NULL COMMENT '有無餵食',
                        `ip` varchar(64) NOT NULL COMMENT '發文者IP'
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    ALTER TABLE $messageTable ADD PRIMARY KEY (`mid`);

                    ALTER TABLE $messageTable
                        MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=1;   
                    ";
        $sth = $db->prepare($createM);
        //$sth->bindParam(':messageTable', $messageTable, PDO::PARAM_STR);
        $sth->execute();

        //在資料表中新增對應的respon TABLE
        $createR = "CREATE TABLE $responTable (
                        `rid` int(11) NOT NULL COMMENT '回覆文章id',
                        `mid` int(11) NOT NULL COMMENT '文章id ',
                        `uid` int(11) NOT NULL COMMENT '回覆者id ',
                        `content` varchar(1024) NOT NULL COMMENT '回覆內容',
                        `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
                        `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    ALTER TABLE $responTable ADD PRIMARY KEY (`rid`);

                    ALTER TABLE $responTable
                        MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=1;                  
                    
                    ";
        $sth = $db->prepare($createR);
        //$sth->bindParam(':responTable', $responTable, PDO::PARAM_STR);
        $sth->execute();

        //賦予管理權限        
        if($_SESSION['admin'] != 0){
            //寫進admin資料表
            $sql = "INSERT INTO admin (uid,fid) values(:uid,:fid)"; 
            $sth = $db -> prepare($sql);
            $sth->bindParam(':uid', $_SESSION['uid'], PDO::PARAM_INT);
            $sth->bindParam(':fid', $fid, PDO::PARAM_INT);
            $sth -> execute();
            
            //寫入session管理權限
            $_SESSION['admin'].=",".$fid;
        }


        
        
        echo json_encode( array("result" => "OK", "message"=>"[成功新增看板]", "fid"=>"$fid" ) );

    
    }


?>

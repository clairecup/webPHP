<?php
    include "ajax/tools.php";
    session_start();
    if ( !isset($_SESSION['uid']) ) {		
        session_destroy();
		echo "<script>window.location.href='".$HOME_URL."'</script>";
		exit;
    }

    $whiteList = array('jpg', 'png','jpeg','gif');    
    //$newDir = "./uploadFile/";
    $newDir = "./uploadFile".$_SESSION['dir']."/";
    if( !file_exists($newDir))
        mkdir($newDir , 0700);

    if($_FILES["file"]["name"] != NULL){
        // explode: 切割字串, end: 取最後一個結果
        $extension = @strtolower(end(explode(".", $_FILES["file"]["name"])));
        if( in_array($extension, $whiteList) && $_FILES["file"]["size"] <= 2048 * 2048){
            if( !in_array($extension, $whiteList) ){
                $resultStr = "檔案類型錯誤!!，僅接受jpg、png、jpeg、gif 四種格式";
                echo json_encode( array("result" => "ERROR", "message"=>$resultStr ) );               
            }else if($_FILES["file"]["size"] >= 2048 * 2048){
                $resultStr = "檔案過大!!，僅接受 2048 * 2048 以內的圖檔";
                echo json_encode( array("result" => "ERROR", "message"=>$resultStr ) );         
            }else{
            $newFilePath = $newDir.time().".".$extension;
            //$resultStr = 'Submit file OK, link is: <a href="'.$newFilePath.'">'.$newFilePath.'</a>';
            $resultStr = "<img id='upIMG' src=".$newFilePath." width='100px'>";
            move_uploaded_file($_FILES["file"]["tmp_name"], $newFilePath);
            echo json_encode( array("result" => "OK", "message"=>$resultStr, "url"=>$newFilePath ) );
        }
        
        }
        else {
            $resultStr = "未上傳檔案!!";
            echo json_encode( array("result" => "ERROR", "message"=>$resultStr ) );     
        }
    }
    
?>
    
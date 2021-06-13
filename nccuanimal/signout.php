<?PHP
    include "ajax/tools.php";
    session_start();
    //刪除其檔案目錄
    $dir= "./uploadFile".$_SESSION['dir']."/";
    if( file_exists($dir))
        @rmdir($dir);
	session_destroy();
	echo "<script>window.location.href='".$HOME_URL."'</script>";
?>
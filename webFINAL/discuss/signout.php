<?PHP
    include "ajax/tools.php";
    session_start();
	session_destroy();
	echo "<script>window.location.href='".$HOME_URL."'</script>";
?>
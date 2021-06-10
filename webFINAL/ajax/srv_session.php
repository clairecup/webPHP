<?PHP
session_start();
$_SESSION['fid'] = Intval($_POST['fid']);
$_SESSION['mid'] = Intval($_POST['mid']);
$_SESSION['forum'] = $_POST['forum'];
?>
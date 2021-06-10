<?PHP
    include ".././ajax/tools.php";
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h4><?PHP echo $HOME_TITLE;?></h4>
    <div class="container">
        <!--插在這裡-->
    <i class="fas fa-map-marked-alt fa-2x"></i>
        <div id="namecard" class="row">
            <div class="col-5" style="text-align: center;">
                <div class="col"><h5>花花</h5></div>
                <img class="rounded float-start" src="image\huahua.jpg" alt="a dog" style="height: 270px;">
            </div>
            <div class="col-7">
                <p style="font-size: smaller;">大家好，我是政大花花！今年不知道幾歲！興趣是閉眼聽課，專長是搭電梯，綜院跟國際大樓都會。</p>
                <dl class="row" id="list">
                    <dt class="col-sm-3">別名</dt>
                    <dd class="col-sm-9">斑斑、大花、胖花</dd>
                    <dt class="col-sm-3">特徵</dt>
                    <dd class="col-sm-9">深色玳瑁花紋、有戴項圈</dd>
                    <dt class="col-sm-3">個性</dt>
                    <dd class="col-sm-9">溫和沉穩，十分好學，政大校園最友善的狗狗</dd>
                    <dt class="col-sm-3">出沒地</dt>
                    <dd class="col-sm-9">山上山下都可以看到花花的足跡！</dd>
                    <dt class="col-sm-3">個人帳號</dt>
                    <dd class="col-sm-9"><a href="https://www.instagram.com/huahualufyou/" target="_blank">Instagram</a></dd>
                </dl>
            </div>
        </div>
    <div id="bar">
        <a href="#"><img id="icon" class="img-thumbnail" src="image\icon_huahua.jpg"></a>
        <a href="orange.php"><img id="icon" class="img-thumbnail" src="image\icon_orange.jpg"></a>
        <a href="tiger.php"><img id="icon" class="img-thumbnail" src="image\icon_tiger.jpg"></a>
    </div>
    </div>
</body>
</html>
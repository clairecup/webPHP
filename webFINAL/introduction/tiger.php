<?PHP
    include ".././ajax/tools.php";
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h4><?PHP echo $HOME_TITLE;?></h4>
    <div class="container">
        <div id="namecard" class="row">
            <div class="col-5" style="text-align: center;">
                <div class="col"><h5>胖虎</h5></div>
                <img class="rounded float-start" src="image\tiger.jpg" alt="a dog" style="height: 250px;">
            </div>
            <div class="col-7">
                <p style="font-size: smaller;">愛被拍屁股、沒節操、
                    超級聰明的肥大叔。</p>
                <dl class="row" id="list">
                    <dt class="col-sm-3">別名</dt>
                    <dd class="col-sm-9">阿肥、老大</dd>
                    <dt class="col-sm-3">特徵</dt>
                    <dd class="col-sm-9">深色虎斑貓、綠瞳孔</dd>
                    <dt class="col-sm-3">個性</dt>
                    <dd class="col-sm-9">任性、桀傲不遜、自由奔放</dd>
                    <dt class="col-sm-3">出沒地</dt>
                    <dd class="col-sm-9">莊外、莊內</dd>
                    <dt class="col-sm-3">個人帳號</dt>
                    <dd class="col-sm-9"><a href="https://www.instagram.com/fluffycat_fatty/" target="_blank">Instagram</a></dd>
                </dl>
            </div>
        </div>
    <div id="bar">
        <a href="huahua.html"><img id="icon" class="img-thumbnail" src="image\icon_huahua.jpg"></a>
        <a href="orange.html"><img id="icon" class="img-thumbnail" src="image\icon_orange.jpg"></a>
        <img id="icon" class="img-thumbnail" src="image\icon_tiger.jpg">
    </div>
    </div>
</body>
</html>
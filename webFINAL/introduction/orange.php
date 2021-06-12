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
                <div class="col"><h5>小橘</h5></div>
                <img class="rounded float-start" src="image\orange.jpg" alt="a dog" style="height: 250px;">
            </div>
            <div class="col-7">
                <p style="font-size: smaller;">嗨，我是小橘，住在政大莊九女宿外，今年四歲，經常在女宿外面賣萌睡覺，喜歡的東西是肉泥、枯樹枝、名車與太陽。</p>
                <dl class="row" id="list">
                    <dt class="col-sm-3">別名</dt>
                    <dd class="col-sm-9">火星、虎皮</dd>
                    <dt class="col-sm-3">特徵</dt>
                    <dd class="col-sm-9">貓如其名、金瞳孔</dd>
                    <dt class="col-sm-3">個性</dt>
                    <dd class="col-sm-9">慵懶愜意、善於放電而不自知</dd>
                    <dt class="col-sm-3">出沒地</dt>
                    <dd class="col-sm-9">莊敬九舍、教育系館、憩賢樓</dd>
                    <dt class="col-sm-3">個人帳號</dt>
                    <dd class="col-sm-9"><a href="https://www.instagram.com/littleorange_nccu/" target="_blank">Instagram</a></dd>
                </dl>
            </div>
        </div>
    <div id="bar">
        <a href="huahua.html"><img id="icon" class="img-thumbnail" src="image\icon_huahua.jpg"></a>
        <img id="icon" class="img-thumbnail" src="image\icon_orange.jpg">
        <a href="tiger.html"><img id="icon" class="img-thumbnail" src="image\icon_tiger.jpg"></a>
    </div>
    </div>
</body>
</html>
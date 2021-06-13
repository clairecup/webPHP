<?PHP
    session_start();
    if ( isset($_SESSION['uid']) ) {              
        $funcName = "<li><span class='icon-user'></span></li>";        
	    $funcName.= "<li>Hi, ".$_SESSION['nickname']."&nbsp;</li>";
        if( isset($_SESSION['admin'])){
            $funcName.= "<li><a href='admin.php' class='a'>管理</a></li>";
        } 		
		$funcName.= "<li><a href='modify.php' class='a'>修改帳戶</a></li>";
        $funcName.= "<li><a href='post.php' class='a'>新增貼文</a></li>";
        $funcName.= "<li><a href='signout.php' class='a'>登出</a></li>";        		
    }
    else {
	    $funcName = "<li><a href='signin.php' class='a'>登入</a></li>";
        $funcName.= "<li><a href='signup.php' class='a'>註冊</a></li>";
    }

    include "ajax/tools.php";
	
	//---------------------------------
	// 產出討論版區塊
	//---------------------------------
    $record=[];
	$sth = $db->prepare("SELECT fid,forum,imageurl,iconurl,mapIcon FROM forum ORDER BY fid");
    $sth->execute();
	$board_str = "";
    if( isset($_SESSION['admin']) && $_SESSION['admin']==0 ){
        $board_str.= "<tr><td width=100%>
                            <center><button onclick='show_new_forum()'><span class='icon-plus'></span></button><center>
                        </td></tr>  \n";
    }

    $marker ="";
    
	while( ($row=$sth->fetch()) ) {
		$fid      = $row["fid"];
		$forum    = $row["forum"];
        $imageurl = $row["imageurl"];
        $iconurl  = $row["iconurl"];
        $mapIcon  = $row["mapIcon"];

        $board_str.= "<tr height=32px><td width=100%>\n";        
		$board_str.= "<button class='btn-equal-width' id='forum$fid' value='$forum' onclick=\"viewBoard($fid,'$forum')\"><img src='$iconurl' class='imgD' style='display:inline;vertical-align:middle;'><h2 style='display:inline;vertical-align:middle;'>$forum</h2></button>\n";
		$board_str.= "</td></tr>\n";
        /*
        $board_str.= "<tr height=32px>\n";
        $board_str.= "    <td width=100%>\n"; 
        $board_str.= "    <button class='btn-equal-width' id='forum$fid' value='$forum' onclick=\"viewBoard($fid,'$forum')\">\n";      
        $board_str.= "        <table>\n";
        $board_str.= "            <tr>\n";
        $board_str.= "                <td ><img src='$iconurl' class='imgD' style='display:inline;vertical-align:middle;'></td>\n";
        $board_str.= "                <td><h2 style='display:inline;vertical-align:middle;text-align:right;'>$forum</h2></td>\n";        
        $board_str.= "            </tr>\n";
        $board_str.= "        </table>\n";
        $board_str.= "     </button>\n";
        $board_str.= "</td></tr>\n";
		*/
        //-------------------------
        //地圖
        //-------------------------
        $TABLENAME = "message".$fid;
        // 第2個 資料庫連線
	    $dbh = new PDO($dsn, $db_user,$db_passwd);        
        $dbh->exec("set names utf8");
        $sth1 = $dbh->query("SELECT * FROM $TABLENAME ORDER BY time DESC");

        //$iconid = $fid;
        //if($fid>=4)$iconid=4;
        $n = 0;
  
        while($row = $sth1->fetch(PDO::FETCH_ASSOC)){
            $mid = $row['mid'];
            $uid = $row['uid'];
            $title = $row['title'];
            $time = $row['time'];
            $longitude = $row['longitude'];
            $latitude = $row['latitude'];
             
                $marker.= "var marker".$fid.$mid." = L.marker([".$latitude.", ".$longitude."], {icon:L.icon({";
            $marker.= "iconUrl: '$mapIcon',";
            if($n == 0){
                $marker.= "iconSize: [50, 50],";
                $marker.= "className: 'blinking'})";
                $n++;
            }
            else{
                $marker.= "iconSize: [30, 30]})";
                //$marker.= "className: 'blinking'})";
            }

            $marker.= "}).addTo(mymap).bindPopup(";
            $marker.= "\"<p class=InfoTitle onclick=toDiscuss($fid,'$forum',$mid)>".$forum."</p>";
            $marker.= "<p class=info>回報文章：".$title."</p>";
            $marker.= "<p class=info>回報者ID：".$uid."</p>";
            $marker.= "<p class=info>活動時間：".$time."</p>\");\n";
        }

	}      
?>
<html>
    <head>
	    <meta charset="UTF-8">
        <title><?PHP echo $HOME_TITLE;?></title>


        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
         <!--jquery-->
        <script src="./jquery-3.6.0.js"></script>
        
        <script src="https://kit.fontawesome.com/0ac3a26684.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="hw05.css">

        <!--map script & style-->
        <script>
        function initialize(){

            /*地圖的基本設定*/
            var mymap = L.map('mapid').setView([24.984, 121.5755], 15);

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {minZoom: 1, maxZoom: 20}
            ).addTo(mymap);

            /*使用插件Marker Clustering*/
            //var markers = L.markerClusterGroup();
            //mymap.addLayer(markers);

            /*設定每塊區域的邊界及popup視窗*/
            var boundary1 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57944785,24.98623995],[121.57932768,24.98594043],[121.57922829,24.98598339],[121.57797748,24.98617224],[121.57700918,24.98633039],[121.57714603,24.9869961],[121.57722269,24.98736899],[121.57799624,24.98720561],[121.57817579,24.98714549],[121.57834316,24.9870745],[121.57842578,24.9870249],[121.57924331,24.98636654],[121.57944785,24.98623995]
                    ]]
                }
            }];

            L.geoJson(boundary1).addTo(mymap).bindPopup('<p class="boundary">區域Ａ</p>');

            var boundary2 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57478739,24.98741794],[121.57463918,24.98678827],[121.57700918,24.98633039],[121.57714603,24.9869961],[121.57601636,24.9871977],[121.57478739,24.98741794]
                    ]]
                }
            }];

            L.geoJson(boundary2).addTo(mymap).bindPopup('<p class="boundary">區域Ｂ</p>');

            var boundary3 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57486116,24.98674538],[121.57473635,24.98612525],[121.57485019,24.98590046],[121.57538685,24.98579727],[121.57517544,24.98486492],[121.57595359,24.98532401],[121.57621216,24.98542028],[121.57637095,24.98545432],[121.5765469,24.98545918],[121.57683008,24.98541784],[121.57700918,24.98633039],[121.57486116,24.98674538]
                    ]]
                }
            }];

            L.geoJson(boundary3).addTo(mymap).bindPopup('<p class="boundary">區域Ｃ</p>');

            var boundary4 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57405178,24.98340028],[121.57388358,24.9832899],[121.57358725,24.9830579],[121.57343006,24.98284311],[121.57341599,24.98268574],[121.57356379,24.98258154],[121.57375383,24.98232847],[121.57395794,24.98247734],[121.57395794,24.98254113],[121.57465606,24.98295633],[121.57456701,24.98326947],[121.57411513,24.98334074],[121.57405178,24.98340028]
                    ]]
                }
            }];

            L.geoJson(boundary4).addTo(mymap).bindPopup('<p class="boundary">區域Ｄ</p>');

            var boundary5 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57178639,24.97963548],[121.57180785,24.97959853],[121.57176377,24.97954781],[121.57166819,24.97950622],[121.57109851,24.9794681],[121.57095514,24.97940572],[121.57077544,24.97938492],[121.57073338,24.97958074],[121.57066456,24.97966045],[121.57065501,24.97984413],[121.57083307,24.98006216],[121.57093029,24.98019936],[121.57104646,24.9803127],[121.57164716,24.98033625],[121.57172936,24.98029813],[121.57177921,24.98023236],[121.57178639,24.97963548]
                    ]]
                }
            }];

            L.geoJson(boundary5).addTo(mymap).bindPopup('<p class="boundary">區域Ｅ</p>');

            var boundary6 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.56927984,24.98036209],[121.56988503,24.98055198],[121.57001411,24.98052896],[121.57031036,24.98072845],[121.57058544,24.98077064],[121.57068278,24.98073804],[121.57064046,24.980692],[121.57089015,24.98076297],[121.57139589,24.98069968],[121.5711208,24.98062295],[121.57077589,24.98060377],[121.57063411,24.98052129],[121.57049234,24.9803736],[121.5703823,24.98021248],[121.57032728,24.98017603],[121.5700522,24.98018179],[121.56996332,24.98021056],[121.56987233,24.98018371],[121.56985329,24.98011657],[121.56927984,24.98036209]
                    ]]
                }
            }];

            L.geoJson(boundary6).addTo(mymap).bindPopup('<p class="boundary">區域Ｆ</p>');

            var boundary7 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.5719257,24.98054034],[121.57177658,24.98045089],[121.57178639,24.97963548],[121.57180785,24.97959853],[121.5718572,24.97957908],[121.57227991,24.97958005],[121.57252024,24.97955477],[121.57274769,24.97947794],[121.57271296,24.97972734],[121.57267795,24.97980276],[121.57257281,24.97996614],[121.57255457,24.98004297],[121.57253741,24.98021025],[121.57247625,24.98030944],[121.57246552,24.98051173],[121.5724235,24.98057215],[121.57215596,24.98057016],[121.5719257,24.98054034]
                    ]]
                }
            }];

            L.geoJson(boundary7).addTo(mymap).bindPopup('<p class="boundary">區域Ｇ</p>');

            var boundary8 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57318274,24.98704439],[121.57317348,24.98700079],[121.57313701,24.98698815],[121.57314371,24.98651821],[121.57319092,24.98630718],[121.57324671,24.98597751],[121.57327031,24.98581316],[121.57332074,24.98554671],[121.57325432,24.98520908],[121.57325207,24.98503226],[121.57328211,24.98492626],[121.57330357,24.98484069],[121.57341264,24.98464531],[121.5734918,24.98456672],[121.57371019,24.98442349],[121.57385396,24.98437584],[121.57402026,24.98434569],[121.5742284,24.98433986],[121.57439255,24.98439043],[121.57484209,24.98467439],[121.57517544,24.98486492],[121.57538685,24.98579727],[121.57485019,24.98590046],[121.57473635,24.98612525],[121.57486105,24.98674546],[121.57463918,24.98678827],[121.57318274,24.98704439]
                    ]]
                }
            }];

            L.geoJson(boundary8).addTo(mymap).bindPopup('<p class="boundary">區域Ｈ</p>');

            var boundary9 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57229654,24.98153759],[121.57212884,24.9813886],[121.57197813,24.98129468],[121.57211487,24.98119295],[121.57180111,24.98094178],[121.57180346,24.98087207],[121.57193273,24.9807549],[121.57211193,24.98068433],[121.57217509,24.98076954],[121.57230142,24.98079884],[121.57237046,24.98077487],[121.57278616,24.98087606],[121.57278821,24.98091307],[121.57278508,24.98108055],[121.57246251,24.98142688],[121.57229654,24.98153759]
                    ]]
                }
            }];

            L.geoJson(boundary9).addTo(mymap).bindPopup('<p class="boundary">區域Ｉ</p>');

            var boundary10 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57065501,24.97984413],[121.57035904,24.97992196],[121.57008264,24.97996999],[121.56991937,24.97983368],[121.5698535,24.97966492],[121.56972604,24.97962378],[121.56963295,24.97956107],[121.56945966,24.97940789],[121.56933077,24.97926768],[121.56945163,24.97925422],[121.56963823,24.97916467],[121.56976681,24.97904385],[121.56987971,24.97889603],[121.57016856,24.9788276],[121.57034615,24.97882371],[121.57043883,24.97890842],[121.57062541,24.97916773],[121.57064403,24.97930923],[121.57077544,24.97938492],[121.57073338,24.97958074],[121.57066456,24.97966045],[121.57065501,24.97984413]
                    ]]
                }
            }];

            L.geoJson(boundary10).addTo(mymap).bindPopup('<p class="boundary">區域Ｊ</p>');

            var boundary11 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.58134794,24.98828023],[121.58181465,24.98843387],[121.58199167,24.98855543],[121.58223819,24.98866071],[121.58306574,24.98877848],[121.58326807,24.9887446],[121.58319281,24.98868791],[121.58348642,24.98859845],[121.58346545,24.98864542],[121.58358635,24.98904684],[121.5835333,24.98923357],[121.58306081,24.9892414],[121.58304477,24.98920786],[121.58266842,24.98924108],[121.58225284,24.98923517],[121.58218157,24.98917877],[121.58213222,24.98916029],[121.58173418,24.98917488],[121.58133829,24.98908931],[121.58113766,24.98902221],[121.58105719,24.98903777],[121.58096063,24.98900665],[121.58090484,24.98894052],[121.58112264,24.98884911],[121.58109097,24.98871059],[121.58134794,24.98828023]
                    ]]
                }
            }];

            L.geoJson(boundary11).addTo(mymap).bindPopup('<p class="boundary">區域Ｋ</p>');

            var boundary12 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.5781585,24.98876574],[121.57821697,24.98793162],[121.57860643,24.98803956],[121.57874483,24.9880415],[121.57891649,24.98797927],[121.57919222,24.98784021],[121.57937454,24.9876699],[121.58107987,24.98808799],[121.58090177,24.98863451],[121.58079985,24.98869189],[121.58006555,24.98876674],[121.57970667,24.98879686],[121.57838058,24.9887706],[121.5781585,24.98876574]
                    ]]
                }
            }];

            L.geoJson(boundary12).addTo(mymap).bindPopup('<p class="boundary">區域Ｌ</p>');

            var boundary13 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57722269,24.98736899],[121.5761067,24.98758878],[121.57601636,24.9871977],[121.57714603,24.9869961],[121.57722269,24.98736899]
                    ]]
                }
            }];

            L.geoJson(boundary13).addTo(mymap).bindPopup('<p class="boundary">區域Ｍ</p>');

            var boundary14 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.5761067,24.98758878],[121.57601636,24.9871977],[121.57478739,24.98741794],[121.57488085,24.98781749],[121.5761067,24.98758878]
                    ]]
                }
            }];

            L.geoJson(boundary14).addTo(mymap).bindPopup('<p class="boundary">區域Ｎ</p>');

            var boundary15 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57488085,24.98781749],[121.57478739,24.98741794],[121.57463918,24.98678827],[121.57318274,24.98704439],[121.57320304,24.98734345],[121.57320543,24.9875718],[121.57319125,24.98764598],[121.57314714,24.98783677],[121.57302974,24.98814546],[121.57319015,24.98816228],[121.57328509,24.98816525],[121.57368077,24.9881023],[121.574008,24.98800505],[121.57488085,24.98781749]
                    ]]
                }
            }];

            L.geoJson(boundary15).addTo(mymap).bindPopup('<p class="boundary">區域Ｏ</p>');

            var boundary16 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57231101,24.9824088],[121.57248813,24.98239018],[121.5727323,24.98226791],[121.57264629,24.98210488],[121.57278482,24.98206667],[121.57289123,24.98206303],[121.57294485,24.98202735],[121.57267186,24.98186371],[121.57237796,24.98166817],[121.57229654,24.98153759],[121.57212884,24.9813886],[121.57177072,24.98116543],[121.57164939,24.98105865],[121.57124416,24.98116757],[121.57123002,24.9814484],[121.57140908,24.98155838],[121.57142793,24.98164594],[121.57213826,24.9821147],[121.57218185,24.98231651],[121.57231101,24.9824088]
                    ]]
                }
            }];

            L.geoJson(boundary16).addTo(mymap).bindPopup('<p class="boundary">區域Ｐ</p>');

            var boundary17 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.56776666,24.97977037],[121.56772833,24.9795741],[121.56730637,24.97929899],[121.56750313,24.97877347],[121.56770341,24.97852822],[121.56798802,24.97825431],[121.56869075,24.97849637],[121.56903509,24.97875754],[121.56898634,24.97879922],[121.56890979,24.97889059],[121.56890086,24.97910802],[121.56893914,24.97924102],[121.56935835,24.97977993],[121.56931807,24.97987827],[121.56926193,24.97996732],[121.56919814,24.98002977],[121.56910117,24.98006216],[121.56813278,24.97975221],[121.56785974,24.97967935],[121.56776666,24.97977037]
                    ]]
                }
            }];

            L.geoJson(boundary17).addTo(mymap).bindPopup('<p class="boundary">區域Ｑ</p>');

            var boundary18 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57797748,24.98617224],[121.57922829,24.98598339],[121.57932768,24.98594043],[121.57961961,24.98555931],[121.57937274,24.98554722],[121.57885233,24.98548674],[121.57867997,24.9854434],[121.57850107,24.98536624],[121.57820849,24.9852902],[121.57796941,24.98520855],[121.57783024,24.98511565],[121.57771921,24.98510675],[121.57737227,24.98517126],[121.57722215,24.98525391],[121.57711762,24.98533656],[121.5769853,24.98539099],[121.57683008,24.98541784],[121.57700918,24.98633039],[121.57797748,24.98617224]
                    ]]
                }
            }];

            L.geoJson(boundary18).addTo(mymap).bindPopup('<p class="boundary">區域Ｒ</p>');

            var boundary19 = [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [121.57341599,24.98268574],[121.57356379,24.98258154],[121.57375383,24.98232847],[121.57408786,24.981935],[121.57412857,24.98185268],[121.57411605,24.98174481],[121.57419121,24.98166249],[121.57415363,24.98156313],[121.57402836,24.98145243],[121.57378096,24.98131049],[121.57380914,24.98125655],[121.57375903,24.9811572],[121.57369953,24.98111178],[121.5736369,24.98109191],[121.57357113,24.9811572],[121.57353042,24.98110043],[121.57322665,24.98089888],[121.57278821,24.98091307],[121.57278508,24.98108055],[121.57246251,24.98142688],[121.57229654,24.98153759],[121.57237796,24.98166817],[121.57267186,24.98186371],[121.57309055,24.98211468],[121.5732538,24.98220021],[121.57338469,24.9823422],[121.57341599,24.98268574]
                    ]]
                }
            }];

            L.geoJson(boundary19).addTo(mymap).bindPopup('<p class="boundary">區域Ｓ</p>');
            <?PHP echo $marker;?> 

            
        }           
        </script>
        <style>
            body{
                background-color: #B4D0C7;
            }

            #mapid{
                position: relative;
                top: 50%;
                height: 500px;
                transform: translateY(-50%);
            }

            p.boundary{
                font-family: 微軟正黑體;
                font-weight: bold;
                font-size: 20pt;
                text-align: center;
                color: #4f7d6f;
            }

            p.boundary:hover{
                transform: scale(1.2);
                transition: 0.5s;
                color: #82b0a2;
            }

            p.info{
                font-family: 微軟正黑體;
                font-weight: bold;
                font-size: 14pt;
                color: #9191ba;
            }

            p.InfoTitle{
                font-family: 微軟正黑體;
                font-weight: bold;
                font-size: 20pt;
                color: #31314e;
            }

            a{
                color: #000;
                text-decoration: none;
            }

            a:hover{
                text-decoration: underline;
                transition: 0.5s;
            }
            
            .blinking{
                animation: fade 0.5s infinite alternate;
            }

            @keyframes fade{ 
                from{opacity: 0;} 
            }
        </style>
        
    </head>   

    <body>        
        <div id="header" style="z-index:900;">
            <div id="h_left">
                <button class="btn-word" disabled><i class="fas fa-home fa-2x" style="color:#2f5d62;"></i></button>
                <button class="btn-word" onclick="location.href='<?PHP echo $DISCUSS_URL?>';"><i class="fas fa-comments fa-2x"></i></button>            
            </div>          
            <center><h2 id="h_mid" class="title"><?PHP echo $HOME_TITLE;?></h2></center>      
            <ul id="h_right" class="menu"><?PHP echo $funcName;?></ul>   
        </div>             
        <div class="mask" style="z-index:999;">
            <div class="new_mask" >                
                <p>輸入新動物：<p>
                <br>
                <div class="new-form">
                    <label for="new_forum_name">**請輸入名稱：</label>                                            
                    <input type="text"  class="form-control" id="new_forum_name" name="new_forum_name" placeholder="新動物名稱">                
                
                    <label for="animalType">**新動物種類：</label>
                        <select class="form-control" id="animalType" >
                            <option value="" disabled selected>新動物種類</option>                            
                            <option value="dog">狗狗</option>
                            <option value="cat">貓貓</option>
                            <option value="others" >其他</option>                                               
                    </select>
                    
                    <label for="introduction">請輸入簡介：</label>
                    <textarea rows="1"  id="introduction" class="form-control js-elasticArea" placeholder="簡介" name="introduction"></textarea>
                    
                    <label for="nickname">請輸入別名：</label>
                    <input type="text"  class="form-control" id="nickname" name="nickname" placeholder="別名"> 
                    
                    <label for="file">請提供照片: </label>
                    <form id="uploadForm" method="post" enctype="multipart/form-data" style="display:flex;">
                        <input type="file" name="file" style="flex:3;">
                        <input type="button" value="上傳" onclick="upload();" style="flex:1;">                   
                    </form>
                    <center><span id="upload result"></span></center>
                    <br>
                    <label for="feature">請輸入特徵：</label>
                    <input type="text"  class="form-control" id="feature" name="feature" placeholder="特徵">
                    
                    <label for="characters">請輸入個性：</label>
                    <input type="text"  class="form-control" id="characters" name="characters" placeholder="個性">

                    <label for="places">請輸入出沒地：</label>
                    <input type="text"  class="form-control" id="places" name="places" placeholder="出沒地">

                    <label for="href">請輸入個人帳號網址：</label>
                    <input type="text"  class="form-control" id="href" name="href" placeholder="個人帳號網址">
 
                </div>
                <table width="100%">
                        <tr>
                            <td width="20%"></td>                        
                            <td width="30%" align="center" ><button type='button' class='btn-primary' onclick="new_forum();">確定新增</button></td>
                            <td width="30%" align="center" > <button type='button' class='btn-primary' onclick="del_new_forum();">取消新增</button></td>
                            <td width="20%"></td> 
                        </tr>                   
                </table>               
            </div>        
        </div>
        <div id="box">
            <div class="board">                
                <center><h3>個人介紹</h3><center>
                <table>                                     
                    <?PHP // 顯示討論版區塊
                        echo $board_str;
                    ?>
                </table>
                
            </div>

            <div class="discuss">
                <div>
                    <ul class="discuss-header">
                        <li style="margin-top:20px; vertical-align: middle;"><span id='imgDiv' ></span></li>
                        <li><h2 id = "title"style="margin-top:20px; vertical-align: middle;">地圖</h2></span></li>                        
                        <li style="vertical-align: middle;"><span id='imgMap' ></span></li>
                                                
                    </ul>                       
                </div>
                <!--地圖-->
                <div id="mapid" style="z-index:600;"></div>
                <!--簡介-->
                <div id="discussDiv" class="discuss-body"></div>
            </div>
            <div class="right"></div>
        </div> 
    </body>
    <script src="./mask.js"></script>
    <script>
        initialize();
        document.getElementById("imgMap").innerHTML ="<button class='btn-none' onclick='toMap()'><img src='./images/map.png' class='imgD'></button>"; 
        $("#mapid").attr("style","display:block");//顯示div
        $("#discussDiv").attr("style","display:none;;");//隱藏div
        function toMap(){
            $("#mapid").attr("style","display:block");//顯示div
            $("#discussDiv").attr("style","display:none;;");//隱藏div
            document.getElementById("imgDiv").innerHTML = "";
            document.getElementById("title").innerHTML = "地圖";
        }
        function toDiscuss(fid, forum, mid){ 
            //alert(fid, forum, mid);            
            var formData = new FormData();
            formData.append("fid", fid);
            formData.append("forum", forum); 
            formData.append("mid", mid);           
            xhr.open("POST", "ajax/srv_session.php");
            xhr.send(formData);
            //window.name = mid;
            window.location = '<?PHP echo $DISCUSS_URL?>';
        }
        
        // 點選要看的討論版
        function viewBoard(fid,forum) {
            document.getElementById("title").innerHTML = "簡介";
            $("#mapid").attr("style","display:none;");//隱藏div
            $("#discussDiv").attr("style","display:block;");//顯示div
            switch (forum) {
                case '小橘':
                    document.getElementById("imgDiv").innerHTML ="<img src='./images/icon_orange.png' class='imgD'>";
                    break;
                case '花花':
                    document.getElementById("imgDiv").innerHTML ="<img src='./images/icon_huahua.png' class='imgD'>";
                    break;
                case '胖虎':
                    document.getElementById("imgDiv").innerHTML ="<img src='./images/icon_tiger.png' class='imgD'>";
                    break;
                default:
                    document.getElementById("imgDiv").innerHTML = "<img src='./images/defalt.png' class='imgD'>";
                }

            var formData = new FormData();
            formData.append("type", 4);
            formData.append("fid", fid);                
		
            // 傳送fid資料到後端
            xhr.open("POST", "ajax/srv_inro.php");
            xhr.send(formData);

            // 接收回傳
            xhr.onreadystatechange=function() {
                if (xhr.readyState==4 && xhr.status==200) {
                    document.getElementById("discussDiv").innerHTML = xhr.responseText;
                }
            }
        } 
        
    </script>
</html>


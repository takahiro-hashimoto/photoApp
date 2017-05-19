<?php

function view($val){
  return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

$pdo = new PDO('mysql:dbname=sc_map;host=localhost', 'root', '');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM map_info");
$flag = $stmt->execute();

$view = "";
$list = "";
$i = 0;

if($flag == false){
  $view = "SQLエラー";
} else {
  while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    if($i == 0){
      $view .= '["' . $res['img'] . '",' .$res['lat'] . ',' .$res['lon']. ',' . '"' .$res['description']. '"' . ']';
      $list .= '<li class="list-item"><img src="'. $res['img'].'"></li>';
    } else {
      $view .= ',["' .$res['img']. '",' . $res['lat'] . ',' .$res['lon'] . ',' . '"' . $res['description'] . '"' . ']';
      $list .= '<li class="list-item"><img src="'. $res['img'].'"></li>';
    }
    $i ++;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>写真共有アプリ</title>
<link rel='stylesheet' type='text/css' href='./dst/css/style.css' media='all' />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script type='text/javascript' src='http://code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6lUhK2_Tp4gNWr_Xsnn2xkDOiaCkm9Vg" type="text/javascript"></script>
<script type='text/javascript' src='./dst/script/script.js'></script>
</head>
<body>

<!-- header -->
<div class="header">
  <div class="header-inner">
    <h1 class="header-title"><a class="header-link" href="index.php">写真共有アプリ</a></h1>
    <p class="header-nav"><a class="header-link" href="input.php"><i class="fa fa-camera" aria-hidden="true"></i></a></p>
  </div>
</div>
<!-- header -->

<!-- map -->
<div id="js-map" class="map l-bottom-large"></div>
<!-- map -->

<!-- container -->
<div class="container">
  <h2 class="container-title l-bottom-small">投稿写真一覧</h2>
  <div class="l-bottom-large">
    <ul class="list"><?=$list?></ul>
  </div>
</div>
<!-- container -->

<!-- footer -->
<div id="js-footer" class="footer">
  <div class="footer-inner">
    <p class="footer-text">© Copyright 2017 photoApp. All rights reserved.</p>
  </div>
</div>
<!-- footer -->

<script type="text/javascript">
function initialize() {
  var myOptions = {
    zoom: 5,
    center: new google.maps.LatLng(38.2586, 137.6850),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true
  };

  var map = new google.maps.Map(document.getElementById("js-map"),myOptions);
  var markers = [<?=$view?>]

  for (var i = 0; i < markers.length; i++) {
    var img = markers[i][0];
    var latlng = new google.maps.LatLng(markers[i][1],markers[i][2]);
    var description = markers[i][3];
    createMarker(img, latlng, map, description);
  }
}

function createMarker(img, latlng, map, description){
  var infoWindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({position: latlng,map: map});
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent('<p><img class="map-image" src="' + img + '"/></p><p class="map-text">' + description + '</p>');
    infoWindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

</body>
</html>

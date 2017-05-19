<?php

session_start();
$img = "";

if (!isset($_FILES['upfile']['error']) || !is_int($_FILES['upfile']['error']) || !isset($_POST["file_upload_flg"]) || $_POST["file_upload_flg"]!="1") {

} else {
 $lat = $_POST["lat"];
 $lon = $_POST["lon"];
 $file_name = $_FILES["upfile"]["name"];
 $extension = pathinfo($file_name, PATHINFO_EXTENSION);
 $tmp_path  = $_FILES["upfile"]["tmp_name"];
 $uniq_name = date("YmdHis").session_id() . "." . $extension;
 $description = $_POST["description"];

  if (is_uploaded_file( $tmp_path)) {
    if (move_uploaded_file( $tmp_path, "upload/".$uniq_name)) {
      $img = '<img src="upload/'.$uniq_name.'" >';
      $pdo = new PDO('mysql:dbname=sc_map;host=localhost', 'root', '');
      $stmt = $pdo->query('SET NAMES utf8');
      $stmt = $pdo->prepare("INSERT INTO map_info (id, lat, lon, img, description )VALUES(NULL, :lat, :lon, :img, :description)");
      $stmt->bindValue(':lat', $lat);
      $stmt->bindValue(':lon', $lon);
      $stmt->bindValue(':img', "upload/".$uniq_name);
      $stmt->bindValue(':description', $description);
      $status = $stmt->execute();
      if($status==false){
        exit;
      }
    } else {
      echo "アップロードできませんでした。";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>写真アップロード/写真共有アプリ</title>
<link rel='stylesheet' type='text/css' href='./dst/css/style.css' media='all' />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script type='text/javascript' src='http://code.jquery.com/jquery-2.1.3.min.js'></script>
<script type='text/javascript' src='./dst/script/script.js'></script>
</head>
<body>

<!-- header -->
<div class="header l-bottom-large">
  <div class="header-inner">
    <h1 class="header-title"><a class="header-link" href="index.php">写真共有アプリ</a></h1>
    <p class="header-nav"><a class="header-link" href="input.php"><i class="fa fa-camera" aria-hidden="true"></i></a></p>
  </div>
</div>
<!-- header -->

<!-- container -->
<div class="container">
  <p id="js-desc-text" class="align-center l-bottom-xlarge">ファイルを選択してください</p>
  <p id="js-button-select" class="button button-select l-bottom-large">カメラ / 写真選択</p>
  <div id="js-view-container" class="view l-bottom-large is-hide">
    <img id="js-view" src="" alt=""/>
  </div>
  <form method="post" action="input.php" enctype="multipart/form-data" id="js-send-file" class="form">
    <input type="text" name="description" placeholder="キャプションを書く" id="js-description" class="form-input l-bottom-large is-hide">
    <input type="file" accept="image/*" capture="camera" id="js-image_file" class="is-hide" value="" name="upfile">
    <input type="hidden" name="lat" id="js-lat">
    <input type="hidden" name="lon" id="js-lon">
    <input type="hidden" name="file_upload_flg" value="1">
  </form>
  <p id="js-button-upload" class="button button-upload l-bottom-large l-bottom-xlarge is-hide">Fileアップロード</p>
</div>
<!-- container -->

<!-- footer -->
<div id="js-footer" class="footer">
  <div class="footer-inner">
    <p class="footer-text">© Copyright 2017 photoApp. All rights reserved.</p>
  </div>
</div>
<!-- footer -->

</body>
</html>

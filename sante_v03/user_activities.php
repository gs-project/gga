<?php
session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!= session_id()){
    echo "Login Error!";
    exit();
}
$user_id = $_SESSION["user_id"]; //sessionなどから持ってくる
// echo $_SESSION["user_id"];

//0.外部ファイル読み込み
include("functions.php");

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM activities LEFT OUTER JOIN joins ON activities.activity_id = joins.activity_id WHERE joins.user_id = $user_id");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .='<div class="details-container">';
        $view .= '<div class="detail1">'; 
        $view .= '<img src="main_img/'.$result["main_img"].'">';
    $view .= '</div>';

    $view .= '<div class="detail2">';
        $view .= '<div class="detail1-text">';
            $view .= '<p class="title-next">';
            $view .= h($result["name"]);
            $view .= '</p>';
            $view .= '<p>';
            $view .= h($result["price"]);
            $view .= '</p>';
        $view .= '</div>';
        $view .= '<p class="date-next">';
        $view .= h($result["date"]);
        $view .= '</p>';
        $view .= '<p class="time-next">';
        $view .= h($result["start_time"]);
        $view .= h($result["end_time"]);
        $view .= '</p>';
        $view .= '<div class="location-next">';
            $view .= '<p class="location-name">';
            $view .= h($result["location"]);
            $view .= '</p>';
            $view .= '<div class="location-btn"><p>地図詳細</p>';
            // $view .= '</div>';
            // $view .= '<a href="cancel_join.php?activity_id='.$result["activity_id"].'">';
            // $view .= '[キャンセル]';
            // $view .= '</a>';
            $view .= '</div>';
        $view .= '</div>';
    $view .= '</div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activity</title>
    <link rel="stylesheet" href="css/activity.css">
</head>
<body>
    <header >
        <a href="home.php" class="back"><img src="icon/gene_back.png" alt="もどる"></a>
        <h1>ACTIVITY</h1> 
    </header>
    <div class="main-container">
        <div class="next-activity">
            <p class="na-title">・次回のアクティビティ</p>
            <?=$view?>
        </div>
        <hr>
    </div>
    

</body>
</html>
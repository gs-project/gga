<?php
// session_start();
include("functions.php");
// chk_ssid();

//1.GETでidを取得
if(!isset($_GET["activity_id"])){
  exit("Error");
}
$activity_id = $_GET["activity_id"];

//2.DB接続など
$pdo = db_con();

//3.SELECT * FROM gs_an_table WHERE id=***; を取得（bindValueを使用！）
$stmt = $pdo->prepare("SELECT * FROM activities LEFT OUTER JOIN hosts ON activities.host_id = hosts.host_id WHERE activity_id=:activity_id");
$stmt->bindValue(":activity_id",$activity_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$row["name"]?></title>
    <link rel="stylesheet" href="css/detail.css">
    <script type="text/javascript">

    </script>
</head>

    <header>
    </header>

    <div class="main-container">
        <a href="home.php" class="back">    
            <img src="icon/gene_back.png" alt="戻る">
        </a>
        
        <div class="image-container"><img class ="container-img" src="main_img/<?=$row["main_img"]?>"></div>
        <div class="title-container">
            <div class="titles">
                <div class="profile">
                <img src="host_img/<?=$row["host_img"]?>">
                </div>
                <h2 class="title"><?=$row["name"]?></h2>
                <p ><?=$row["date"]?></p>
                <p><?=$row["start_time"]?>~<?=$row["end_time"]?></p>
            </div>
            <div class="other-info">
                <div class="location-container">
                    <img src="icon/cont_location_icon.png" alt="ロケーション">
                    <p><?=$row["location"]?></p>
                </div>
                <div class="value-container">
                    <img src="icon/cont_heart_icon.png" alt="ハート" class="heart">
                    <p><?=$row["likes"]?></p>
                    <img src="icon/fake_person.png" alt="参加者" class="participants">
                    <p><?=$row["nums_participants"]?></p>
                </div>
            </div>
        </div>

        <div class="map-container">
                <div id="ZMap" ></div>

        </div>
        <div class="comment-container">
            <p class="comment"><?=$row["description"]?>

            
            </p>
            <div class="comment-btn">
                <hr>
                    <button id="more-btn">さらに読む</button>
                <hr>
            </div>
        </div>
        <div class="foot-container">
            <div class="agreement-container">
                <p>利用規約・注意事項など</p>
            </div>
            <div class="join-container">
                <div class="join-detail">
                    <div class="join-value">
                    <p><?=$row["price"]?></p>            
                    </div>
                </div>
                <div class="join-btn-container">
                <a id="join-btn" href="join.php?activity_id=<?=$row["activity_id"]?>">JOIN</a>
            </div>

            </div>
        </div>
    </div>
     <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="js/detail.js"></script>
</body>
</html>



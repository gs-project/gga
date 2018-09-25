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
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/detail.css">
    <script type="text/javascript">

    </script>
</head>

<body >

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
                <p ><span class="date"><?=$row["date"]?></span>  <?=$row["start_time"]?>~<?=$row["end_time"]?></p>
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
        
        <!-- 地図を表示させる要素。widthとheightを必ず指定する。 -->
        <div  class="map-container" id="map" style="width:100%; height:100%"></div>
        <script>
                let map;
                let address = "<?=$row["location"]?>";
                function codeAddress() {
                    //     map = new google.maps.Map(document.getElementById('map'), {
                    //     center: {lat: -34.397, lng: 150.644},
                    //     zoom: 8
                    //     });
                    // }
                    // google.maps.Geocoder()コンストラクタのインスタンスを生成
                    var geocoder = new google.maps.Geocoder();

                    // 地図表示に関するオプション
                    var mapOptions = {
                            zoom: 18,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            // マウスホイールによるズーム操作を無効
                            scrollwheel: false
                    };

                    // 地図を表示させるインスタンスを生成
                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                    // geocoder.geocode()メソッドを実行 
                    geocoder.geocode( { 'address': address}, function(results, status) {
                    // ジオコーディングが成功した場合
                        if (status == google.maps.GeocoderStatus.OK) {
                                // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
                                // 変換した緯度・経度情報を地図の中心に表示
                                map.setCenter(results[0].geometry.location);

                                // 地図上に目印となるマーカーを設定います。
                                // google.maps.Marker()コンストラクタにマーカーを設置するMapオブジェクトと
                                // 変換した緯度・経度情報を渡してインスタンスを生成
                                // →マーカー詳細
                                var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                                });
                        // ジオコーディングが成功しなかった場合
                        } else {
                                console.log('Geocode was not successful for the following reason: ' + status);
                        } 
                    });
        
                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                            infoWindow.setPosition(pos);
                            infoWindow.setContent(browserHasGeolocation ?
                                                'Error: The Geolocation service failed.' :
                                                'Error: Your browser doesn\'t support geolocation.');
                            infoWindow.open(map);
                    }
                };
               
                

        </script>

        <div class="comment-container">
            <p id ="comment" class="comment"><?=$row["description"]?>

            
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
        
                
                <a class="join-container" href="join.php?activity_id=<?=$row["activity_id"]?>">          
                    <div class="join-detail">
                        <div class="join-value">
                        <p>¥<?=$row["price"]?></p> 
                        <img src="icon/joinBtn_icon.png" alt="参加" class="join-btn">               
                        </div>
                    </div>
                </a>
            

            
        </div>
     </div>   
       
    <script 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEInW7ENSHuuWsQPHPvZA12wFZA33jlnQ&callback=codeAddress"
        async defer>
    </script>
    <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/detail.js"></script>
</body>
</html>



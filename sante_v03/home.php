<?php
    session_start();
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!= session_id()){
        echo "Login Error!";
        exit();
    }

    //0.外部ファイル読み込み
    include("functions.php");

    //1.  DB接続します
    $pdo = db_con();

    //２．データ登録SQL作成
    $stmt = $pdo->prepare("SELECT * FROM activities LEFT OUTER JOIN hosts ON activities.host_id = hosts.host_id");
    $status = $stmt->execute();

    //３．データ表示
    $view="";
    if($status==false){ 
        queryError($stmt);
    }else{
    //Selectデータの数だけ自動でループしてくれる
        while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $view .= '<p>';
            $view .= '<img src="upload/'.$result["main_img"].'" width="200">';
            $view .= '<a href="detail.php?activity_id='.$result["activity_id"].'">';
            $view .= h($result["name"]);
            // $view .= h($result["name"])."[".h($result["indate"])."]";
            $view .= '</a>　';
            $view .= '<a>　'; 
            $view .= h($result["location"]);
            $view .= '</a>　';
            $view .= '<a>価格：'; 
            $view .= h($result["price"]);
            $view .= '円</a>　';
            $view .= '<a>　'; 
            $view .= h($result["description"]);
            $view .= '</a>　';
            $view .= '<a>　'; 
            $view .= h($result["date"]);
            $view .= '</a>　';
            $view .= '<a>　'; 
            $view .= h($result["start_time"]);
            $view .= '</a>　';
            $view .= '<a>　'; 
            $view .= h($result["end_time"]);
            $view .= '</a>　';
            $view .= '<a>　'; 
            $view .= h($result["host_name"]);
            $view .= '</a>　'; 
            $view .= '<a href="delete_activity.php?activity_id='.$result["activity_id"].'">';
            // $view .= '[削除]';
            $view .= '</a>';
            $view .= '<img src="host_img/'.$result["host_img"].'" width="50">';
            $view .= '</p>';
        }
    }
    // $address=""; 
    // if($status==false){ 
    //     queryError($stmt);
    // }else{
    //     while($result = $stmt->fetch(PDO::FETCH_ASSOC){
    //         $address== $result["location"];
    //         // $address="1"; 
    //     }
    // }
    // var_dump($address);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SANTE</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
 

</head>
<body>
    <header>
        <div class="head">
            <h1>SANTE</h1>
        </div>
        <!-- ナビゲーションバー。非同期通信で行う  -->
        <nav class="slidemenu">
  
                <!-- Item 1 -->
                
                <input type="radio" name="slideItem" id="slide-item-1" class="slide-toggle" checked/>
                <label for="slide-item-1"><span id="slide-title1">FUN</span></label>
                
                <!-- Item 2 -->
                <input type="radio" name="slideItem" id="slide-item-2" class="slide-toggle"/>
                <label for="slide-item-2"><span id="slide-title2">RELAX</span></label>
               
                <!-- Item 3 -->
                <input type="radio" name="slideItem" id="slide-item-3" class="slide-toggle"/>
                <label for="slide-item-3"><span id="slide-title3">HARD</span></label>
                
                <div class="clear"></div>
                
                <!-- Bar -->
                <div class="slider">
                  <div class="bar"></div>
                </div>
                
        </nav>
        <body>
                <!-- 日付入力 -->
                <div class="calender">
                    <img src="icon/gene_calender_icon.png" alt="カレンダー">
                    <input type="data" id="datepicker">
                </div>
              </body>
    </header>
    <!-- イベントの一覧表示 -->
    <div class="main-container">

    </div>

    
    <footer>
    <!-- ツールバー。画面遷移する -->
        <div id="toolbar">
            <div id="home-tool">
                <a href="home.php"><img class="toolicon" src="icon/tool_home_icon.png" alt="ホーム"></a>
                <p>ホーム</p>
            </div>

            <div id="activity-tool">
                <a href="user_activities.php"><img class="toolicon" src="icon/tool_activity_icon.png" alt="アクティビティ"></a>
                <p>アクティビティ</p>
            </div>

            <div id="setting-tool">
                <a href="setting.php"><img class="toolicon" src="icon/tool_setting_icon.png" alt="設定"></a>
                <p>設定</p>
            </div>
             <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
            
            <script src="js/main.js"></script>    
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
            
        </div>
        
    <script>
        function initialize() {
            var service = new google.maps.DistanceMatrixService;
            //出発地点の名称と緯度経度情報を設定 （必須）
            var originName = "Tokyo Station";
            var originPos = new google.maps.LatLng(35.679357, 139.771478);
            //目的地の名称と緯度経度情報を設定（必須）
            var destinationName = "Shinagawa Station";
            var destinationPos = new google.maps.LatLng(35.628986, 139.737848);
            service.getDistanceMatrix({
                origins: [originPos, originName],
                destinations: [destinationName, destinationPos],
                travelMode: 'DRIVING',
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function(response, status) {
                //リクエウスの結果が返されます。
                if (status !== 'OK') {
                    console.log('Error was: ' + status);
                } else {
                for(var i=0;i<response.rows.length;i++){
                    var results = response.rows[i].elements;
                    for (var j=0;j<results.length;j++){
                    var distance = results[j].distance.value;
                    var duration = results[j].duration.value;
                    var min = Math.floor(duration/60);
                    var sec = duration%60;
                    console.log('距離: ' + distance/1000 + ' km\n' + '時間: ' + min + 'm' + sec + 's' ) ;
                    }
                }
                }
            });
        }
        //  let address =
       
    
        // function codeAddress(address) {
        //     geocoder.geocode( { 'address': address}, function(results, status) {
        //                 // ジオコーディングが成功した場合
        //                     if (status == google.maps.GeocoderStatus.OK) {
        //                             // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
        //                             // 変換した緯度・経度情報を地図の中心に表示
        //                             map.setCenter(results[0].geometry.location);

        //                             // 地図上に目印となるマーカーを設定います。
        //                             // google.maps.Marker()コンストラクタにマーカーを設置するMapオブジェクトと
        //                             // 変換した緯度・経度情報を渡してインスタンスを生成
        //                             // →マーカー詳細
        //                             var marker = new google.maps.Marker({
        //                             map: map,
        //                             position: results[0].geometry.location
        //                             });
        //                             console.log("hey");
                                    
        //                     // ジオコーディングが成功しなかった場合
        //                     } else {
        //                             console.log('Geocode was not successful for the following reason: ' + status);
        //                     } 
        //     });
        // };
        // codeAddress();
        // console.log(initialize());
        
    </script>
    
    <!-- <script 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEInW7ENSHuuWsQPHPvZA12wFZA33jlnQ&callback=codeAddress"
        async defer>
    </script> -->
    </footer>
</body>
</html>
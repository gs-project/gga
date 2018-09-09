<?php
//0.外部ファイル読み込み
include("functions.php");

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM activities LEFT OUTER JOIN hosts ON activities.host_id = hosts.host_id");
$status = $stmt->execute();

//３．データ表示
$jsonData="";
if($status==false){
  queryError($stmt);
}else{
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $jsonData[]=array(
    'key'=>$result['activity_type'],  
    'id'=>$result['activity_id'],
    'name'=>$result['name'],    
    'image'=>$result['main_img'],
    'like'=>$result['likes'],
    'startTime'=>$result['start_time'],
    'endTime'=>$result['end_time'],
    'profile'=>$result['host_img'],
    'location'=>$result['location'],
    'participants'=>$result['nums_participants'],
    'comment'=>$result['description']
    );


}
}
//jsonとして出力
// header('Content-type: application/json');
echo json_encode($jsonData);
$arr = json_encode($jsonData);
file_put_contents("json/activity.json" , $arr);

?>
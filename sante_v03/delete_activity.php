<?php
include("functions.php");
//1.POSTでParamを取得
$activity_id = $_GET["activity_id"];

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("DELETE FROM activities WHERE activity_id=:activity_id");
$stmt->bindValue(':activity_id',$activity_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: home.php");
  exit;
}

?>

<?php
session_start();

include("functions.php");
//1.POSTでParamを取得
$activity_id = $_GET["activity_id"];
$user_id = $_SESSION["user_id"]; //sessionなどから持ってくる

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。

//明日やる
$stmt = $pdo->prepare("INSERT INTO joins(join_id, activity_id,user_id) VALUES (NULL,:activity_id,:user_id)");
$stmt->bindValue(':activity_id',$activity_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: home.php");
  exit;
}

?>



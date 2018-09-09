<?php
include("functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["date"]) || $_POST["date"]=="" ||
  !isset($_POST["start_time"]) || $_POST["start_time"]=="" ||
  !isset($_POST["end_time"]) || $_POST["end_time"]=="" ||
  !isset($_POST["location"]) || $_POST["location"]=="" ||
  !isset($_POST["price"]) || $_POST["price"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$name = $_POST["name"];
$date = $_POST["date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$location = $_POST["location"];
$price = $_POST["price"];
$description = $_POST["description"];
$host_id = $_POST["host_id"];

//Fileupload
//Fileアップロードチェック
if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
  //情報取得
  $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
  $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
  $file_dir_path = "main_img/";  //画像ファイル保管先

  
  //***File名の変更***
  $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
  $uniq_name = date("YmdHis").md5(session_id()) . "." . $extension;  //ユニークファイル名作成
  $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
 

  // $img="";  //画像表示orError文字を保持する変数
  // FileUpload [--Start--]
  if ( is_uploaded_file( $tmp_path ) ) {
      if ( move_uploaded_file( $tmp_path, $file_name ) ) {
          chmod( $file_name, 0644 );
          // $img = '<img src="'. $file_name . '" >'; //画像表示用HTML
      } else {
          echo "Error:アップロードできませんでした。"; //Error文字
      }
  }
  // FileUpload [--End--]
}else{
  echo "画像が送信されていません"; //Error文字
}

//2. DB接続します(エラー処理追加)
$pdo = db_con();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO activities(activity_id, name, date, start_time, end_time, price, main_img, location, description,host_id)
VALUES(NULL, :a1, :a2, :a3, :a4, :a5, :image ,:a6,:a7,:a8)");
$stmt->bindValue(':a1', $name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $date,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $start_time, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $end_time, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a5', $price, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a6', $location, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a7', $description, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a8', $host_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $uniq_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
  //５．index.phpへリダイレクト
  header("Location: activities.php");
  exit;
}
?>

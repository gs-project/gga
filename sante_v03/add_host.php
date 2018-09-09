<?php
include("functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["host_name"]) || $_POST["host_name"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$host_name = $_POST["host_name"];

//Fileupload
//Fileアップロードチェック
if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
  //情報取得
  $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
  $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
  $file_dir_path = "host_img/";  //画像ファイル保管先

  
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
$stmt = $pdo->prepare("INSERT INTO hosts(host_id,host_name,host_img)
VALUES(NULL,:a1,:image)");
$stmt->bindValue(':a1', $host_name,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $uniq_name,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
  //５．index.phpへリダイレクト
  header("Location: hosts.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録用</title>
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="add_activity.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend></legend>
     <label>Activity名：<input type="text" name="name"></label><br>
     <label>実施日：<input type="text" name="date"></label><br>
     <label>開始時間：<input type="text" name="start_time"></label><br>
     <label>終了時間：<input type="text" name="end_time"></label><br>
     <label>場所：<input type="text" name="location"></label><br>
     <label>価格：<input type="text" name="price"></label><br>
     <label>主催者コード：<input type="text" name="host_id"></label><br>
     <label><textArea name="description" rows="4" cols="40"></textArea></label><br>
     <input type="file" name="upfile"><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>


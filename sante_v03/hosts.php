<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>主催者登録</title>
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="add_host.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend></legend>
     <label>主催者名：<input type="text" name="host_name"></label><br>
     <input type="file" name="upfile"><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>

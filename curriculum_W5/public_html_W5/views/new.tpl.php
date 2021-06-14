<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <form action='create.php' method='post'>
    <label for='title'>タイトル</label><br>
    <input type='text' name='title' value=''>
    <p></p>
    <label for='content'>本文</label><br>
    <textarea name='content' cols='40' rows='10'></textarea>
    <p></p>
    <button type='submit'>作成する</button>
  </form>
  
  <p><a href='index.php'>一覧に戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
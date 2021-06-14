<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <p>タイトル：<?= $note->title ?></p>
  <div><?= $my_html ?></div>
  
  <p><a href='index.php'>一覧に戻る</a> | 編集 | 削除></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>1行掲示板</h1>
  <p><?= $message ?></p>

  <form action='result_W2-6.php' method='post'>
    <label for='article'>投稿</label>
    <input type='text' name='article'>
    <p></p>
    <label for='name'>名前</label>
    <input type='text' name='name'>
    <button type='submit'>送信する</button>
  </form>

  <h2>投稿一覧</h2>
  <?php foreach($lines as $line){ ?>
    <p><?=$line ?></p>
    <?php  } ?>

  <?php include('footer.inc.php'); ?>
</body>

</html>
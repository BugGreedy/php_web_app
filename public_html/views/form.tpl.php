<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>フォーム</h1>
  <p><?= $message ?></p>

  <form action='result.php' method='post'>
    <label for='article'>投稿</label>
    <input type='text' name='article'>
    <p></p>
    <label for='name'>名前</label>
    <input type='text' name='name'>
    <p></p>
    <button type='submit'>送信するンゴ</button>
  </form>

  <p>
    <?php
      if(isset($article)){
        echo $article.',';
      }
      if(isset($name)){
        echo $name;
      }
    ?>
  </p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
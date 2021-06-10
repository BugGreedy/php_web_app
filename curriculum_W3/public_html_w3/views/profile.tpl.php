<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player profile</h1>
  <p><?= $message ?></p>

  <ul>
    <li>ID：<?= $player['id'] ?></li>
    <li>名前：<?= $player['name'] ?></li>
    <li>職業：<?= $player['job_name'] ?></li>
    <li>レベル：<?= $player['level'] ?></li>
  </ul>

  <p><a href='index_w3-7.php'>プレイヤーリストに戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
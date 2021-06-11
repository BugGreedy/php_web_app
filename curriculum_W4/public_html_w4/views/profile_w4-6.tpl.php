<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player profile</h1>
  <p><?= $message ?></p>

  <ul>
    <li>ID：<?= $player->id ?></li>
    <li>名前:<?= $player->name ?></li>
    <li>レベル：<?= $player->level ?></li>
    <li>職業id：<?= $player->job_id ?></li>
    <!-- 下記を追記 -->
    <li>職業名：<?= $player->job->job_name ?></li>
  </ul>

  <p><a href='index_w4-6.php'>リストに戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
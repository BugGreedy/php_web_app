<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Job profile</h1>
  <p><?= $message ?></p>

  <ul>
    <li>ID：<?= $job->id ?></li>
    <li>職業名：<?= $job->job_name ?></li>
    <li>体力：<?= $job->vitality ?></li>
    <li>強さ<?= $job->strength ?></li>
  </ul>

  <h2>Player</h2>
  <?php foreach ($job->player as $player) { ?>
    <p>
      <?= $player->id . ',' . $player->name ?>
      <a href='show_player_w4<-8.php?id=<?= $player->id; ?>'>表示</a>
    </p>
  <?php } ?>

  <p><a href='index_w4-8.php'>リストに戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
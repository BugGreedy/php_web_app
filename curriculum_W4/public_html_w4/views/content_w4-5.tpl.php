<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <?php foreach ($players as $player) { ?>
    <p>
      <?= $player->id ?>,
      <?= $player->name ?>,
      <?= $player->level ?>,
      <?= $player->job_id ?>
      <!-- 下記を追記 -->
      <?= $player->job->job_name ?>
    </p>
  <?php } ?>

  <?php include('footer.inc.php'); ?>
</body>

</html>
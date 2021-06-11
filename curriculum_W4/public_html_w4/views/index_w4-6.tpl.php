<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player List</h1>
  <p><?= $message ?></p>

  <?php foreach ($players as $player) { ?>
    <p>
      <?= $player->id ?>,
      <?= $player->name ?>,
      <?= $player->level ?>
      <?= $player->job->job_name ?>
    </p>
  <?php } ?>

  <?php include('footer.inc.php'); ?>
</body>

</html>
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <?php foreach ($players as $player) { ?>
    <p>
      <?= $player['id'] ?>,
      <?= $player['name'] ?>,
      <?= $player['level'] ?>,
    </p>
  <?php } ?>

  <?php include('footer.inc.php'); ?>
</body>

</html>
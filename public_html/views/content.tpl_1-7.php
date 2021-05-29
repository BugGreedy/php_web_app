<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc_1-7.php'); ?>
<body>
  <h1>Hello templates</h1>
  <p>This is <?= $name ?></p>
  <p><?= $message ?></p>
  <?php foreach ($players as $player) { ?>
    <p><?= $player ?>はデーモンと戦った</p>
  <?php } ?>
   <?php include('footer.inc_1-7.php'); ?>
</body>

</html>
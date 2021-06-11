<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player profile</h1>
  <p><?= $message ?></p>

  <ul>
    <li>ID：<?= $player['id'] ?></li>
    <li>名前:<?= $player['name'] ?></li>
    <li>レベル：<?= $player['level'] ?></li>
    <li>職業id：<?= $player['job_id'] ?></li>
  </ul>

  <?php include('footer.inc.php'); ?>
</body>

</html>
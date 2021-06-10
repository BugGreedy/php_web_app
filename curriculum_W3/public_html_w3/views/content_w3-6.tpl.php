<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <!-- 下記が追記箇所 -->
  <table>
    <?php foreach ($results as $player) { ?>
      <tr>
        <td><?= $player['id'] ?></td>
        <td><?= $player['name'] ?></td>
        <td><?= $player['job_name'] ?></td>
        <td><?= $player['level'] ?></td>
      </tr>
    <?php } ?>
  </table>

  <?php include('footer.inc.php'); ?>
</body>

</html>
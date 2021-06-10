<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <table>
    <tr style="background:#ccccff">
      <th>ID</ht>
      <th>名前</ht>
      <th>職業</ht>
      <th>レベル</ht>
      <th>詳細</ht>
    </tr>
    <?php foreach ($results as $player) { ?>

      <tr>
        <td><?= $player['id'] ?></td>
        <td><?= $player['name'] ?></td>
        <td><?= $player['job_name'] ?></td>
        <td><?= $player['level'] ?></td>
        <td><a href='show_player_w3-7.php?id=<?= $player['id'] ?>'>表示</a></td>
      </tr>
    <?php } ?>
  </table>

  <?php include('footer.inc.php'); ?>
</body>

</html>
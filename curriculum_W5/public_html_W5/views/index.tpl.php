<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <table>
    <tr>
      <th>Id</th>
      <th>タイトル</th>
    </tr>
    <?php foreach ($notes as $note) { ?>
      <tr>
        <td><?= $note->id ?></td>
        <td><a href='show.php?id=<?= $note->id ?>'><?= $note->title ?></a></td>
      </tr>
    <?php } ?>
  </table>

  <p>新規メモ</p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
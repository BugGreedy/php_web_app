<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>RPGの戦闘フォーム</h1>
  <p><?= $message ?></p>

  <form action='battle.php' method='post'>
    <select name='name'>
      <?php foreach ($players as $player) { ?>
        <option value='<?= $player ?>'>
          <?= $player ?>
        </option>
      <?php } ?>
    </select>
    <p></p>

    <button type='submit'>たたかう</button>
  </form>
  <!-- <p></p> -->
  <form action='battle.php' method='get'>
    <button type='submit'>にげる</button>
  </form>

    <?php include('footer.inc.php'); ?>
</body>

</html>
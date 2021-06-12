<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player List</h1>
  <p><?= $message ?></p>


  <table>
    <tr style='background: #AD9DED'>
      <th>ID</th>
      <th>名前</th>
      <th>職業</th>
      <th>レベル</th>
      <th>詳細</th>
    </tr>
    <?php foreach ($players as $player) { ?>
      <tr>
        <td><?= $player->id ?></td>
        <td><?= $player->name ?></td>
        <td><?= $player->level ?></td>
        <td><?= $player->job->job_name ?></td>
        <!-- 下記を追記 -->
        <td><a href='http://localhost:8888/php_web_app/curriculum_W4/public_html_w4/show_player_w4-8.php?id=<?= $player->id ?>'>表示</a></td>
      </tr>
    <?php } ?>
  </table>

  <!-- 下記を追記 -->
  <h2>Job List</h2>
  <table>
    <tr style='background: #93F051'>
      <th>ID</th>
      <th>職業名</th>
      <th>体力</th>
      <th>強さ</th>
      <th>詳細</th>
    </tr>
    <?php foreach ($jobs as $job) { ?>
      <tr>
        <td><?= $job->id ?></td>
        <td><?= $job->job_name ?></td>
        <td><?= $job->vitality ?></td>
        <td><?= $job->strength ?></td>
        <td><a href='show_job_w4-8.php?id=<?= $job->id; ?>'>表示</a></td>
      </tr>
    <?php } ?>
  </table>



  <?php include('footer.inc.php'); ?>
</body>

</html>
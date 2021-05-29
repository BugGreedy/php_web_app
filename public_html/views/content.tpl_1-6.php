<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='utf-8'>
  <title>PHP-Web - paiza</title>
  <style>
    body {
      padding: 10px;
    }
  </style>
</head>

<body>
  <h1>Hello templates</h1>
  <p>This is <?= $name ?></p>
  <p><?= $message ?></p>
  <?php foreach($players as $player){ ?>
     <p><?= $player ?>はデーモンと戦った</p>
  <?php } ?>
</body>

</html>
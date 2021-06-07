<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');

$sql = 'SELECT * FROM players';
$statement = $pdo->prepare($sql);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  print_r($row);
  echo ('<br>');
}

$statement = null;
$pdo = null;

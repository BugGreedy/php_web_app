<?php

// $pdo = new PDO('mysql:host=localhost; dbname=LNG_db-sql; charset=utf8', 'root', 'root');
$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8', 'root', 'root');  //ここをPDOという。


$sql = 'SELECT * FROM players';
$statement = $pdo->prepare($sql);
$statement->execute();

$players = [];
while ($player = $statement->fetch(PDO::FETCH_ASSOC)) {
  $players[] = $player;
}

$statement = null;
$pdo = null;

$message = 'hello world';
require_once 'views/content.tpl.php';

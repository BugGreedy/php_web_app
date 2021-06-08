<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8', 'root', 'root');

$sql = 'SELECT name,level FROM players';
$statement = $pdo->prepare($sql);
$statement->execute();

$results = []; 
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  $results[] = $row; 
}

$statement = null;
$pdo = null;

$message = "hello DB";
require_once  'views/content.tpl.php';

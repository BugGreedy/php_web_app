<?php

$pdo = new PDO('mysql:host=localhost; dbname=LNG_db-sql; charset=utf8', 'root', 'root');

$sql = 'SELECT players.id,name,level,job_name FROM players LEFT JOIN jobs ON jobs.id = players.job_id';
$statement = $pdo->prepare($sql);
$statement->execute();

$results = [];
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  $results[] = $row;
}

$statement = null;
$pdo = null;

$message = 'hello world';
require_once 'views/content.tpl.php';

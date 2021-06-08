<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');

$name = "もぐらn号";
$level = 1;
$job_id = 1;
$sql = 'INSERT INTO players (name, level, job_id) VALUES (:name, :level, :job_id)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':level', $level, PDO::PARAM_INT);
$statement->bindValue(':job_id', $job_id, PDO::PARAM_INT);
$statement->execute();

// $sql = 'INSERT INTO players (name, level, job_id) VALUES (:name, :level, :job_id)';
// $sql = 'UPDATE players SET level = 30 WHERE id = 1';
// $sql = 'DELETE FROM players WHERE id = 12';
// $statement = $pdo->prepare($sql);
// $statement->execute();

$sql = 'SELECT * FROM players';
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

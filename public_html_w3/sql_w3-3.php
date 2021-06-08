<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8', 'root', 'root');

$sql = 'SELECT * FROM players WHERE level >= :lower'; 
$statement = $pdo->prepare($sql);
$low_value = 7;                                                //  変数を追記
$statement->bindValue(':lower',$low_value,PDO::PARAM_INT);    // 変数を引数に指定
$statement->execute();

$results = []; 
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  $results[] = $row; 
}

$statement = null;
$pdo = null;

$message = "hello DB";
require_once  'views/content.tpl.php';

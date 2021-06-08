<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');

$sql = 'SELECT * FROM players';   
$statement = $pdo->prepare($sql); 
$statement->execute();            

$results = [];  //追記箇所
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  // print_r($row);
  // echo ('<br>');
  $results[] = $row; //＄resultsに取り出したDBの配列を代入
}

$statement = null;
$pdo = null;

// そして下記2行を追記
$message = "hello DB";
require_once  'views/content.tpl.php';

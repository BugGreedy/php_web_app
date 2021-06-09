<?php

$pdo = new PDO('mysql:host=localhost; dbname=LNG_db-sql; charset=utf8', 'root', 'root');

// idを受け取ったら詳細を表示するという記述を追記
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
}

$sql = 'SELECT players.id, name, level, job_name 
FROM players LEFT JOIN jobs ON jobs.id = players.job_id
WHERE players.id =:id';  //ここを追記

$statement = $pdo->prepare($sql);
$statement->bindValue(':id',$id,PDO::PARAM_INT);
$statement->execute();

// 下記を削除
// $results = [];
// while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
//   $results[] = $row;
// }

// 下記を追記
$player = $statement->fetch(PDO::FETCH_ASSOC);

$statement = null;
$pdo = null;

$message = 'This is profile of the Player.';
require_once 'views/profile.tpl.php';

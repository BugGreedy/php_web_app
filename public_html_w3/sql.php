<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');  //ここをPDOという。

$sql = 'SELECT * FROM players';     //使用するDBを扱うSQL文
$statement = $pdo->prepare($sql);   //$pdoをprepareメソッドでSQL文を使用する準備をして
$statement->execute();              // executeメソッドでSQLを実行。

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {  //DBに問い合わせた結果をfetchメソッドで一行ずつ取り出す。このPDO::の指定で取り出したデータの形式を指定している。(ここではカラム名に添え字をつけた形で指定)
  print_r($row);
  echo ('<br>');
}

$statement = null;
$pdo = null;

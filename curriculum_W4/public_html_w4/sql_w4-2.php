<?php

// $pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8', 'root', 'root');

// 下記を追記
require_once './vendor/autoload.php';  // composerで用意しておいたライブラリを読み込む
$db = new Illuminate\Database\Capsule\Manager;  // 生成したオブジェクトを$DB変数に代入して
$db->addConnection([                             // 下記で接続情報を指定
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'LNG_db-sql',
  'username' => 'root',
  'password' => 'root'
]);
$db->setAsGlobal();   // setAsGlobal()はこの$db変数をどこからでも利用できるようにするメソッド。 
$db->bootEloquent();  // bootEloquent()はORマッパーを起動する。
// ここまでが接続情報を指定して実行している箇所



// 下記はデータを取り出す記述箇所
class Player extends Illuminate\Database\Eloquent\Model { 
} 
// 取り出したデータを格納するクラスを定義
// このときeloquentではクラス名を複数名にしたものが自動的にテーブル名になる。また、カラムなどを自動的に取得してくれる。

// $sql = 'SELECT * FROM players';
// $statement = $pdo->prepare($sql);
// $statement->execute();

// $players = [];
// while ($player = $statement->fetch(PDO::FETCH_ASSOC)) {
//   $players[] = $player;
// }

// $statement = null;
// $pdo = null;


$players = Player::all();  // $SQL以降を削除し、ここを追記
$message = 'hello world';
require_once 'views/content.tpl.php';

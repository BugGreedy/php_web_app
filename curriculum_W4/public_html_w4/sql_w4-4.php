<?php

require_once './vendor/autoload.php';
$db = new Illuminate\Database\Capsule\Manager;
$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'LNG_db-sql',
    'username'  => 'root',
    'password'  => 'root'
]);
$db->setAsGlobal();
$db->bootEloquent();

class Player extends Illuminate\Database\Eloquent\Model {
  // 下記を追記
  public $timestamps = false; // ←備考1
}

// // 下記は更新の際のコード
$players = Player::where('id','>=',11)->delete();


// 下記は更新の際のコード
// $player = Player::find(19);
// $player-> level += 1;
// $player-> save();

// 下記は追加の際のコード
// クラスでオブジェクトを生成するような感じの記述でレコードを追加する
// $player = new Player;
// $player->name = 'もぐらeloquent号';
// $player->level = '1';
// $player->job_id = '1';
// $player->save();  // これで配列にオブジェクトを格納している

$players = Player::all();
$message = 'hello world';
require_once 'views/content_w4-4.tpl.php';

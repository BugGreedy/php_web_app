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

// 下記を追記
use Illuminate\Database\Eloquent\Model;  // これはclassを定義する時に、親クラスのパスを省略できる宣言。

// class Player extends Illuminate\Database\Eloquent\Model
// {
//   public $timestamps = false;
// }

// classの箇所を下記のように編集
class Player extends Model{
  public $timestamps = false;
  public function job(){
    return $this->belongsTO('Job');  // belongsTo('テーブル名')で"テーブル名に所属する"となる。
    // 今回はplayersテーブルはjobテーブルに所属するとなる。→ 多対1の関係を表している。
  }
}

// 次にjobsテーブルのモデルを定義する。
class Job extends model{
}

$players = Player::all();
$message = 'hello world';
require_once 'views/content_w4-5.tpl.php';

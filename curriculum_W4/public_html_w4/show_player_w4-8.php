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

use Illuminate\Database\Eloquent\Model;

class Player extends Model{
  public $timestamps = false;
  public function job(){
    return $this->belongsTo('Job');
  }
}

class Job extends Model{
  //  下記を追記
  public function player(){
    return $this->hasMany('Player');
  }
}
// 下記を追記。GETメソッドで指定されたidを取得したら〜という条件記述
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
}

// 取得したidを代入
$player = Player::find($id);
$message = 'This is Profile.';
require_once 'views/profile_w4-8.tpl.php';
// print_r($player);

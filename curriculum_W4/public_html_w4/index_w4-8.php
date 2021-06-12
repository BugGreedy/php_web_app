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

class Player extends Model
{
  public $timestamps = false;
  public function job()
  {
    return $this->belongsTo('Job');
  }
}

class Job extends Model
{
}

$players = Player::all();
$jobs = Job::all();
$message = 'hello world';
require_once 'views/index_w4-8.tpl.php';

<?php

require_once './vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Model;

$db = new Capsule;
$db->addConnection([
  'driver'    => 'mysql',
  'host'      => 'localhost',
  'database'  => 'memo',
  'username'  => 'root',
  'password'  => 'root'
]);

$db->setAsGlobal();
$db->bootEloquent();

class Note extends Model {
}

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
}

// $players = Player::all();
// $players = Player::select('*')->get();
// $players = Player::where('level','>=',5)->get();
$player = Player::find(3);
$message = 'hello world';
// require_once 'views/content.tpl.php';
require_once 'views/profile.tpl.php';

<?php

    // $pdo = new PDO('mysql:host=localhost; dbname=mydb; charset=utf8','root','');

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

    // $sql = 'SELECT * FROM players;';
    // $statement = $pdo->prepare($sql);
    // $statement->execute();
    //
    // $players = [];
    // while ($player = $statement->fetch(PDO::FETCH_ASSOC)) {
    //     $players[] = $row;
    // }
    //
    // $statement = null;
    // $pdo = null;

    $players = Player::all();
    $message = 'hello world';
    require_once 'views/content.tpl.php';
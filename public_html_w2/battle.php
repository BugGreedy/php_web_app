<?php
$players = ['ガンサー','太刀ラー','ガンナー','燻り続けるもの'];

if(isset($_REQUEST['name'])){
  $message = htmlspecialchars($_REQUEST['name']).'はモンスターと戦った。';
}else{
  $message = '新たなモンスターが現れた';
}


require_once 'views/battle.tpl.php';

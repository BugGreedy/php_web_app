<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];

  $message = 'Show note #'. $id;
  $note = Note::find($id);
}

// 下記を追記
// $my_html = Michelf\Markdown::defaultTransform($note->content);

require_once 'views/show.tpl.php';
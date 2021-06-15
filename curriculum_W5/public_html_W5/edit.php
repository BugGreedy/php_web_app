<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $message = 'Edit note #'. $id;
  $note = Note::find($id);
}

// 下記を編集用のテンプレートに変更
require_once 'views/edit.tpl.php';

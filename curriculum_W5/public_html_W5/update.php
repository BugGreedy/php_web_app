<?php

require_once 'db_connect.php';

// 下記を追記 (これまで同様に指定のidを受け取ったらという条件を記述)
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $note = Note::find($id);
  $note->title = $_REQUEST['title'];
  $note->content = $_REQUEST['content'];
  $note->save();
}

header('Location: show.php?id='.$note->id); 
exit;

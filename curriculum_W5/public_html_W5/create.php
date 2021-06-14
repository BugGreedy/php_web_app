<?php

require_once 'db_connect.php';

$note = new Note;                      // 新規のNoteオブジェクトをセットして
$note->title = $_REQUEST['title'];     // フォームから受け取った情報を入力
$note->content = $_REQUEST['content'];
$note->save();                         // それから保存している。

header('Location: show.php?id='.$note->id);  // show.phpを呼び出して、別のページに処理を切り替えている。
exit;   // 切り替え先のページの処理を中断

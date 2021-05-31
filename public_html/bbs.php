<?php
$message = 'Hello World';

$lines = file(__DIR__.'/articles.txt',FILE_IGNORE_NEW_LINES);

require_once 'views/bbs.tpl.php';
<?php
$message = 'ここはresult.php';

$article = htmlspecialchars($_REQUEST['article']);
$name = htmlspecialchars($_REQUEST['name']);

require_once 'views/result.tpl.php';

<?php

require_once 'db_connect.php';

$message = 'Hello World';
$notes = Note::all();

require_once 'views/index.tpl.php';

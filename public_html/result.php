<?php
  $message = 'This is paiza';

  $article = htmlspecialchars($_REQUEST['article']);
  $name = htmlspecialchars($_REQUEST['name']);

  require_once 'views/form.tpl.php';
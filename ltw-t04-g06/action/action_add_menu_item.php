<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/menu.class.php');




  $db = getDatabaseConnection();
  
  if(Menu::existsItem($db,(int)$_POST['id'] ,$_POST['name'])){
    $_SESSION['ERROR'] = 'Menu item already exists';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }

  else if (Menu::addMenuItem($db,(int) $_POST['id'],$_POST['name'],(int)$_POST['price'],$_POST['category'])){
    $next="Location:../pages/menu.php?id=". $_POST['id'];
    header($next);
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
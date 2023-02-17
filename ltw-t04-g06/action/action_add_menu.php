<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/menu.class.php');
  require_once('../database/restaurant.class.php');



  $db = getDatabaseConnection();
  if (!Restaurant::isOwnerOfRestaurant($db,(int)$_POST['id'],$_SESSION['id'])){
    die(header('Location: /'));
  }
  
  
  if(Restaurant::existsMenu($db,(int)$_POST['id'] ,$_POST['name'])){
    $_SESSION['ERROR'] = 'Menu already exists';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  else if (Restaurant::addMenu($db,(int) $_POST['id'],$_POST['name'])){
    $next="Location:../pages/restaurant.php?id=". $_POST['id'];
    header($next);
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/restaurant.class.php');



  $db = getDatabaseConnection();

  $id=Restaurant::getOwnerID($db,(int) $_SESSION['id']);
  
  
  if (Restaurant::addRestaurant($db,$id,$_POST['name'],$_POST['adress'],$_POST['category'])){
    header("Location:../pages/profile.php?id=owner");
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
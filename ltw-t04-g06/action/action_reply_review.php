<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/review.class.php');
  require_once('../database/user.class.php');
  require_once('../database/restaurant.class.php');



  $db = getDatabaseConnection();  

  //$Cid=User::getCustomerID($db,$_SESSION['username']);
  
  if(!Restaurant::isOwnerOfRestaurant($db,(int)$_POST['id2'],$_SESSION['id'])){
    die(header('Location: /'));
  }
  else if (Review::Reply($db,(int) $_POST['id'],$_POST['reply'])){
    $next="Location:../pages/review.php?id=". $_POST['id2'];
    header($next);
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
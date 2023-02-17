<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/request.class.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();
  $state="";
  if ($_POST['state']=="13"){
      $state="Received";
  }
  if ($_POST['state']=="38"){
    $state="Preparing";
}
if ($_POST['state']=="63"){
    $state="Ready";
}
if ($_POST['state']=="88"){
    $state="Delivered";
}
  

    if (!(Restaurant::isOwnerOfRestaurant($db,Request::getRestaurantIdByRequest($db,(int)$_POST['id']),$_SESSION['id']))){
        die(header('Location: /'));
    }

    else if (Request::updateState($db,(int)$_POST['id'],$state)){
        $next="Location:../pages/request.php?id=". $_POST['id'];
        header($next);
    }
    else{
      $_SESSION['ERROR'] = 'ERROR';
      header("Location:".$_SERVER['HTTP_REFERER']."");
    }
  

  
?>
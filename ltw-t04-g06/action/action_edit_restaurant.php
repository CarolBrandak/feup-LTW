<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $restaurant = Restaurant::getRestaurant($db,(int)$_POST['id']);

  if ($restaurant) {
    $restaurant->name = $_POST['name'];
    $restaurant->adress = $_POST['adress'];
    $restaurant->category = $_POST['category'];
    $restaurant->save($db);
    $next="Location:../pages/restaurant.php?id=". $_POST['id'];
    header($next);
  }
  else{
    $_SESSION['ERROR'] = 'Something went wrong';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  
?>
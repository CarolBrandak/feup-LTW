<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  if ($_POST['delete']&&$_SESSION['cart'][$_POST['delete']]){
    unset($_SESSION['cart'][$_POST['delete']]);
    if (!$_SESSION['cart']){
      $_SESSION['cartRestaurant'] = 'empty';
    }
  }
  else{
    if ($_SESSION['cart'][$_POST['id']]){
      $_SESSION['cart'][$_POST['id']]['quantity']=(int)$_SESSION['cart'][$_POST['id']]['quantity'] + (int)$_POST['quantity'];
    }
    else{
      $_SESSION['cart'][$_POST['id']]['quantity']=(int)$_POST['quantity'];
      $_SESSION['cart'][$_POST['id']]['price']=(float)$_POST['price'];
      $_SESSION['cartRestaurant'] = Restaurant::getRestaurantIdFromItem($db,(int)$_POST['id']);
    }
  }
  
  

  header("Location:".$_SERVER['HTTP_REFERER']."");

    
?>

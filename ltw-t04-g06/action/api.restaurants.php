<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $restaurants = Restaurant::searchRestaurants($db, $_GET['search'], 8);
  
  echo json_encode($restaurants);
?>
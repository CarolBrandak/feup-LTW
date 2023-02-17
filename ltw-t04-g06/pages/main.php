<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/restaurant.class.php');

  require_once('../templates/common.php');
  require_once('../templates/restaurants.php');

  $db = getDatabaseConnection();
  
  
  drawHeader();
  $restaurants = Restaurant::getRestaurantsObjects($db,4);
      function cmp($a, $b) {
        return $b->rating <=> $a->rating;
      }
      usort($restaurants, "cmp");
  drawRestaurants($restaurants);
  drawFooter();
?>
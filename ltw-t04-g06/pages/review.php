<?php
  declare(strict_types = 1);

  session_start();
  
  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');

  require_once('../database/review.class.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/request.class.php');

  require_once('../templates/common.php');
  require_once('../templates/reviews.php');


  $db = getDatabaseConnection();

  error_reporting(E_ERROR | E_PARSE);

  $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
  $reviews = Review::getRestaurantReviews($db,$restaurant->id);
  


  drawHeader();
  if (Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])&&$_GET['id2']=="answer"){
    $review=Review::getReview($db,(int) $_GET['id3']);
    drawReplyForm($review,$restaurant);
  }
  else if (Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])){
    drawOwnerReviews($reviews,$restaurant);
  }
  else if ($_SESSION['usertype']=="Restaurant Owner"){
    drawReviews($reviews,$restaurant);
  }
  else if ($_SESSION['usertype']=="Customer"){
    if (!Request::isCustomerCompletedRequest($db,$_SESSION['username'],(int)$_GET['id'])){
      drawReviews($reviews,$restaurant);
      if ($_GET['id2']=="review"){
        $_SESSION['ERROR'] = 'You can only place a review after every completed order';
        header("Location:".$_SERVER['HTTP_REFERER']."");

      }
    }
    else{
      if ($_GET['id2']=="review"){
        drawReviewForm($restaurant);
      }
      else{
        drawReviews($reviews,$restaurant);
      }
    }
  }
  else{
    
  }
  drawFooter();
?>
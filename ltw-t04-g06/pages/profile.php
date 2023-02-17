<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/user.class.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/review.class.php');
  require_once('../database/request.class.php');
  require_once('../database/menu_item.class.php');

  require_once('../templates/common.php');
  require_once('../templates/users.php');
  require_once('../templates/restaurants.php');
  require_once('../templates/reviews.php');
  require_once('../templates/requests.php');

  $db = getDatabaseConnection();
  
  error_reporting(E_ERROR | E_PARSE);

  $user = User::getUser($db, $_SESSION['id']);

  drawHeader();
  if($_GET['id']=='account'){
    drawAccountInfoForm();
  }
  else if ($_GET['id']=='profile'){
    drawProfileInfoForm($user);
  }
  else if ($_GET['id']=='reviews'&&$_SESSION['usertype']=='Restaurant Owner'){
    $reviews=Review::getOwnerReviews($db,(int)$_SESSION['id']);
    drawProfileReviews($reviews);
  }
  else if ($_GET['id']=='Rorders'&&$_SESSION['usertype']=='Restaurant Owner'){
    $requests=Request::getOwnerOrders($db,(int)$_SESSION['id']);
    drawProfileRequests($requests);
  }
  else if ($_GET['id']=='Corders'&&$_SESSION['usertype']=='Customer'){
    $requests=Request::getCustomerOrders($db,(int) User::getCustomerID($db,$_SESSION['username']));
    drawProfileRequests($requests);
  }
  else if ($_GET['id']=='photo'){
    $_SESSION['userinfo']['Photo']=$user->photo;
    drawUserPictureForm();
  }
  else if ($_GET['id']=='favorites'&&$_SESSION['usertype']=='Customer'){
    $items = Menu_Item::getFavoriteItems($db,(int) User::getCustomerID($db,$_SESSION['username']));
    $restaurants = Restaurant::getFavoriteRestaurants($db,(int) User::getCustomerID($db,$_SESSION['username']));
    drawProfileFavorites($items,$restaurants);
  }
  else if ($_GET['id']=='owner'&&$_SESSION['usertype']=='Restaurant Owner'){
    $restaurants = Restaurant::getRestaurantsWithOwner($db, $_SESSION['id']);
    if($restaurants!=null){
      drawProfileRestaurants($restaurants);
    }
    else{
      
      drawOwnerNoRestaurants();
    }
  }
  else{
    if ($_SESSION['usertype']=='Restaurant Owner'){
      drawProfileOwner($user);
    }
    else{
      drawProfileCustomer($user);
    }
  }
  drawFooter();
?>
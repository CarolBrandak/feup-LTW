<?php
  declare(strict_types = 1);

  session_start();
  
  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');

  require_once('../database/restaurant.class.php');
  require_once('../database/menu.class.php');
  require_once('../database/user.class.php');

  require_once('../templates/common.php');
  require_once('../templates/restaurants.php');

  $db = getDatabaseConnection();
  
  error_reporting(E_ERROR | E_PARSE);

  drawHeader();
  if ($_GET['id']=='search'){
    if ($_GET['id2']==NULL){
      drawRestaurantSearch();
    }
    else if ($_GET['id2']=='name'){
      drawRestaurantSearchResults('name',[]);
    }
    else if ($_GET['id2']=='item'){
      drawRestaurantSearchResults('item',[]);
    }
    else if($_GET['id2']=='rating'){
      $restaurants = Restaurant::getRestaurantsObjects($db,10);
      function cmp($a, $b) {
        return $b->rating <=> $a->rating;
      }
      usort($restaurants, "cmp");
      drawRestaurantSearchResults('rating',$restaurants);
    }
    else if($_GET['id2']=='itemR'){
      drawRestaurantSearchResults('itemR',[]);
    }
    else{
      die(header('Location: /'));
    }
    
  }

  else if($_GET['id']=='add'){
    if ($_SESSION['usertype']=='Restaurant Owner'){
      drawNewRestaurantForm();
    }
    else{
      die(header('Location: /'));
    }
    
  }
  else{
    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    $menus = Menu::getRestaurantMenus($db, intval($_GET['id']));
    if ($_GET['id2']=='edit'&&Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])){
      drawRestaurantInfoForm($restaurant);
    }
    else if($_GET['id2']=='edit2'&&Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])){
      drawNewMenuForm($restaurant);
    }
    else if($_GET['id2']=='photo'&&Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])){
      $_SESSION['rinfo']['Photo']=$restaurant->photo;
      drawRestaurantPictureForm($restaurant);
    }
    else{
      if (Restaurant::isOwnerOfRestaurant($db,(int)$_GET['id'],$_SESSION['id'])){
        drawRestaurantOwner($restaurant,$menus);
        
      }
      else{
        $favorite=User::isRestaurantFavorite($db,$restaurant->id);
        drawRestaurant($restaurant, $menus,$favorite);
      }
    }
  }
  drawFooter();
?>
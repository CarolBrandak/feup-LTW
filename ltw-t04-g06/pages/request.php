<?php
  declare(strict_types = 1);

  session_start();
  
  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');

  require_once('../database/request.class.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/menu_item.class.php');

  require_once('../templates/common.php');
  require_once('../templates/requests.php');


  $db = getDatabaseConnection();

  $request=Request::getRequest($db,(int)$_GET['id']);

  
  

  drawHeader();
  if (Restaurant::isOwnerOfRestaurant($db,Request::getRestaurantIdByRequest($db,(int)$_GET['id']),$_SESSION['id'])&&$_GET['id2']=="state"&&$request->state!="Delivered"){
    drawOwnerOrderForm($request);
  }
  else if (Restaurant::isOwnerOfRestaurant($db,Request::getRestaurantIdByRequest($db,(int)$_GET['id']),$_SESSION['id'])){
    $items=Menu_Item::getItemsByRequest($db,(int)$_GET['id']);
    drawOwnerRequest($request,$items);
  }
  else if($request->customer==$_SESSION['name']){
  
    $items=Menu_Item::getItemsByRequest($db,(int)$_GET['id']);
    drawCustomerRequest($request,$items);
  }
  else{

    die(header('Location: /'));
  }
  drawFooter();
?>
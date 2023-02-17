<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) 
  if ($_SESSION['usertype']!='Customer'){
    die(header('Location: /'));
  }

  require_once('../database/connection.php');
  require_once('../database/menu_item.class.php');

  require_once('../templates/common.php');
  require_once('../templates/carts.php');


  $db = getDatabaseConnection();

  error_reporting(E_ERROR | E_PARSE);

  $itemsByMenu=Menu_Item::getItemsByMenu($db,(int)$_GET['id']);
  
  
  drawHeader();
  if ($_SESSION['cartRestaurant']=='empty' && $_GET['id']=='empty'){
    drawEmptyCart();
  }
  else if($_SESSION['cartRestaurant']!='empty'&&$_GET['id']!=$_SESSION['cartRestaurant']){
    $_SESSION['ERROR'] = 'You can only have items in your cart from one restaurant at a time and you already have some from this one';
    $next="Location:../pages/cart.php?id=". $_SESSION['cartRestaurant'];
    die(header($next));
    
  
  }
  else{
    if ($itemsByMenu!=NULL){

      drawCart($itemsByMenu,(int)$_GET['id']);
    }
    else{
      drawEmptyRestaurant();
    }
  }
  drawFooter();
?>
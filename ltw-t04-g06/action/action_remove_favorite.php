<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/user.class.php');




  $db = getDatabaseConnection();

  
  
  if($_SESSION['usertype']!='Customer'){
    die(header('Location: /'));
  }
  else if ($_POST['type']=='restaurant'){
    
    
    if(!User::isRestaurantFavorite($db,(int) $_POST['id'])){
        $_SESSION['ERROR'] = 'It is already marked as a favorite';
        header("Location:".$_SERVER['HTTP_REFERER']."");
    }
    else{
      if (User::removeFavoriteRestaurant($db,(int) User::getCustomerID($db,$_SESSION['username']),(int) $_POST['id'])){
        $next="Location:../pages/restaurant.php?id=". $_POST['id'];
        header($next);
      }
      var_dump("hey2");
      exit();
    }
  }
  else if ($_POST['type']=='item'){
    if(!User::isItemFavorite($db,(int) $_POST['id'])){
        $_SESSION['ERROR'] = 'It is already marked as a favorite';
        header("Location:".$_SERVER['HTTP_REFERER']."");
    }
    else if (User::removeFavoriteItem($db,(int)User::getCustomerID($db,$_SESSION['username']),(int) $_POST['id'])){
        $next="Location:../pages/menu.php?id=". $_POST['id2'];
        header($next);
    }
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
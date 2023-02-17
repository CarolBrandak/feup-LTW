<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/request.class.php');
  require_once('../database/menu_item.class.php');
  require_once('../database/user.class.php');


  if (!isset($_SESSION['cart'])){
    die(header('Location: /'));
  }


  $db = getDatabaseConnection();  

  if ($Cid=User::getCustomerID($db,$_SESSION['username'])){
      Request::CreateRequest($db,(int)$Cid);
      $request=Request::getLatestRequest($db,(int)$Cid);
      
      foreach ($_SESSION['cart'] as $i => $item){
          Request::InsertItemRequest($db,(int)$request,(int)$i,(int)$item['quantity']);
      }
      unset($_SESSION['cart']);
      $_SESSION['cartRestaurant'] = 'empty';
      $next="Location:../pages/request.php?id=". $request;
    header($next);
  }
  
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
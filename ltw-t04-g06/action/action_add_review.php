<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/review.class.php');
  require_once('../database/user.class.php');



  $db = getDatabaseConnection();  

  $Cid=User::getCustomerID($db,$_SESSION['username']);
  
  if (Review::addReview($db,(int) $_POST['id'],(int)$Cid,(int)$_POST['stars'],$_POST['comment'])){
    $next="Location:../pages/review.php?id=". $_POST['id'];
    header($next);
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
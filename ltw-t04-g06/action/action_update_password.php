<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $_SESSION['id']);

  if ($user) {
    if ($_POST['password']!=$_POST['repeat']){
      $_SESSION['ERROR'] = 'Passwords dont match';
      header("Location:".$_SERVER['HTTP_REFERER']."");
    }
    else if (!(6<=strlen($_POST['password']))){
      $_SESSION['ERROR'] = 'Password must have at least 6 characters';
      header("Location:".$_SERVER['HTTP_REFERER']."");
    }
    else if (User::updatePassword($db,$user->id,$_POST['password'])){
      header("Location:../pages/login.php");
    }
    else{
      $_SESSION['ERROR'] = 'ERROR';
      header("Location:".$_SERVER['HTTP_REFERER']."");
    }
  }

  
?>

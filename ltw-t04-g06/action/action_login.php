<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();
  

  $user = User::getUserWithPassword($db, $_POST['email/username'], $_POST['password']);

  if ($user) {
    $_SESSION['id'] = $user->id;
    $_SESSION['name'] = $user->name();
    $_SESSION['username'] = $user->username;
    
    if ($user->owner){
      $_SESSION['usertype'] = 'Restaurant Owner';
      
    }
    else{
      $_SESSION['usertype'] = 'Customer';
      $_SESSION['cartRestaurant'] ='empty';
    }
    header('Location: ../pages/main.php');
  }
  else{
    $_SESSION['ERROR'] = 'Login failed. Please make sure you typed the right email/password';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }

?>
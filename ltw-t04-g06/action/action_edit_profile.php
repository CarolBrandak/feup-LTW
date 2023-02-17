<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $_SESSION['id']);

  if ($user) {
    if (User::existsPhone($db,$_POST['phone'],$user->id)&&$_POST['phone']!='empty'){
      $_SESSION['ERROR'] = 'Phone number already exists';
      header("Location:".$_SERVER['HTTP_REFERER']."");
    }
    else{
      $user->firstName = $_POST['first_name'];
      $user->lastName = $_POST['last_name'];
      $user->adress = $_POST['adress'];
      $user->phone = $_POST['phone'];
      $user->save($db);
      $_SESSION['id'] = $user->id;
      $_SESSION['name'] = $user->name();
      echo 'Profile information updated successfully';
      header("Location:../pages/profile.php");
    }
    
    
  }
  
?>

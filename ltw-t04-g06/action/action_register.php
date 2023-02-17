<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  if ($_POST['check']==null){
    $_SESSION['ERROR'] = 'Please choose whether you are a restaurant owner or a customer';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  
  
  else if(User::existsUsername($db, $_POST['username'])){
    $_SESSION['ERROR'] = 'User already exists';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  
  
  else if(User::existsEmail($db, $_POST['email'])){
    $_SESSION['ERROR'] = 'User already exists';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }

  else if (strlen($_POST['password'])<6){
    $_SESSION['ERROR'] = 'Password must have at least 6 characters';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }

  else if ($_POST['password']!=$_POST['repeat']){
    $_SESSION['ERROR'] = 'Passwords dont match';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }

  else if (!(preg_match( "/^[A-Za-z0-9_]{3,20}$/", $_POST['username'] ))){
    $_SESSION['ERROR'] = 'username cannot contain special characters';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  
  else if ((User::createUser($db, $_POST['username'], $_POST['password'], $_POST['first_name'],$_POST['last_name'], $_POST['email'],$_POST['check'])) != -1) {
    echo 'User Registered successfully';
    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
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
   
    header("Location:../index.php");	
    
  }
  
  else{
    $_SESSION['ERROR'] = 'ERROR';
    header("Location:".$_SERVER['HTTP_REFERER']."");
  }
  


?>
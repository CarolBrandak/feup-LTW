<?php
  
  if(!isset($_SESSION['id'])){
    header("Location:pages/login.php");
  } else {
  	header("Location:pages/main.php");
  }
?>
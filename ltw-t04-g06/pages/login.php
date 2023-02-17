<?php
  declare(strict_types = 1);

  session_start();

  if(isset($_SESSION['id'])){
    header("Location:main.php");
  }

  require_once('../templates/logins.php');
  require_once('../templates/common.php');
  drawLogin();
  drawFooter();
?>
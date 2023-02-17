<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('../database/connection.php');
  require_once('../database/menu_item.class.php');

  $db = getDatabaseConnection();

  $items = Menu_Item::searchItems($db, $_GET['search'], 8);

  echo json_encode($items);
?>
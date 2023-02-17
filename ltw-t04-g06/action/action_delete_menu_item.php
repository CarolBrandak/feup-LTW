<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['id'])) die(header('Location: /'));
  
    require_once('../database/connection.php');
    require_once('../database/menu_item.class.php');
    require_once('../database/restaurant.class.php');
  
    $db = getDatabaseConnection();
    
    

    if(!Restaurant::isOwnerOfRestaurant($db,(int)$_POST['restaurant'],$_SESSION['id'])){
        die(header('Location: /'));
    } 
    else {
        if(Menu_Item::deleteItem($db,(int) $_POST['item'])) {
            $next = "Location:../pages/menu.php?id=" . $_POST['menu']; 
            header($next);
        }
        else {
            $_SESSION['ERROR'] = "Error deleting this item";
            header("Location:".$_SERVER['HTTP_REFERER']."");
        }
    }
?>
<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['id'])) die(header('Location: /'));
  
    require_once('../database/connection.php');
    require_once('../database/menu.class.php');
    require_once('../database/restaurant.class.php');
  
    $db = getDatabaseConnection();
    
    

    if(!Restaurant::isOwnerOfRestaurant($db,(int)$_POST['restaurant'],$_SESSION['id'])){
        die(header('Location: /'));
    } 
    else {
        if(Menu::deleteMenu($db,(int) $_POST['menu'])) {
            $next = "Location:../pages/restaurant.php?id=" . $_POST['restaurant']; 
            header($next);
        }
        else {
            $_SESSION['ERROR'] = "Error deleting this menu";
            header("Location:".$_SERVER['HTTP_REFERER']."");
        }
    }
?>
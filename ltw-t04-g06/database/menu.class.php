<?php
  declare(strict_types = 1);

  class Menu {
    public int $id;
    public string $name;
    public int $restaurant;

    public function __construct(int $id, string $name, int $restaurant)
    {
      $this->id = $id;
      $this->name = $name;
      $this->restaurant = $restaurant;
      
    }

    static function getRestaurantMenus(PDO $db, int $id) : array {
        $stmt = $db->prepare('
          SELECT id, name, restaurant
          FROM menu  
          WHERE restaurant = ?
        ');
        $stmt->execute(array($id));
    
        
    
        return $stmt->fetchAll();
    }

    static function getMenu(PDO $db, int $id) : Menu {
        $stmt = $db->prepare('SELECT id,name,restaurant FROM menu WHERE id = ?');
        $stmt->execute(array($id));
        $menu = $stmt->fetch();
        return new Menu(
          (int) $menu['id'], 
          $menu['name'], 
          (int) $menu['restaurant']
        );
    }

    function existsItem(PDO $db, int $Mid, string $name) {
      try {
        $stmt = $db->prepare('SELECT id FROM menu WHERE id = ? AND id = (SELECT menu FROM menu_item WHERE name = ?)');
        $stmt->execute(array($Mid,$name));
        if ($stmt->fetch()){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }

    function addMenuItem(PDO $db,int $Mid ,string $name, int $price, string $category ){
      try {
        $stmt = $db->prepare('INSERT INTO menu_item(name,price,category,menu) VALUES (:name,:price,:category,:menu)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':menu', $Mid);
        if ($stmt->execute()){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }
    
    function getMenuName(PDO $db,int $id) {
      try {
        $stmt = $db->prepare('SELECT name FROM menu WHERE id = ?');
        $stmt->execute(array($id));
        if($id = $stmt->fetch()){
          return (string)$id['name'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }

    function deleteMenu(PDO $db,int $id) {
      try {
        $stmt = $db->prepare('DELETE FROM menu WHERE id = ?');
        $stmt->execute(array($id));
        return true;
      }
      catch(PDOException $e) {
        return false;
      }
    }
  
  }
?>
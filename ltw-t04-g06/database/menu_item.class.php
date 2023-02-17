<?php
  declare(strict_types = 1);

  class Menu_Item {
    public int $id;
    public string $name;
    public float $price;
    public string $photo;
    public string $category;
    public int $menu;
    public int $quantity;
    public bool $active;


    public function __construct(int $id, string $name, float $price, string $photo, string $category, int $menu, int $quantity,bool $active) {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->photo = $photo;
      $this->category = $category;
      $this->menu = $menu;
      $this->quantity = $quantity;
      $this->active = $active;
    }

    static function getMenuItems(PDO $db, int $id) : array {
        $stmt = $db->prepare('SELECT id, name, price, photo, category, menu,status FROM menu_item WHERE menu = ?');
        $stmt->execute(array($id));
    
        $menu_items = [];
        
        while ($item = $stmt->fetch()) {
          $active=false;
          if ($item['status']=="1"){
            
            $active=true;
          }
       
          $menu_items[] = new Menu_Item(
            (int) $item['id'],
            $item['name'],
            (float) $item['price'],
            $item['photo'],
            $item['category'],
            (int) $item['menu'],
            0,
            $active
            
          );

        }
       
    
        return $menu_items;
    }


    static function getMenuItem(PDO $db, int $id) : Menu_Item {
      $stmt = $db->prepare('SELECT id,name,price,photo,category,menu,status FROM menu_item WHERE id = ?');
      $stmt->execute(array($id));
      $item = $stmt->fetch();
      $active=false;
      if ($item['status']=="1"){
        $active=true;
      }
      return new Menu_Item(
        (int) $item['id'],
        $item['name'],
        (float) $item['price'],
        $item['photo'],
        $item['category'],
        (int) $item['menu'],
        0,
        $active
      );
    }

    function updateItemPhoto(PDO $db,int $id, string $photoPath) {
      try {
        $stmt = $db->prepare('UPDATE menu_item SET photo = ? WHERE id = ?');
        if($stmt->execute(array($photoPath, $id)))
            return true;
        else
            return false;
      }catch(PDOException $e) {
        return false;
      }
    } 
    
  
    function getItemPhoto(PDO $db, int $id) {
      try {
        $stmt = $db->prepare('SELECT photo FROM menu_item WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
      
      }catch(PDOException $e) {
        return null;
      }
    }


    static function getItemsByRequest(PDO $db, int $id) : array {
      $stmt = $db->prepare('select menu_item.id,name,price,photo,category,menu,quantity from menu_item,requestMenuItem where menu_item.id=requestMenuItem.menu_item and request = ?');
      $stmt->execute(array($id));
  
      $menu_items = [];
      $active=true;
      while ($item = $stmt->fetch()) {
        $menu_items[] = new Menu_Item(
          (int) $item['id'],
          $item['name'],
          (float) $item['price'],
          $item['photo'],
          $item['category'],
          (int) $item['menu'],
          (int) $item['quantity'],
          $active
          
        );
      }
  
      return $menu_items;
    }

    static function getFavoriteItems(PDO $db, int $id) : array {
      $stmt = $db->prepare('select id,name,price,photo,category,menu,status from menu_item where id in (select menu_item from favouriteMenuItem where customer = ?)');
      $stmt->execute(array($id));
  
      $menu_items = [];
  
      while ($item = $stmt->fetch()) {
        $active=false;
        if ($item['status']=="1"){
          $active=true;
        }
        $menu_items[] = new Menu_Item(
          (int) $item['id'],
          $item['name'],
          (float) $item['price'],
          $item['photo'],
          $item['category'],
          (int) $item['menu'],
          0,
          $active
        );
      }
  
      return $menu_items;
    }

    static function getItemsByMenu(PDO $db, int $id) {
      $stmt = $db->prepare('select menu_item.id,menu_item.name,price,photo,category,menu.id as menu, menu_item.status from menu_item,menu where menu_item.menu=menu.id and menu.restaurant = ? order by menu.id');
      $stmt->execute(array($id));
      $menu_items = [];
  
      while ($item = $stmt->fetch()) {
        $active=false;
        if ($item['status']=="1"){
          $active=true;
        }
        $menu_items[] = new Menu_Item(
          
          (int) $item['id'],
          $item['name'],
          (float) $item['price'],
          $item['photo'],
          $item['category'],
          (int) $item['menu'],
          0,
          $active
        );

      }
      return $menu_items;
    }


    static function searchItems(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare("SELECT id, name,price,photo,category,menu,status FROM menu_item WHERE name LIKE ?  LIMIT ?");
      $stmt->execute(array($search . '%', $count));
      $item = array();
  
      while ($item = $stmt->fetch()) {
        $active=false;
        if ($item['status']=="1"){
          $active=true;
        }
        $menu_items[] = new Menu_Item(
          (int) $item['id'],
          $item['name'],
          (float) $item['price'],
          $item['photo'],
          $item['category'],
          (int) $item['menu'],
          0,
          $active
        );
      }
      
  
      return $menu_items;
    }


    static function getItemName(PDO $db,int $id) {
      try {
        $stmt = $db->prepare('SELECT name FROM menu_item WHERE id = ?');
        $stmt->execute(array($id));
        if($id = $stmt->fetch()){
          return (string)$id['name'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }


    function deleteItem(PDO $db,int $id) {
      $inactive = 0;
      try {
        $stmt = $db->prepare('UPDATE menu_item SET status = ? WHERE id = ?');
        $stmt->execute(array($inactive,$id));
        return true;
      }
      catch(PDOException $e) {
        return false;
      }
    }
  }
?>
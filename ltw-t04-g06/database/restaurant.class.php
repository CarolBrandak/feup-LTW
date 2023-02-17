<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public string $adress;
    public string $category;
    public string $photo;
    public float $rating;
    

    public function __construct(int $id, string $name, string $adress, string $category,string $photo,float $rating)
    { 
      $this->id = $id;
      $this->name = $name;
      $this->adress = $adress;
      $this->category = $category;
      $this->photo = $photo;
      $this->rating = $rating;
      
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE restaurants SET name = ?, adress = ?, category = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->name, $this->adress,$this->category,$this->id));
    }

    static function getRestaurants(PDO $db, int $count) {
        $stmt = $db->prepare('SELECT id, name,photo FROM restaurants LIMIT ?');
        $stmt->execute(array($count));
      
        return $stmt->fetchAll();
    }

    static function getRestaurantsWithOwner(PDO $db, int $id) {
      $stmt = $db->prepare('SELECT id, name,photo FROM restaurants WHERE owner = (SELECT id FROM restaurantOwner where user = ?)');
      $stmt->execute(array($id));
    
      return $stmt->fetchAll();
    }

    static function getRestaurant(PDO $db, int $id) : Restaurant {
        $stmt = $db->prepare('SELECT id, name, adress, category,photo FROM restaurants WHERE id = ?');
        $stmt->execute(array($id));
        $restaurant = $stmt->fetch();
        $rating = Restaurant::getRestaurantAVGRating($db,(int)$restaurant['id']);
        if ($rating==NULL){
          $rating=0;
        }
    
        return new Restaurant(
          (int) $restaurant['id'], 
          $restaurant['name'],
          $restaurant['adress'],
          $restaurant['category'],
          $restaurant['photo'],
          $rating
        );
    }

  

    static function searchRestaurants(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare("SELECT id, name,adress,category,photo FROM restaurants WHERE name LIKE ?  LIMIT ?");
      $stmt->execute(array($search . '%', $count));
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $rating = Restaurant::getRestaurantAVGRating($db,(int)$restaurant['id']);
        if ($rating==NULL){
          $rating=0;
        }
        $restaurants[] = new Restaurant(
          (int)$restaurant['id'],
          $restaurant['name'],
          $restaurant['adress'],
          $restaurant['category'],
          $restaurant['photo'],
          $rating
        );
      }
      
  
      return $restaurants;
    }

    static function getRestaurantsByItem(PDO $db, string $search) : array {
      $stmt = $db->prepare("SELECT id, name,adress,category,photo FROM restaurants WHERE id in (select restaurant from menu where id in (select menu from menu_item where name LIKE ? and status = 1))");
      $stmt->execute(array($search . '%'));
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $rating = Restaurant::getRestaurantAVGRating($db,(int)$restaurant['id']);
        if ($rating==NULL){
          $rating=0;
        }
        $restaurants[] = new Restaurant(
          (int)$restaurant['id'],
          $restaurant['name'],
          $restaurant['adress'],
          $restaurant['category'],
          $restaurant['photo'],
          $rating
        );
      }
      
  
      return $restaurants;
    }

    static function isOwnerOfRestaurant(PDO $db, int $Rid, int $id) {
      try {
        $stmt = $db->prepare('SELECT id FROM restaurants WHERE id = ? AND owner = (SELECT id FROM restaurantOwner WHERE user = ?)');
        $stmt->execute(array($Rid,$id));
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

    static function existsMenu(PDO $db, int $Rid, string $name) {
      try {
        $stmt = $db->prepare('SELECT id FROM restaurants WHERE id = ? AND id = (SELECT restaurant FROM menu WHERE name = ?)');
        $stmt->execute(array($Rid,$name));
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

    static function addRestaurant(PDO $db,int $id,string $name, string $adress, string $category){
      try {
        $stmt = $db->prepare('INSERT INTO restaurants(name,adress,category,owner) VALUES (:name,:adress,:category,:owner)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':owner', $id);
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


    static function getOwnerID(PDO $db,int $Uid) {
      try {
        $stmt = $db->prepare('SELECT id FROM restaurantOwner WHERE user = ?');
        $stmt->execute(array($Uid));
        if($id = $stmt->fetch()){
          return (int)$id['id'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }


    

    static function addMenu(PDO $db,int $Rid ,string $name){
      try {
        $stmt = $db->prepare('INSERT INTO menu(name,restaurant) VALUES (:name,:restaurant)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':restaurant', $Rid);
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

    static function getFavoriteRestaurants(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT id, name,adress,category,photo FROM restaurants WHERE id in (select restaurant from favouriteRestaurant where customer = ?) ');
      $stmt->execute(array($id));
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $rating = Restaurant::getRestaurantAVGRating($db,(int)$restaurant['id']);
        if ($rating==NULL){
          $rating=0;
        }
        $restaurants[] = new Restaurant(
          (int)$restaurant['id'],
          $restaurant['name'],
          $restaurant['adress'],
          $restaurant['category'],
          $restaurant['photo'],
          $rating
        );
      }
      
  
      return $restaurants;
    }

    static function getRestaurantAVGRating(PDO $db, int $id) : float{
      $stmt = $db->prepare('select round(avg(rating), 2) as Rating from review where restaurant = ?');
      $stmt->execute(array($id));
      if($id = $stmt->fetch()){
          return (float)$id['Rating'];
        }
      
    }

    static function getRestaurantsObjects(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT id, name,adress,category,photo FROM restaurants LIMIT ?');
      $stmt->execute(array($id));
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $rating = Restaurant::getRestaurantAVGRating($db,(int)$restaurant['id']);
        if ($rating==NULL){
          $rating=0;
        }
        $restaurants[] = new Restaurant(
          (int)$restaurant['id'],
          $restaurant['name'],
          $restaurant['adress'],
          $restaurant['category'],
          $restaurant['photo'],
          $rating
        );
      }
      
  
      return $restaurants;
    }


    static function updateRestaurantPhoto(PDO $db,int $id, string $photoPath) {
      try {
        $stmt = $db->prepare('UPDATE restaurants SET photo = ? WHERE id = ?');
        if($stmt->execute(array($photoPath, $id))){
          return true;
        }
        else
            return false;
      }catch(PDOException $e) {
        return false;
      }
    }
    
    
    static function getRestaurantIdFromItem(PDO $db, int $id){
      $stmt = $db->prepare('select id from restaurants where id = (select restaurant from menu where id=(select menu from menu_item where id = ? ))');
      $stmt->execute(array($id));
      if($id = $stmt->fetch()){
          return $id['id'];
        }
      
    }

    static function getRestaurantIdFromName(PDO $db, string $name){
      $stmt = $db->prepare('select id from restaurants where name = ?');
      $stmt->execute(array($name));
      if($id = $stmt->fetch()){
          return $id['id'];
        }
      
    }

    static function deleteRestaurant(PDO $db,int $id) {
      try {
        $stmt = $db->prepare('DELETE FROM restaurants WHERE id = ?');
        $stmt->execute(array($id));
        return true;
      }
      catch(PDOException $e) {
        return false;
      }
    }



  }
?>
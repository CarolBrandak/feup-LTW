<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $adress;
    public string $email;
    public string $phone;
    public bool $owner;
    public string $photo;

    public function __construct(int $id, string $username, string $firstName, string $lastName, string $adress, string $email, string $phone, bool $owner,string $photo)
    {
      $this->id = $id;
      $this->username = $username;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->adress = $adress;
      $this->email = $email;
      $this->phone = $phone;
      $this->owner = $owner;
      $this->photo = $photo;
    }

    function name() {
      return $this->firstName . ' ' . $this->lastName;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE users SET Fname = ?, Lname = ?, adress = ?, phone = ?
        WHERE userId = ?
      ');

      $stmt->execute(array($this->firstName, $this->lastName,$this->adress,$this->phone, $this->id));
    }
    
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
      $isEmail=false;
      for ($i=0;$i<strlen($email);$i++){
        if($email[$i]=='@'){
          $isEmail=true;
        }
      }
      if ($isEmail){
        $stmt = $db->prepare('
        SELECT userId, username,Fname, Lname, adress,email, phone,photo
        FROM users
        WHERE lower(email) = ? AND password = ?
        ');
        $realPass=hash('sha256',$password);
        $stmt->execute(array(strtolower($email), $realPass));
      }
      else{
        $stmt = $db->prepare('
        SELECT userId, username,Fname, Lname, adress,email, phone,photo
        FROM users
        WHERE username = ? AND password = ?
        ');
        $realPass=hash('sha256',$password);
        $stmt->execute(array($email, $realPass));
      }
      
  
      if ($user = $stmt->fetch()) {
        
        $owner=User::isOwner($db,(int)$user['userId']);
        return new User(
          (int)$user['userId'],
          $user['username'],      
          $user['Fname'],
          $user['Lname'],
          $user['adress'],
          $user['email'],
          $user['phone'],
          $owner,
          $user['photo']
        );
      }else return null;
    }

    static function getUser(PDO $db, int $id) : User {
      $stmt = $db->prepare('
      SELECT userId, username,Fname, Lname, adress,email, phone,photo
      FROM users
      WHERE userId = ?
      ');

      $stmt->execute(array($id));
      $user = $stmt->fetch();
      $owner=User::isOwner($db,(int)$user['userId']);
      return new User(
        (int)$user['userId'],
        $user['username'],      
        $user['Fname'],
        $user['Lname'],
        $user['adress'],
        $user['email'],
        $user['phone'],
        $owner,
        $user['photo']
      );
    }

    static function existsUsername(PDO $db, string $username) {
      try {
        $stmt = $db->prepare('SELECT userId FROM users WHERE username = ?');
        $stmt->execute(array($username));
        
        return $stmt->fetch()  !== false;
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function existsEmail(PDO $db, string $email) {
      try {
        $stmt = $db->prepare('SELECT userId FROM users WHERE email = ?');
        $stmt->execute(array($email));
        return $stmt->fetch()  !== false;
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function isOwner(PDO $db, int $id) {
      try {
        $stmt = $db->prepare('SELECT user FROM restaurantOwner WHERE user = ?');
        $stmt->execute(array($id));
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

    static function existsPhone(PDO $db, string $phone, int $id) {
      try {
        $stmt = $db->prepare('SELECT userId FROM users WHERE phone = ?');
        $stmt->execute(array($phone));
        
        if($userId=$stmt->fetch()){
          if ((int)$userId['userId']!=$id){
            return true;
          }
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function getID(PDO $db,string $username) {
      try {
        $stmt = $db->prepare('SELECT userId FROM users WHERE username = ?');
        $stmt->execute(array($username));
        if($id = $stmt->fetch()){
          return $id['userId'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }

    static function getCustomerID(PDO $db,string $username) {
      try {
        $stmt = $db->prepare('SELECT id FROM customer WHERE username = ?');
        $stmt->execute(array($username));
        if($id = $stmt->fetch()){
          return $id['id'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }

    static function createUser(PDO $db, string $username, string $password, string $firstname, string $lastname ,string $email,string $check) {
      
      $password = hash('sha256', $password);
      
      
      try {
        $stmt = $db->prepare('INSERT INTO users(username, password, Fname, Lname,email) VALUES (:username,:password,:firstname,:lastname,:email)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        
        if($stmt->execute()){
          $id = User::getID($db,$username);
          if ($check=='owner'){
            $stmt = $db->prepare('INSERT INTO restaurantOwner(user) VALUES (:user)');
            $stmt->bindParam(':user', $id);
            if($stmt->execute()){
              return $id;
            }
          }
          else{
            $stmt = $db->prepare('INSERT INTO customer(name,username) VALUES (:name,:username)');
            $name= $firstname . ' ' . $lastname;
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':username',$username);
            if($stmt->execute()){
              return $id;
            }
          }

        }
        else
          return -1;
      }catch(PDOException $e) {
        
        return -1;
      }
      
    }

    static function updatePassword(PDO $db, int $id, string $password){
      $password = hash('sha256', $password);
  
      try {
        $stmt = $db->prepare('UPDATE users SET password = ? WHERE userId = ?');
        if($stmt->execute(array($password, $id)))
            return true;
        else{
          return false;
        }   
      }catch(PDOException $e) {
        return false;
      }
    }
    
    static function deleteUser(PDO $db,int $id, string $username) {
      try {
        $name='anonymous';
        $stmt = $db->prepare('DELETE FROM users WHERE userId = ?');
        $stmt->execute(array($id));
        $stmt = $db->prepare('UPDATE customer SET name = ?, username = ? WHERE username = ?');
        $stmt->execute(array($name,$name,$username));
        return true;
      }
      catch(PDOException $e) {
        return false;
      }
    }



    static function addFavoriteRestaurant(PDO $db,int $id,int $Rid){
      try {
        $stmt = $db->prepare('INSERT INTO favouriteRestaurant(customer,restaurant) VALUES (:customer,:restaurant)');
        $stmt->bindParam(':customer', $id);
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

    static function removeFavoriteRestaurant(PDO $db,int $id,int $Rid){
      try {
        $stmt = $db->prepare('delete from favouriteRestaurant where customer = ? and restaurant = ?');
        if ($stmt->execute(array($id,$Rid))){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }



    static function addFavoriteItem(PDO $db,int $id,int $Itemid){
      try {
        $stmt = $db->prepare('INSERT INTO favouriteMenuItem(customer,menu_item) VALUES (:customer,:menu_item)');
        $stmt->bindParam(':customer', $id);
        $stmt->bindParam(':menu_item', $Itemid);
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

    static function removeFavoriteItem(PDO $db,int $id,int $Itemid){
      try {
        $stmt = $db->prepare('delete from favouriteMenuItem where customer = ? and menu_item = ?');
        if ($stmt->execute(array($id,$Itemid))){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function isRestaurantFavorite(PDO $db, int $id) {
      try {
        $customer = (int) User::getCustomerID($db,$_SESSION['username']);
        $stmt = $db->prepare('SELECT id FROM favouriteRestaurant WHERE restaurant = ? and customer = ?');
        $stmt->execute(array($id,$customer));
        
        if($stmt->fetch()){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function isItemFavorite(PDO $db, int $id) {
      try {
        $customer = (int) User::getCustomerID($db,$_SESSION['username']);
        $stmt = $db->prepare('SELECT id FROM favouriteMenuItem WHERE menu_item = ? and customer = ?');
        $stmt->execute(array($id,$customer));
        
        if($stmt->fetch()){
          return true;
        }
        else{
          return false;
        }
      
      }catch(PDOException $e) {
        return true;
      }
    }

    static function updateUserPhoto(PDO $db,int $id, string $photoPath) {
      try {
        $stmt = $db->prepare('UPDATE users SET photo = ? WHERE userId = ?');
        if($stmt->execute(array($photoPath, $id)))
            return true;
        else
            return false;
      }catch(PDOException $e) {
        return false;
      }
    } 

  }


?>
<?php
  declare(strict_types = 1);

  class Review {
    public int $id;
    public string $customer;
    public int $restaurant;
    public int $rating;
    public string $comment;
    public string $reply;


    public function __construct(int $id, string $customer, int $restaurant, int $rating, string $comment, string $reply) {
      $this->id = $id;
      $this->customer = $customer;
      $this->restaurant = $restaurant;
      $this->rating = $rating;
      $this->comment = $comment;
      $this->reply = $reply;
    }

    static function getRestaurantReviews(PDO $db, int $id)  {
        $stmt = $db->prepare('SELECT review.id,name,restaurant,rating,comment,reply from review,customer where review.restaurant = ? and review.customer=customer.id');
        $stmt->execute(array($id));
    
        $reviews = [];
    
        while ($review = $stmt->fetch()) {
          $reviews[] = new Review(
            (int) $review['id'],
            $review['name'],
            (int) $review['restaurant'],
            (int) $review['rating'],
            $review['comment'],
            $review['reply']
          );
        }
    
        return $reviews;
    }

    static function addReview(PDO $db,int $Rid ,int $Cid, int $rating, string $comment){
      $reply="";
      try {
        $stmt = $db->prepare('INSERT INTO review(customer,restaurant,rating,comment,reply) VALUES (:customer,:restaurant,:rating,:comment,:reply)');
        $stmt->bindParam(':customer', $Cid);
        $stmt->bindParam(':restaurant', $Rid);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':reply', $reply);
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

    static function existsReview(PDO $db, int $Rid, int $Cid) {
      try {
        $stmt = $db->prepare('SELECT id FROM review WHERE restaurant = ? AND customer = ?');
        $stmt->execute(array($Rid,$Cid));
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

    static function getReview(PDO $db, int $id) : Review {
      $stmt = $db->prepare('SELECT review.id, name,restaurant, rating, comment,reply from review,customer where review.id= ? and customer.id=review.customer;');
      $stmt->execute(array($id));
      $review = $stmt->fetch();
      return new Review(
        (int) $review['id'],
        $review['name'],
        (int) $review['restaurant'],
        (int) $review['rating'],
        $review['comment'],
        $review['reply']
      );
    }

    static function getOwnerReviews(PDO $db, int $id)  {
      $stmt = $db->prepare('SELECT review.id,name,restaurant,rating,comment,reply from review,customer where review.restaurant in (select id from restaurants where owner =(select id from restaurantOwner where user=?) ) and review.customer=customer.id');
      $stmt->execute(array($id));
    
      $reviews = [];
    
      while ($review = $stmt->fetch()) {
        $reviews[] = new Review(
          (int) $review['id'],
          $review['name'],
          (int) $review['restaurant'],
          (int) $review['rating'],
          $review['comment'],
          $review['reply']
        );
      }
    
      return $reviews;
    }


    function Reply(PDO $db, int $id, string $reply){
  
      try {
        $stmt = $db->prepare('UPDATE review SET reply = ? WHERE id = ?');
        if($stmt->execute(array($reply, $id)))
            return true;
        else{
          return false;
        }   
      }catch(PDOException $e) {
        return false;
      }
    }


    static function getCountReviewCustomerRestaurant(PDO $db, string $username, int $Rid) : int {
        
      $stmt = $db->prepare('select count(id) as count from review where customer = (select id from customer where username = ?) and restaurant = ?');
      $stmt->execute(array($username,$Rid));
      $request = $stmt->fetch();
      return (int) $request['count'];
      
    }



  }
?>
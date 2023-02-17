<?php declare(strict_types = 1); ?>

<?php function drawReviews(array $reviews, Restaurant $restaurant) { ?>
  <h2>Reviews:</h2>
  <h3>Restaurant: <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h3>     
  <?php if ($_SESSION['usertype']=='Customer'){?> <p><a href="../pages/review.php?id=<?=$restaurant->id?>&id2=review" id="reviewThis">Review this restaurant</a> <br> <br></p> <?php }?>
  <?php if ($reviews!=[]){ ?>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Customer</th><th scope="col">Rating</th><th scope="col">Comment</th> <th scope="col">Restaurant Reply</th></tr>
    <?php foreach ($reviews as $i => $review) { ?>
      <tr><td><?=$i+1?></td><td><?=$review->customer?></td><td><?=$review->rating?></td><td><?=$review->comment?></td>
      <?php if($review->reply!=''){?><td><?=$review->reply?></td> <?php }else{ ?><td>none</td> <?php } ?> </tr>
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No reviews yet</h4> <?php }?>
  <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
<?php } ?>

<?php function drawOwnerReviews(array $reviews, Restaurant $restaurant) { ?>
  <h2>Reviews:</h2>
  <h3>Restaurant: <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h3>  
  <?php if ($reviews!=[]){ ?>    
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Customer</th><th scope="col">Rating</th><th scope="col">Comment</th><th scope="col">Restaurant Reply</th></tr>
    <?php foreach ($reviews as $i => $review) { ?>
      <tr><td><?=$i+1?></td><td><?=$review->customer?></td><td><?=$review->rating?></td><td><?=$review->comment?></td>
      <?php if($review->reply!=''){?><td><?=$review->reply?></td> <?php } else{?>
      <td><a href="../pages/review.php?id=<?=$restaurant->id?>&id2=answer&id3=<?=$review->id?>">Click to Reply</a></td></tr> <?php } ?>
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No reviews yet</h4> <?php }?>  
<?php } ?>


<?php function drawProfileReviews(array $reviews) { ?>
  <h2>Reviews on your restaurants:</h2>
  <?php if ($reviews!=[]){ ?>     
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Customer</th><th scope="col">Rating</th><th scope="col">Comment</th><th scope="col">Restaurant Reply</th></tr>
    <?php foreach ($reviews as $i => $review) { ?>
      <tr><td><?=$i+1?></td><td><?=$review->customer?></td><td><?=$review->rating?></td><td><?=$review->comment?></td>
      <?php if($review->reply!=''){?><td><?=$review->reply?></td> <?php } else{?>
      <td><a href="../pages/review.php?id=<?=$review->restaurant?>&id2=answer&id3=<?=$review->id?>">Click to Reply</a></td></tr> <?php } ?>
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No reviews yet</h4> <?php }?> 
<?php } ?>


<?php function drawReviewForm(Restaurant $restaurant) { ?>
  <h2>Review this restaurant: <?=$restaurant->name?></h2>
  <form action="../action/action_add_review.php" method="post" class="review">

  <label class="rating">
  <label>
    <input type="radio" name="stars" value="1" />
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="2" />
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="3" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>   
  </label>
  <label>
    <input type="radio" name="stars" value="4" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="5" checked/>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  </label>  

  <textarea type="text" class="input" placeholder="Write a comment" v-model="newItem" name="comment"></textarea>
  
    <input id="id" type="hidden" name="id" value="<?=$restaurant->id?>" required="required">

    <button type="submit">Post</button>

    <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
  </form>
<?php } ?>


<?php function drawReplyForm(Review $review,Restaurant $restaurant) { ?>
  <h2>Reply to this review: <?=$review->comment?></h2>
  <h3>Made by: <?=$review->customer?> on your restaurant: <?=$restaurant->name?> with rating: <?=$review->rating?>/5</h3>
  <form action="../action/action_reply_review.php" method="post" class="review">

  <textarea type="text" class="input" placeholder="Write a reply" v-model="newItem" name="reply"></textarea>
  
    <input id="id" type="hidden" name="id" value="<?=$review->id?>" required="required">
    <input id="id2" type="hidden" name="id2" value="<?=$restaurant->id?>" required="required">

    <button type="submit">Reply</button>

    <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
  </form>
<?php } ?>



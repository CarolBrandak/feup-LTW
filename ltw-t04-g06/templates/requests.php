<?php declare(strict_types = 1); 

require_once('../database/connection.php');
require_once('../database/restaurant.class.php');
?>
<?php function drawProfileRequests(array $requests) { ?>
  <?php if ($_SESSION['usertype']=='Customer'){ ?> <h2>Your orders:</h2> <?php }else{?><h2>Orders of your restaurants:</h2> <?php } ?>
  <?php if ($requests!=[]){ ?>  
  <h3>click on the order to see details <?php if ($_SESSION['usertype']=='Restaurant Owner') { ?>and edit state <?php }?></h3>    
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Customer</th><th scope="col">Restaurant</th><th scope="col">State</th></tr>
    <?php foreach ($requests as $i => $request) { ?>
      <tr><td><a href="../pages/request.php?id=<?=$request->id?>"> Order #<?=$request->id?> </a> </td><td><?=$request->customer?></td><td> 
      <?php $db = getDatabaseConnection(); $id=Restaurant::getRestaurantIdFromName($db,$request->restaurant); ?>
      <a href="../pages/restaurant.php?id=<?=$id ?>"> <?=$request->restaurant?> </a></td><td><?=$request->state?></td></tr> 
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No orders yet</h4> <?php }?> 
<?php } ?>



<?php function drawOwnerRequest(Request $request, array $items) { ?>
  <h2>Order #<?=$request->id?>:</h2>
  <?php $total=0;?>  
  <table id="tables">
  <?php $db = getDatabaseConnection(); $id=Restaurant::getRestaurantIdFromName($db,$request->restaurant); ?>
    <tr><th scope="col">Restaurant</th><th scope="col">State</th></tr>
    <tr><td><a href="../pages/restaurant.php?id=<?=$id ?>"> <?=$request->restaurant?> </a></td><td><?=$request->state?></td></tr>
  </table>
  <?php if ($request->state!="Delivered"){ ?>
  <a href="../pages/request.php?id=<?=$request->id?>&id2=state">Click to change order state</a> <?php }?>
  <h3>Items:</h3>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Quantity</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($items as $i => $item) { $total+=(float)$item->price*(float)$item->quantity?>

      <tr><td><?=$i+1?></td><td><?=$item->name?></td><td><?=$item->price?>€</td><td><?=$item->quantity?></td><td><?=$item->category?></td><td><img src="../itemPictures/<?=$item->photo?>"></td></tr>
    <?php } ?>
  </table>
  <h2>Total: <?=$total?>€</h2>
<?php } ?>



<?php function drawCustomerRequest(Request $request, array $items) { ?>
  <h2>Order #<?=$request->id?>:</h2>
  <?php $total=0;?>  
  <table id="tables">
  <?php $db = getDatabaseConnection(); $id=Restaurant::getRestaurantIdFromName($db,$request->restaurant); ?>
    <tr><th scope="col">Restaurant</th><th scope="col">State</th></tr>
    <tr><td><a href="../pages/restaurant.php?id=<?=$id ?>"> <?=$request->restaurant?> </a></td><td><?=$request->state?></td></tr>
  </table>
  <h3>Items:</h3>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Quantity</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($items as $i => $item) { $total+=(float)$item->price*(float)$item->quantity?>

      <tr><td><?=$i+1?></td><td><?=$item->name?></td><td><?=$item->price?>€</td><td><?=$item->quantity?></td><td><?=$item->category?></td><td><img src="../itemPictures/<?=$item->photo?>"></td></tr>
    <?php } ?>
  </table>
  <h2>Total: <?=$total?>€</h2>
<?php } ?>


<?php function drawOwnerOrderForm(Request $request) { ?>
  <h2>Order #<?=$request->id?>  Current State: <?=$request->state?></h2>
  <h3>Please choose the state</h3>
  <form action="../action/action_update_state.php" method="post" class="request">
  <div class="container">
  <input type="range" min="1" max="100" value="50" class="slider" id="myRange" name="state">
 

  <p id="State"></p>
</div>
    
    <input id="id" type="hidden" name="id" value="<?=$request->id?>" required="required">

    <button type="submit">Update</button>

    <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
  </form>
<?php } ?>



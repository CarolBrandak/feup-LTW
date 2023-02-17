<?php declare(strict_types = 1);
require_once('../database/connection.php'); 
require_once('../database/menu_item.class.php'); 

?>


<?php function drawCart(array $itemsByMenu,int $Rid){ ?>
    <header>
    <link rel="stylesheet" href="../css/cart.css">
    <script src="../javascript/cart.js" defer></script>
    </header>
    <section id="products">
    <input id="id" type="hidden" name="id" value="<?=$Rid?>" required="required">
    <?php if ($itemsByMenu!=[]){ ?>
    <?php foreach ($itemsByMenu as $i => $item) { ?>
      <?php if ($item->active) {?>
    <article data-id="<?=$item->id?>">
      <h2><?=$item->name?></h2>
      <img src="../itemPictures/<?=$item->photo?>">
      <p class="price"><?=$item->price?></p>
      <input class="quantity" type="number" value="1" min="1">
      <button class="buy">Buy</button>
    </article>
    <?php }?>
    <?php } ?>
  <?php } else{?>
  <h4>This restaurant doesn't have any items</h4> <?php }?>
  </section>
  <h2>Shopping Cart</h2>
  <section id="cart">
    <table>
      <thead>
        <tr><th>Id</th><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th><th>Delete</th></tr>
      </thead>
      <tbody id="tbody">
      <?php (float) $total = 0; foreach ($_SESSION['cart'] as $i => $item) { (float)$total+=(float) $item['price']* (float)$item['quantity'];?>
          <tr id="<?=$i?>"><th><?=$i?></th><th><?php $db = getDatabaseConnection(); ?><?=Menu_Item::getItemName($db,$i)?></th><th id="quantity"><?=$item['quantity']?></th><th id= "price"><?=$item['price']?></th>
          <th><?=$item['price']*$item['quantity']?></th> <th><input type = "button" id="deleteCartRow" onclick = "DeleteRow(<?=$i?>)" value = "X"></th></tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr><th colspan="5">Total:</th><th><?=$total?></th></tr>
      </tfoot>
    </table>
  </section>
  <form action="../action/action_make_order.php" method="post" class="requestForm">
        <button id="SubmitOrder" type="submit">Place Order</button>

        <p id="error_messages" style="color: black">
          <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
        </p>
        </form>

<?php }?>


<?php function drawEmptyCart(){ ?>
    <header>
    <link rel="stylesheet" href="../css/cart.css">
    <script src="../javascript/cart.js" defer></script>
    </header>
    <body>
      <h1>
        Looks like your cart is empty :(
      </h1>
      <p>
        <a href="../pages/restaurant.php?id=search" class="resInfo">Click here to search for restaurants </a>
      </p>
    </body>

<?php }?>



<?php function drawEmptyRestaurant(){ ?>
    <header>
    <link rel="stylesheet" href="../css/cart.css">
    <script src="../javascript/cart.js" defer></script>
    </header>
    <body>
      <h1>
        Looks like this restaurant doesn't have any items yet :( <br>
        In the meantime enjoy this photo of a cute penguin
      </h1>
      <img src="../pictures/banhas.jpg" alt="Cute Penguin">
      <p>
        <a href="../pages/restaurant.php?id=search" class="resInfo">Click here to search for restaurants </a>
      </p>
    </body>

<?php }?>
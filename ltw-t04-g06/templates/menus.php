<?php declare(strict_types = 1);

require_once('../database/restaurant.class.php');
require_once('../database/menu.class.php');
require_once('../database/user.class.php');
require_once('../database/connection.php');

?>

<?php function drawMenu(Menu $menu, Restaurant $restaurant, array $menu_items, bool $anyActive) { ?>
  <h2>Menu: <?=$menu->name?></h2>
  <h3>Restaurant: <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h3>
  <?php if ($menu_items!=[] && $anyActive){ ?>      
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($menu_items as $i => $item) { ?>
      <?php if ($item->active){?>
      <tr><td><?=$i+1?></td><td><?=$item->name?></td><td><?=$item->price?>€</td><td><?=$item->category?></td><td><img src="../itemPictures/<?=$item->photo?>"></td>
    <?php if ($_SESSION['usertype']=='Customer'){?><td>
      <?php $db = getDatabaseConnection();$favorite=User::isItemFavorite($db,$item->id); if (!$favorite){ ?>
  <form action="../action/action_add_favorite.php" method="post" class="favorite">
  <label class="rating">
    
  <label>
    <input type="checkbox" name="stars" value="1" onchange='this.form.submit();' />
    <span class="icon">★</span>
  </label>
</label>
<input id="id" type="hidden" name="id" value="<?=$item->id?>" required="required">
<input id="id" type="hidden" name="type" value="item" required="required">
<input id="id2" type="hidden" name="id2" value="<?=$menu->id?>" required="required">
Add to your favorites
  </form>
<?php } else {?>
  <form action="../action/action_remove_favorite.php" method="post" class="favorite">
  <label class="rating">
    
  <label>
    <input type="checkbox" name="stars" value="1" checked  onclick='this.form.submit();' />
    <span class="icon">★</span>
  </label>
</label>
<input id="id" type="hidden" name="id" value="<?=$item->id?>" required="required">
<input id="id" type="hidden" name="type" value="item" required="required">
<input id="id2" type="hidden" name="id2" value="<?=$menu->id?>" required="required">
Remove from your favorites
</form>
  <?php }?>
    </td> <?php }?></tr>
    <?php }?>
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No items yet</h4> <?php }?>
<?php } ?>

<?php function drawMenuOwner(Menu $menu, Restaurant $restaurant, array $menu_items, bool $anyActive) { ?>
  <h2>Menu: <?=$menu->name?></h2>
  <h3>Restaurant: <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h3>      
  <a href="../pages/menu.php?id=<?=$menu->id?>&id2=edit2">Add a menu item</a> <br> <br>
  <?php if ($menu_items!=[] && $anyActive){ ?>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($menu_items as $i => $item) { ?>
      <?php if ($item->active){?>
      <tr><td><?=$i+1?></td><td><?=$item->name?></td><td><?=$item->price?>€</td><td><?=$item->category?></td><td><img src="../itemPictures/<?=$item->photo?>"></td>
      <td><a href="../pages/menu.php?id=<?=$menu->id?>&id2=photo&id3=<?=$item->id?>">Change photo</a></td>
      <td>
      <form action="../action/action_delete_menu_item.php" method="post">
                <input type="hidden" name="menu" value="<?=$menu->id?>">
                <input type="hidden" name="item" value="<?=$item->id?>">
                <input type="hidden" name="restaurant" value="<?=$restaurant->id?>">
                <input type="submit" name="Submit" value="Delete">
            </form>
      </td>
      </tr>
      <?php }?>
    <?php } ?>
  </table>
  <?php } else{?>
  <h4>No items yet</h4> <?php }?>
  <p>
  <input onclick="openDialog('Delete Menu')" type="submit" value="Delete Menu">
  <div hidden id="dialog2" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this menu?</p>
        <div class="buttons">
            <input onclick="closeDialog('Delete Menu')" type="button" value="Cancel">
            <form action="../action/action_delete_menu.php" method="post">
                <input type="hidden" name="menu" value="<?=$menu->id?>">
                <input type="hidden" name="restaurant" value="<?=$restaurant->id?>">
                <input type="submit" name="Submit" value="Delete">
            </form>
        </div>
    </div>
  </div>
  
</p>
<?php } ?>


<?php function drawNewMenuItemForm(Menu $menu) { ?>
  <h2>Add a new menu item</h2>
  <form action="../action/action_add_menu_item.php" method="post" class="restaurant">

    <label for="name">Item name: </label>
    <input id="name" type="text" name="name" required="required"> 

    <label for="price">Item price: </label>
    <input id="price" type="text" name="price" required="required"> 

    <label for="category">Item category: </label>
    <input id="category" type="text" name="category" required="required">
  
    <input id="id" type="hidden" name="id" value="<?=$menu->id?>" required="required">

    <button type="submit">Add</button>

    <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
  </form>
<?php } ?>

<?php function drawItemPictureForm(Menu_Item $menu_item) { ?>
  <div id="photo_field">
    <form action="../action/api.upload_photo.php" method="post" enctype="multipart/form-data">
      <label>Photo</label>
      <img id="photo" src="<?php echo  htmlentities('../itemPictures/'.$_SESSION['iteminfo']['Photo']) ?>" alt="Item picture">
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input id="id" type="hidden" name="id" value="<?=$menu_item->id?>" required="required">
      <input id="type" type="hidden" name="type" value="item" required="required">
      <input type="submit" name="Submit" value="Upload">
    </form>
  </div>
<?php }?>  
<?php declare(strict_types = 1); ?>

<?php function drawRestaurants(array $restaurants) { ?>
  <header>  
  <h2 id="mainRestaurants">Top Restaurants</h2>
  </header>
  <section id="restaurantsMain">
    <?php foreach($restaurants as $restaurant) { ?> 
      <div id="card">
          <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><img src="../restaurantPictures/<?=$restaurant->photo?>" > </a>
          <div id="resText"><?=$restaurant->name?></div>
      </div>

    <?php } ?>
  </section>
  <h3><a href="../pages/restaurant.php?id=search" id="resSearch">Search for a restaurant</a></h3>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant, array $menus, bool $favorite) { ?>
  <h1><?=$restaurant->name?></h1> 
  <h3>Category: <?=$restaurant->category?></h3>
  <section id="menu">
  <h2>Menus:</h2>
    <?php foreach ($menus as $menu) { ?>
    <article>
    <h3><ul><li><a href="../pages/menu.php?id=<?=$menu['id']?>"><?=$menu['name']?></a></li></ul></h3>
    </article>
    <?php } ?>
  </section>
  <p>
    Restaurant's Adress: <?=$restaurant->adress?>
  </p>
  <p>
  <a href="../pages/cart.php?id=<?=$restaurant->id?>" class="resInfo">Order from here</a>
  </p>
  <p>
    <a href="../pages/review.php?id=<?=$restaurant->id?>" class="resInfo">Reviews</a>
  </p>
  <?php if (!$favorite){ ?>
  <form action="../action/action_add_favorite.php" method="post" class="favorite">
  <label class="rating">
    
  <label>
    <input type="checkbox" name="stars" value="1" onchange='this.form.submit();' />
    <span class="icon">★</span>
  </label>
</label>
<input id="id" type="hidden" name="id" value="<?=$restaurant->id?>" required="required">
<input id="id" type="hidden" name="type" value="restaurant" required="required">
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
<input id="id" type="hidden" name="id" value="<?=$restaurant->id?>" required="required">
<input id="id" type="hidden" name="type" value="restaurant" required="required">
Remove from your favorites
</form>

  <?php }?>
<?php } ?>

<?php function drawRestaurantOwner(Restaurant $restaurant, array $menus) { ?>
  <h1><?=$restaurant->name?></h1>
  <a href="../pages/restaurant.php?id=<?=$restaurant->id?>&id2=edit" class="resOwner">Edit restaurant's information</a> |
  <a href="../pages/restaurant.php?id=<?=$restaurant->id?>&id2=edit2" class="resOwner">Add a menu</a> |
  <a href="../pages/restaurant.php?id=<?=$restaurant->id?>&id2=photo" class="resOwner">Change restaurant's photo</a>
  <h3>Category: <?=$restaurant->category?></h3>
  <section id="menu">
    <?php foreach ($menus as $menu) { ?>
    <article>
      <h3><ul><li><a href="../pages/menu.php?id=<?=$menu['id']?>"><?=$menu['name']?></a></li></ul></h3>
    </article>
    <?php } ?>
    
  </section>
  <p>
    Restaurant's Adress: <?=$restaurant->adress?>
  </p>
  <p>
    <a href="../pages/review.php?id=<?=$restaurant->id?>">Reviews</a>
  </p>

  <p>
  <input onclick="openDialog('Delete Restaurant')" type="submit" value="Delete Restaurant">
  <div hidden id="dialog3" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this restaurant?</p>
        <div class="buttons">
            <input onclick="closeDialog('Delete Restaurant')" type="button" value="Cancel">
            <form action="../action/action_delete_restaurant.php" method="post">
                <input type="hidden" name="restaurant" value="<?=$restaurant->id?>">
                <input type="submit" name="Submit" value="Delete">
            </form>
        </div>
    </div>
  </div>
  
</p>
<?php } ?>

<?php function drawProfileRestaurants(array $restaurants) { ?>
  <header>
    <h2>My Restaurants</h2>
    <input id="searchrestaurant" type="text" placeholder="search">
  </header>
  <section id="restaurants">
  <a href="../pages/restaurant.php?id=add">Add a restaurant</a>
    <?php foreach($restaurants as $restaurant) { ?> 
      <article>
        <img src="../restaurantPictures/<?=$restaurant['photo']?>"> <br>
        <a href="../pages/restaurant.php?id=<?=$restaurant['id']?>"><?=$restaurant['name']?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>


<?php function drawRestaurantSearch() { ?>
  <header>
  <h1>What would you like to search by?</h1>
  </header>
  <section id="searchOptions">
    <h2>
    <ul>
      <li>
        <a href="../pages/restaurant.php?id=search&id2=name">Search for a restaurant by its name</a>
      </li>
      <li>
        <a href="../pages/restaurant.php?id=search&id2=itemR">Search for a restaurant that contains a certain menu item</a>
      </li>
      <li>
        <a href="../pages/restaurant.php?id=search&id2=rating">Search for a restaurant by average rating</a>
      </li>
      <li>
        <a href="../pages/restaurant.php?id=search&id2=item">Search for a menu item by its name</a>
      </li>
    </ul>
    </h2>
  </section>
<?php } ?>

<?php function drawRestaurantSearchResults(string $parameter,array $restaurants) { ?>
    <?php if ($parameter=='name'){?>
    <header>  
    <h1>Type your desired restaurant name and it will appear
    <input id="searchrestaurant1" type="text" placeholder="search">
    </h1>
    </header>
    <section id="restaurants">
    
  </section>
    <?php } else if($parameter=='item'){?>
    <header>  
    <h1>Type your desired item name and it will appear
    <input id="searchitem" type="text" placeholder="search">
    </h1>    
    </header>
    <section id="itemssearch">
  
    </section>
    <?php } else if($parameter=='rating'&&$restaurants!=[]){?>
    <header>  
    <h1>Restaurants sorted by average rating

    </h1>
    </header>
    <section id="restaurants">
      <ul>
    <?php foreach($restaurants as $restaurant) { ?> 
      <li>
        <img src="../restaurantPictures/<?=$restaurant->photo?>"> <br>
        <h2><a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?>  <br>
        Rating: <?php if($restaurant->rating>0){?><?=$restaurant->rating?> <?php }else{?> No ratings yet <?php } ?></a> </h2>
    </li>
    <?php } ?>
      </ul>
  </section>

    <?php } else if($parameter=='itemR'){?>
    <header>  
    <h1>Type an item name and all restaurants containing it will appear
    <input id="searchrestaurant2" type="text" placeholder="search">
    </h1>
    </header>
    <section id="restaurants">

    </section>
    <?php }else{?>
    <?php }?>
<?php } ?>


<?php function drawRestaurantInfoForm(Restaurant $restaurant) { ?>
<h2>Restaurant details</h2>
<form action="../action/action_edit_restaurant.php" method="post" class="restaurant">

  <label for="name">Name:</label>
  <input id="name" type="text" name="name" value="<?=$restaurant->name?>" required="required">
  
  <label for="adress">Address:</label>
  <input id="adress" type="text" name="adress" value="<?=$restaurant->adress?>" required="required">
  
  <label for="category">Category:</label>
  <input id="category" type="text" name="category" value="<?=$restaurant->category?>" required="required">
  
  <input id="id" type="hidden" name="id" value="<?=$restaurant->id?>" required="required">

  <button type="submit">Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>
<?php } ?>



<?php function drawNewMenuForm(Restaurant $restaurant) { ?>
  <h2>Create new menu</h2>
  <form action="../action/action_add_menu.php" method="post" class="restaurant">

    <label for="name">Menu name:</label>
    <input id="name" type="text" name="name" required="required">
  
    <input id="id" type="hidden" name="id" value="<?=$restaurant->id?>" required="required">

    <button type="submit">Add menu</button>

    <p id="error_messages" style="color: black">
      <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
    </p>
  </form>
<?php } ?>


<?php function drawNewRestaurantForm() { ?>
<h2>Restaurant details</h2>
<form action="../action/action_add_restaurant.php" method="post" class="restaurant">

  <label for="name">Name:</label>
  <input id="name" type="text" name="name"  required="required">
  
  <label for="adress">Address:</label>
  <input id="adress" type="text" name="adress"  required="required">
  
  <label for="category">Category:</label>
  <input id="category" type="text" name="category"  required="required">
  

  <button type="submit">Add restaurant</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>
<?php } ?>


<?php function drawRestaurantPictureForm(Restaurant $restaurant) { ?>
  <div id="photo_field">
    <form action="../action/api.upload_photo.php" method="post" enctype="multipart/form-data">
      <label>Photo</label>
      <img id="photo" src="<?php echo  htmlentities('../restaurantPictures/'.$_SESSION['rinfo']['Photo']) ?>" alt="Item picture">
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input id="id" type="hidden" name="id" value=<?=$restaurant->id?> required="required">
      <input id="type" type="hidden" name="type" value="restaurant" required="required">
      <input type="submit" name="Submit" value="Upload">
    </form>
  </div>
<?php }?>
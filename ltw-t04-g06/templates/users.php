<?php declare(strict_types = 1); ?>



<?php function drawProfileInfoForm(User $user) { ?>
<h2>Profile</h2>
<form action="../action/action_edit_profile.php" method="post" class="profile">

  <label for="first_name">First Name:</label>
  <input id="first_name" type="text" name="first_name" value="<?=$user->firstName?>"  class = "profilein" required="required">
  
  <label for="last_name">Last Name:</label>
  <input id="last_name" type="text" name="last_name" value="<?=$user->lastName?>" class = "profilein" required="required">
  
  <label for="adress">Address:</label>
  <input id="adress" type="text" name="adress" value="<?=$user->adress?>" class = "profilein" required="required">

  <label for="phone">Phone Number:</label>
  <input id="phone" type="text" name="phone" value="<?=$user->phone?>" class = "profilein" required="required">
  
  <button type="submit" class="delaccount" >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>
<?php } ?>

<?php function drawAccountInfoForm() { ?>
<h2>Profile</h2>
<form action="../action/action_update_password.php" method="post" class="account">

  <label for="password">New password:</label>
  <input id="password" type="password" name="password">
  
  <label for="repeat">Repeat new password:</label>
  <input id="repeat" type="password" name="repeat">  
  
  <button type="submit" class="delaccount" >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>
<?php } ?>


<?php function drawProfileCustomer(User $user) { ?>
<h2>Profile  <?php echo $_SESSION['usertype'];?> </h2>
<article id='profile_list'>
  <ul>
    <li>Username: <?=$user->username ?></li>
    <li>First name: <?= $user->firstName ?></li>
    <li>Last name: <?= $user->lastName ?></li>
    <li>Address: <?= $user->adress ?></li>
    <li>Phone number: <?= $user->phone ?></li>
  </ul>
  <div id='profile_image'>
    <img src="../userPictures/<?=$user->photo?>" alt="ProfilePic">
  </div>
</article>
<p>
<a href="../pages/profile.php?id=photo" class="userinf"> Change Profile Picture</a> | <a href="../pages/profile.php?id=profile" class="userinf"> Edit Profile Info</a> | <a href="../pages/profile.php?id=account" class="userinf">Edit Account Info</a> 
  | <a href="../pages/profile.php?id=favorites" class="userinf">Favorites</a> | <a href="../pages/profile.php?id=Corders" class="userinf">My orders</a>
</p>
<p>
  <input onclick="openDialog('Delete Account')" type="submit" value="Delete Account">
  <div hidden id="dialog1" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete your account forever? It is a very long time.</p>
        <div class="buttons">
            <input onclick="closeDialog('Delete Account')" type="button" value="Cancel">
            <form action="../action/action_delete_account.php" method="post">
                <input type="submit" name="Submit" value="Delete">
            </form>
        </div>
    </div>
  </div>

</p>
<?php } ?>


<?php function drawProfileOwner(User $user) { ?>
<h2>Profile  <?php echo $_SESSION['usertype'];?> </h2>
<article id='profile_list'>
  <ul>
    <li>Username: <?=$user->username ?></li>
    <li>First name: <?= $user->firstName ?></li>
    <li>Last name: <?= $user->lastName ?></li>
    <li>Address: <?= $user->adress ?></li>
    <li>Phone number: <?= $user->phone ?></li>
  </ul>
  <div id='profile_image'>
    <img src="../userPictures/<?=$user->photo?>" alt="ProfilePic">
  </div>
</article>
<p>
<a href="../pages/profile.php?id=photo" class="userinf" > Change Profile Picture</a> | <a href="../pages/profile.php?id=profile" class="userinf"> Edit Profile Info</a> | <a href="../pages/profile.php?id=account" class="userinf">Edit Account Info</a> | <a href="../pages/profile.php?id=owner" class="userinf">My restaurants</a> |
  <a href="../pages/profile.php?id=reviews" class="userinf" >Reviews</a> | <a href="../pages/profile.php?id=Rorders" class="userinf" >Orders</a>
</p>
<p>
  <input onclick="openDialog('Delete Account')" type="submit" value="Delete Account" class="delaccount">
  <div hidden id="dialog1" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete your account forever? It is a very long time.</p>
        <div class="buttons">
            <input onclick="closeDialog('Delete Account')" type="button" value="Cancel" class="delaccount">
            <form action="../action/action_delete_account.php" method="post">
                <input type="submit" name="Submit" value="Delete" class="delaccount">
            </form>
        </div>
    </div>
  </div>
  
</p>
<?php } ?>



<?php function drawOwnerNoRestaurants() { ?>
  <h2>Looks like you dont have any restaurants yet</h2>
  <p>
    <a href="../pages/restaurant.php?id=add">Click here to add your restaurant</a>
  </p>
<?php } ?>



<?php function drawProfileFavorites(array $items,array $restaurants) { ?>
  <label class="rating">
  <h2>My favorites <span class="icon" id="goldenStar">★</span></h2> 
  </label>
  <h3>Favorite Restaurants:</h3>
  <?php if ($restaurants!=[]){ ?>
    <p>Click on the restaurant name to go to the restaurant</p>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Name</th><th scope="col">Adress</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($restaurants as $i => $restaurant) { $total+=(int)$item->price?>

      <tr><td><?=$i+1?></td><td><a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></td><td><?=$restaurant->adress?></td><td><?=$restaurant->category?></td><td><img src="../restaurantPictures/<?=$restaurant->photo?>"></td></tr>
    <?php } ?>  
  </table>
  <?php }else { ?>
    <p>Looks like you don't have any restaurants marked as favorites</p>
  <?php } ?>
  
  <h3>Favorite Items:</h3>
  <?php if ($items!=[]){ ?>
    <p>Click on the item name to go to the corresponding menu</p>
  <table id="tables">
    <tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Category</th><th scope="col">Photo</th></tr>
    <?php foreach ($items as $i => $item) { $total+=(int)$item->price?>

      <tr><td><?=$i+1?></td><td><a href="../pages/menu.php?id=<?=$item->menu?>"><?=$item->name?></a></td><td><?=$item->price?>€</td><td><?=$item->category?></td><td><img src="../itemPictures/<?=$item->photo?>"></td></tr>
    <?php } ?>  
  </table>
  <?php }else { ?>
    <p>Looks like you don't have any items marked as favorites</p>
  <?php } ?>  
<?php } ?>  



<?php function drawUserPictureForm() { ?>
  <div id="photo_field">
    <form action="../action/api.upload_photo.php" method="post" enctype="multipart/form-data">
      <label>Photo</label>
      <img id="photo" src="<?php echo  htmlentities('../userPictures/'.$_SESSION['userinfo']['Photo']) ?>" alt="Item picture">
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input id="id" type="hidden" name="id" value=<?=$_SESSION['id']?> required="required">
      <input id="type" type="hidden" name="type" value="user" required="required">
      <input type="submit" name="Submit" value="Upload" class="delaccount">
    </form>
  </div>
<?php }?>
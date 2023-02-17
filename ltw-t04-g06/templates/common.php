<?php declare(strict_types = 1); ?>

<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Taste Service</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="../pictures/logo.png">
    <script src="../javascript/search.js" defer></script>
    <script src="../javascript/dialogs.js" defer></script>
    <script src="../javascript/radio.js" defer></script>
    <script src="../javascript/stateSlider.js" defer></script>
    <script src="../javascript/header.js" defer></script>
  </head>
  <body>
  <header>
  <div id="wrapper2">
      <h1><a href="../pages/main.php" id="maintit">Taste Service</a></h1>

                <nav class="nav1">
                    <ul class="hmenu">
                        <li class="item"><a href="../pages/main.php" class="hlink">Home</a></li>
                        <li class="item"><a href="../pages/restaurant.php?id=search&id2=rating" class="hlink">Best Restaurants</a></li>
                        <li class="item"><a href="../pages/restaurant.php?id=search" class="hlink">Search</a></li>
                        <li class="item"><a <?php if ($_SESSION['usertype']=='Customer'){?>href="../pages/profile.php?id=Corders" <?php } else{ ?>
                        href="../pages/profile.php?id=Rorders"<?php } ?> class="hlink">Orders</a></li>
                    </ul>
                    <div id="hamb">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </nav>

</div>
      <?php if ($_SESSION['usertype']=='Customer'){ ?>
      <div id="cartIcon">
      <a href="../pages/cart.php?id=<?=$_SESSION['cartRestaurant']?>">
      <i class="fa" style="font-size:1.5em">&#xf07a;</i>
      </a>
       <span class='badge badge-warning'  id='lblCartCount' <?php  if (!$_SESSION['cart']){?> style="background-color:transparent" <?php } ?> >
       <?php if ($_SESSION['cart']){?> <?= count($_SESSION['cart'])?> <?php }  ?> 
      </span> 
      </div>
      <?php } ?>  
      <?php if (isset($_SESSION['id'])) drawLogoutForm($_SESSION['name']);?>
    </header>
    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer id="footer">
      <p id="cp">Copyright &copy; Restaurant helper</p>
    </footer>
  </body>
</html>
<?php } ?>


<?php function drawLogoutForm(string $name) { ?>
  <form action="../action/action_logout.php" method="post" class="logout">
  <a id="profile_name_header" href="../pages/profile.php"><?=$name?></a>
    <button id="logout-but" type="submit" >Logout</button>
  </form>
<?php } ?>
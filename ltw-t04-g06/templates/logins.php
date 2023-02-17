<?php function drawLogin() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Taste Service</title>
            <meta charset="utf-8">

            <link rel="stylesheet" href="../css/style_login.css">
            <link rel="shortcut icon" href="../pictures/logo.png">
            <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="../javascript/login.js" defer></script>
            <script src="../javascript/checkbox.js" defer></script>
        </head>

        <body>
            <header><h1 class="tit">Taste Service</h1></header>
            <div class="login1">
                <div class="formul">
                    <div class="button_rectangle">
                        <div id="log"></div>
                        <button type="button" class="button_log" onclick="login()">Login</button>
                        <button type="button" class="button_log" onclick="register()">Register</button>
                    </div>
                    <form id="login2" class="inputs" action="../action/action_login.php" method="post">
                        <input type="text" name="email/username" class="words" placeholder="email/username" required="required">
                        <input type="password" name="password" class="words" placeholder="password" required="required">
                        <button type="submit" class="sub">Login</button>
                    </form>
                    <form id="register1" class="inputs" action="../action/action_register.php" method="post">
                        <input type="email" name="email" class="words" placeholder="email" required="required">
                        <input type="password" name="password" class="words" placeholder="password" required="required">
                        <input type="password" name="repeat" class="words" placeholder="repeat password" required="required">
                        <input type="username" name="username" class="words" placeholder="username" required="required">
                        <input type="first_name" name="first_name" class="words" placeholder="first name" required="required">
                        <input type="last_name" name="last_name" class="words" placeholder="last name" required="required">
                        <input type="checkbox" id="owner" name="check" class="check" value="owner" onclick="onlyOne(this)">
                        <label for="owner" id="Iam"> I am a restaurant owner</label> <br>
                        <input type="checkbox" id="customer" name="check" class="check" value="customer" onclick="onlyOne(this)">
                        <label for="customer" id="Iam"> I am a customer</label>
                        <button type="submit" class="sub">Register</button> 
                    </form>
                    <p id="error_messages" style="color: white">
                        <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
                    </p>
                </div>
            </div>
        </body>
    </htlm>     
<?php } ?>



 
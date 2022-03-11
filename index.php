<?php
    // Is this page nested in a folder, relevant for routing
    $pageDepth = 0;

    // Include the page header
    require('includes/header.php');

    // If user is trying to login
    if(isset($_POST['submit_login'])){
        // Check if credentials are correct with a function, returns bool
        $user = credCheck($_POST['username'], $_POST['password']);
        // If credentials are correct
        if($user){
            // Enter the user details into a SESSION
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // If user has role admin
            if($user['role_id'] == '2'){ 
                $_SESSION['admin'] = true;
            }         
        }
    // If user is trying to register an account
    } else if(isset($_POST['submit_reg'])){
        // Create the new user with a function, returns the id of the new user
        $newUserId = createUser($_POST['username'], $_POST['password']);
        // Get all the details of the new user using the id obtained previously
        $user = getUser($newUserId);
        // If the user exists
        if($user){
            // Enter the user details into a SESSION
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // A newly registered user cannot be admin
            $_SESSION['admin'] = false;
        }
    }
?>
    
<?php
    // Page shows different content depending on if user is logged in
    if($_SESSION['logged_in'] == true){
        ?>
            <div class="content homepage_logged_in_container w3-padding-large">
                <h1>Welkom <?php echo $_SESSION['username']; ?></h1>
                <p>Klik op een knop bovenaan in het menu om te beginnen!</p>
            </div>
        <?php
    } else {
        ?>

        <div class="content homepage_no_login_container w3-display-middle">
            <div class="login">
                <form action="index.php" method="post">
                    <fieldset>
                        <legend>Inloggen</legend>
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" name="username">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password">
                        <input type="submit" value="Inloggen" name="submit_login" class="w3-padding w3-button w3-blue-gray w3-text-white">
                    </fieldset>
                </form>
            </div>
            <div class="registration">
                <form action="index.php" method="post">
                    <fieldset>
                        <legend>Registreren</legend>
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" name="username">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password">
                        <input type="submit" value="Registreren" name="submit_reg" class="w3-padding w3-button w3-blue-gray w3-text-white">
                    </fieldset>
                </form>
            </div>
        </div>

        <?php
    }
?>

<?php
    // Include the page footer
    include('includes/footer.php')
?>
<?php
    $pageDepth = 0;

    require('includes/header.php');

    if(isset($_POST['submit_login'])){
        $user = credCheck($_POST['username'], $_POST['password']);
        if($user){
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            if($user['role_id'] == '2'){
                $_SESSION['admin'] = true;
            }         
        }
    } else if(isset($_POST['submit_reg'])){
        $newUserId = createUser($_POST['username'], $_POST['password']);
        $user = getUser($newUserId);
        if($user){
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = false;
        }
    }
?>
    
<?php
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
    include('includes/footer.php')
?>
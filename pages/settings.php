<?php
    $pageDepth = 1;

    require('../includes/header.php');
    
    if(isset($_POST['accountUpdated'])){
        $new_username = $_POST['username'];
        $new_password = $_POST['password'];
        $new_role = $_POST['role'];

        editUser($new_username, $new_password, $new_role, $_SESSION['user_id']);
    }

    $user = getUser($_SESSION['user_id']);
?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>
            <form action="" class="editAccount" method='POST'>
                <label for="username">Gebruikersnaam</label>
                <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>">

                <label for="password">Wachtwoord</label>
                <input type="password" name="password" id="password" value="<?php echo $user['password']; ?>">

                <label for="role">Selecteer rol</label>
                <select name="role" id="role">
                    <?php echo rolesToOptions(getRoles(), $user['role_id']); ?>
                </select>

                <input type="submit" name="accountUpdated" value="Account bijwerken" class="w3-button w3-blue w3-margin-top">
            </form>
        <?php
    } else {
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    include('../includes/footer.php')
?>
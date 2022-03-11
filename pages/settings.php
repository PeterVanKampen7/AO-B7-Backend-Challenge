<?php
    // Indicate page depth
    $pageDepth = 1;

    // Header
    require('../includes/header.php');

    // If user submitted the form update his data
    if(isset($_POST['accountUpdated'])){
        $new_username = $_POST['username'];
        $new_password = $_POST['password'];
        $new_role = $_POST['role'];

        editUser($new_username, $new_password, $new_role, $_SESSION['user_id']);
    } else if(isset($_POST['deleteUser'])){
        // If user wants to delete acount redirect to page
        header("Location: confirmDelete.php");
    }

    // Reset the user data is case data was updated
    $user = getUser($_SESSION['user_id']);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    if($user['role_id'] == '2'){
        $_SESSION['admin'] = true;
    } else {
        $_SESSION['admin'] = false;
    }
?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>
            <div class="editAccountContainer">
                <h2>Account bijwerken</h2>
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

                    <hr>

                    <input type='submit' name='deleteUser' value='Account verwijderen' class='w3-button w3-red'>
                </form>
            </div>
            
        <?php
    } else {
        // If user is not logged in redirect to index
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    include('../includes/footer.php')
?>
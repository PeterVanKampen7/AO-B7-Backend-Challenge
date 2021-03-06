<?php
    // Indicate page depth
    $pageDepth = 1;

    // Header
    require('../includes/header.php');

    // If user indicated he does not want to delete redirect back to settings page
    if(isset($_POST['notDelete'])){
        header("Location: settings.php");
    // If user confirms he want to delete account, destroy the session and delete accout with function
    } else if(isset($_POST['deleteUser'])){
        deleteUser($_SESSION['user_id']);
        session_unset();
        session_destroy();
    }

?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>
            <form action="" method='POST' class="confirmDeleteForm">
                <h4>Weet je zeker dat je je account wilt verwijderen?</h4>
                <div class="options">
                    <input type="submit" name="notDelete" value='Nee' class="w3-button w3-blue">
                    <input type='submit' name='deleteUser' value='Ja, verwijder dit account' class='w3-button w3-red'>
                </div>        
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
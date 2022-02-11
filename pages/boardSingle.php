<?php
    $pageDepth = 1;

    require('../includes/header.php');

    $board_id = $_GET['id'];

?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>

        <?php
    } else {
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    include('../includes/footer.php')
?>
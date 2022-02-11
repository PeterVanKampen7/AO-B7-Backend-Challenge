<?php
    $pageDepth = 1;

    require('../includes/header.php');

    $board_id = $_GET['id'];

    if(isset($_POST['createList'])){
        createList($board_id, $_POST['listName']);
    }

    $lists = getLists($board_id);
?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>
            <div class="listContainer w3-container w3-padding">
                <div class="listControls">
                    <button class="w3-btn w3-blue-grey w3-margin" addListButton>Lijst aanmaken</button>
                    <form action="" method="post" addListForm>
                        <input type="text" name="listName" id="" placeholder="Lijst naam">
                        <input type="submit" value="Aanmaken" name="createList" class="w3-btn w3-blue-grey w3-padding">
                    </form>
                </div>
                <div class="">
                    <div class="">
                        <?php
                            foreach($lists as $list){
                                ?>

                                <?php
                            }
                        ?>
                    </div>              
                </div>
            </div>
        <?php
    } else {
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    include('../includes/footer.php')
?>
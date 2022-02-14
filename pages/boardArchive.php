<?php
    $pageDepth = 1;

    require('../includes/header.php');

    if(isset($_POST['createBoard'])){
        createBoard($_SESSION['user_id'], $_POST['boardName']);
    }
    if(isset($_POST['remove_board'])){
        deleteBoard($_POST['board_id']);
    }

    $boards = getBoards($_SESSION['user_id'], $_SESSION['admin']);

?>
    
<?php
    if($_SESSION['logged_in'] == true){
        ?>
            <div class="boardArchiveContainer w3-container w3-padding">
                <div class="boardArchiveControls">
                    <button class="w3-btn w3-blue-grey w3-margin" addBoardButton>Bord aanmaken</button>
                    <form action="" method="post" addBoardForm>
                        <input type="text" name="boardName" id="" placeholder="Bord naam">
                        <input type="submit" value="Aanmaken" name="createBoard" class="w3-btn w3-blue-grey w3-padding">
                    </form>
                </div>
                <div class="boardArchiveBoards">
                    <div class="boardArchiveBoardsContainer">
                        <?php
                            foreach($boards as $board){
                                ?>
                                    
                                        <div class="w3-card w3-blue w3-padding boardCard">
                                            <a href="boardSingle.php?id=<?php echo $board['id'];?>">
                                                <h3><?php echo $board['name']; ?></h3>
                                            </a>
                                            <button onclick='openModal("remove_board", <?php echo $board["id"]; ?>)'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                   
                                <?php
                            }
                        ?>
                    </div>              
                </div>
            </div>

            <div class="modal" modal>
                
                <div class='modalInner'>
                    <span onclick="document.querySelector('[modal]').style.display='none'"
                    class="w3-button">&times;</span>
                    <div class="modalContent" modalContent>
                        <p>Placeholder tekst</p>
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
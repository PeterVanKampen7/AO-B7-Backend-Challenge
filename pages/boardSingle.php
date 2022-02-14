<?php
    $pageDepth = 1;

    require('../includes/header.php');

    $board_id = $_GET['id'];

    if(isset($_POST['createList'])){
        createList($board_id, $_POST['listName']);
    }
    if(isset($_POST['add_card'])){
        createCard($_POST['list_id'], $_POST['cardTitle'], $_POST['cardDesc']);
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
                    <div class="list-container">
                        <?php
                            foreach($lists as $list){
                                ?>
                                    <div class="w3-card-4 single-list">

                                        <header class="w3-container w3-blue">
                                            <h1><?php echo $list['name']; ?></h1>
                                        </header>

                                        <?php 
                                            $cards = getCards($list['id']);
                                            foreach($cards as $card){
                                                ?>
                                                    <div class="w3-container singleCard">
                                                        <h4><?php echo $card['title'] ?></h4>
                                                        <p><?php echo $card['description'] ?></p>
                                                    </div>
                                                <?php
                                            }
                                        ?>

                                        <div class="w3-container w3-blue list-footer">
                                            <button class='w3-text-blue' onclick = 'openModal("add_card", <?php echo $list["id"]; ?>)' >
                                                Toevoegen
                                                <i class="fa-solid fa-circle-plus"></i>
                                            </button>           
                                        </div>
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
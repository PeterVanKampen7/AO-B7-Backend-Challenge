<?php
    $pageDepth = 1;

    require('../includes/header.php');

    $board_id = $_GET['id'];

    if(isset($_POST['createList'])){
        createList($board_id, $_POST['listName']);
    }
    else if(isset($_POST['add_card'])){
        $list_id = $_POST['list_id'];
        $title = $_POST['cardTitle'];
        $desc = $_POST['cardDesc'];
        $duration = $_POST['cardDuration'];
        $status = $_POST['cardStatus'];

        createCard($list_id, $title, $desc, $duration, $status);       
    }
    else if(isset($_POST['remove_list'])){
        deleteList($_POST['list_id']);
    }
    else if(isset($_POST['edit_list'])){
        editList($_POST['list_id'], $_POST['newName']);
    }
    else if(isset($_POST['edit_card'])){
        editCard($_POST['card_id'], $_POST['newName'], $_POST['newDesc']);
    }
    else if(isset($_POST['delete_card'])){
        deleteCard($_POST['card_id']);
    }

    $lists = getLists($board_id);

    $statuses = getStatuses();
    $statusesJSON = json_encode($statuses);

    $statusColors = array();
    foreach($statuses as $status){
        $statusColors[$status['id']] = $status['color'];
    }

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

                                        <header class="w3-container w3-blue list-header">
                                            <h1><?php echo $list['name']; ?></h1>

                                            <button onclick='openModal("edit_list", <?php echo $list["id"]; ?>, "<?php echo $list["name"]; ?>")'>
                                                <i class="fa-solid fa-edit"></i>
                                            </button>

                                            <button onclick='openModal("remove_list", <?php echo $list["id"]; ?>)'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </header>

                                        <?php 
                                            $cards = getCards($list['id']);
                                            if($cards){
                                                foreach($cards as $card){
                                                    ?>
                                                        <button class='single-card-button' onclick='openModal("edit_card", <?php echo $card["id"]; ?>, ["<?php echo $card["title"]; ?>","<?php echo $card["description"]; ?>"])'>
                                                            <div class="w3-container singleCard">
                                                                <h4 style="background-color: <?php echo $statusColors[$card['status']]; ?>"><?php echo $card['title'] ?></h4>
                                                                <p><?php echo $card['description'] ?></p>
                                                            </div>
                                                        </button>       
                                                    <?php
                                                }
                                            } else {
                                                echo '<br>';
                                            }
                                            
                                        ?>

                                        <div class="w3-container w3-blue list-footer">
                                            <button class='w3-text-blue' onclick = 'openModal("add_card", <?php echo $list["id"]; ?>, <?php echo $statusesJSON; ?>)' >
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
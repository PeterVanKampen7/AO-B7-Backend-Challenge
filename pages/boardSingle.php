<?php
    // Indicate page depth
    $pageDepth = 1;

    // Header   
    require('../includes/header.php');

    // Get board id from superglobal $_GET
    $board_id = $_GET['id'];

    // If user creates new list, create the list with function
    if(isset($_POST['createList'])){
        createList($board_id, $_POST['listName']);
        header("location:".$_SERVER['REQUEST_URI']);
    }
    // If user want to add card, create card with function
    else if(isset($_POST['add_card'])){
        $list_id = $_POST['list_id'];
        $title = $_POST['cardTitle'];
        $desc = $_POST['cardDesc'];
        $duration = $_POST['cardDuration'];
        $status = $_POST['cardStatus'];

        createCard($list_id, $title, $desc, $duration, $status);   
        header("location:".$_SERVER['REQUEST_URI']);    
    }
    // If user want to remove the list, remove the list with function
    else if(isset($_POST['remove_list'])){
        deleteList($_POST['list_id']);
        header("location:".$_SERVER['REQUEST_URI']);
    }
    // If user wants to edit list, edit list with function
    else if(isset($_POST['edit_list'])){
        editList($_POST['list_id'], $_POST['newName']);
        header("location:".$_SERVER['REQUEST_URI']);
    }
    // If user wants to edit card, edit card with function
    else if(isset($_POST['edit_card'])){
        editCard($_POST['card_id'], $_POST['newName'], $_POST['newDesc'], $_POST['newTime'], $_POST['newStatus']);
        header("location:".$_SERVER['REQUEST_URI']);
    }
    // If user wants to delete card, delete card with function
    else if(isset($_POST['delete_card'])){
        deleteCard($_POST['card_id']);
        header("location:".$_SERVER['REQUEST_URI']);
    }

    // Get all lists for current board
    $lists = getLists($board_id);

    // Get all possible statuses from DB
    $statuses = getStatuses();
    // Encode these statuses into JSON
    $statusesJSON = json_encode($statuses);

    // Make an array that has status id as key and the corresponding color as value
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
                                            <h1>
                                                <?php 
                                                    // Add list name
                                                    echo $list['name']; 

                                                    // Below are an assortment of buttons, they each open the modal using a JS function. Their parameters vary, but contain all the info needed to do the desired action
                                                ?>
                                            </h1>

                                            <button onclick='openModal("sort_list", <?php echo $list["id"]; ?>, <?php echo $statusesJSON; ?>)'>
                                                <i class="fa-solid fa-filter"></i>
                                            </button>

                                            <button onclick='openModal("edit_list", <?php echo $list["id"]; ?>, "<?php echo $list["name"]; ?>")'>
                                                <i class="fa-solid fa-edit"></i>
                                            </button>

                                            <button onclick='openModal("remove_list", <?php echo $list["id"]; ?>)'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </header>

                                        <?php 
                                            // Get all cards for the current list
                                            $cards = getCards($list['id']);
                                            // If this list has cards
                                            if($cards){

                                                // If a sort function is set by the user, show to cards in the desired order. Just reorder the cards array based on the user wish

                                                if(isset($_POST['sortASC']) && $_POST['sortedListId'] == $list['id']){
                                                    // Sort cards ASC on time duration
                                                    usort($cards, function($a, $b) {
                                                        return $a['duration'] - $b['duration'];
                                                    });
                                                } else if(isset($_POST['sortDESC']) && $_POST['sortedListId'] == $list['id']){
                                                    // Sort cards DESC on time duration
                                                    usort($cards, function($a, $b) {
                                                        return $b['duration'] - $a['duration'];
                                                    });
                                                } else if(isset($_POST['sortGroupBy']) && $_POST['sortedListId'] == $list['id']){
                                                    // Sort cards on the status, grouping alphabatically
                                                    usort($cards, function($a, $b) {
                                                        return $a['status'] - $b['status'];
                                                    });
                                                } else if(isset($_POST['sortStatus']) && $_POST['sortedListId'] == $list['id']){
                                                    // Remove all cards from array that do not have the desired status
                                                    $cards = array_filter($cards, function($x){
                                                        return $x['status'] == $_POST['statusFilter'];
                                                    });
                                                }

                                                foreach($cards as $card){
                                                    // Add each card to the list
                                                    ?>
                                                        <button class='single-card-button' onclick='openModal("edit_card", <?php echo $card["id"]; ?>, ["<?php echo $card["title"]; ?>","<?php echo $card["description"]; ?>",`<?php echo $statusesJSON; ?>`,"<?php echo $card["status"] ?>","<?php echo $card["duration"] ?>"])'>
                                                            <div class="w3-container singleCard">
                                                                <h4 style="background-color: <?php echo $statusColors[$card['status']]; ?>"><?php echo $card['title'] ?></h4>
                                                                <p><?php echo $card['description'] ?></p>
                                                            </div>
                                                        </button>       
                                                    <?php
                                                }
                                            } else {
                                                // If this list does not have cards show an element that indicates this
                                                ?>
                                                    <div class='empty-list'>Geen items</div>
                                                <?php
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
                    <span onclick="document.querySelector('[modal]').style.display='none'" class="w3-button">&times;</span>
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
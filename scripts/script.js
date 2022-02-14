try{
    document.querySelector('[addBoardButton]').addEventListener('click', function(){
        document.querySelector('[addBoardForm]').style.display = 'block';  
    });
} catch(e){}

try{
    document.querySelector('[addListButton]').addEventListener('click', function(){
        document.querySelector('[addListForm]').style.display = 'block';  
    });
} catch(e){}

function openModal(reason, id = 0, extra = ''){
    const modal = document.querySelector('[modal]');
    const modalContent = document.querySelector('[modalContent]');

    let content = '';
    switch(reason){
        case 'add_card':
            content += renderAddCardForm(reason, id);
            break;
        case 'remove_list':
            content += renderDeleteList(reason, id);
            break;
        case 'remove_board':
            content += renderDeleteBoard(reason, id);
            break;
        case 'edit_list':
            content += renderEditList(reason, id, extra);
            break;
        case 'edit_board':
            content += renderEditBoard(reason, id, extra);
            break;
    }

    modalContent.innerHTML = content;
    modal.style.display = 'flex'; 
}

function renderAddCardForm(reason, id){
    return `
        <h4> Kaart toevoegen </h4>
        <form method='post' class='addCardForm'>
            <label for='cardTitle'>Titel</label>
            <input type='text' name='cardTitle' />

            <label for='cardDesc'>Beschrijving</label>
            <textarea name='cardDesc'></textarea>

            <input type='hidden' name='list_id' value='${id}' />

            <input type='submit' name='${reason}' value='Aanmaken' class='w3-button w3-blue'>
        </form>
    `;
}

function renderDeleteList(reason, id){
    return `
        <h4> Lijst verwijderen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='list_id' value='${id}' />
            <label for='${reason}'>Weet je zeker dat je deze lijst wilt verwijderen?</label>
            <input type='submit' name='${reason}' value='Verwijderen' class='w3-button w3-red'>
        </form>
    `;
}

function renderDeleteBoard(reason, id){
    return `
        <h4> Bord verwijderen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='board_id' value='${id}' />
            <label for='${reason}'>Weet je zeker dat je dit bord wilt verwijderen?</label>
            <input type='submit' name='${reason}' value='Verwijderen' class='w3-button w3-red'>
        </form>
    `;
}

function renderEditList(reason, id, extra){
    return `
        <h4> Naam aanpassen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='list_id' value='${id}' />
            <label for='newName'>Naam</label>
            <input type='text' name='newName' value='${extra}' placeholder='${extra}' />

            <input type='submit' name='${reason}' value='Aanpassen' class='w3-button w3-blue'>
        </form>
    `;
}

function renderEditBoard(reason, id, extra){
    return `
        <h4> Naam aanpassen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='board_id' value='${id}' />
            <label for='newName'>Naam</label>
            <input type='text' name='newName' value='${extra}' placeholder='${extra}' />

            <input type='submit' name='${reason}' value='Aanpassen' class='w3-button w3-blue'>
        </form>
    `;
}
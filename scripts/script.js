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

function openModal(reason, id = 0){
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
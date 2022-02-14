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
    if(reason == 'add_card'){      
        content += `
            <h4> Kaart toevoegen </h4>
            <form method='post' class='addCardForm'>
                <label for='cardTitle'>Titel</label>
                <input type='text' name='cardTitle' />

                <label for='cardDesc'>Beschrijving</label>
                <textarea name='cardDesc'></textarea>

                <input type='hidden' name='list_id' value='${id}' />

                <input type='submit' name='${reason}' value='Aanmaken'>
            </form>
        `;
    }

    modalContent.innerHTML = content;
    modal.style.display = 'flex'; 
}


try {
    document.querySelector('[addBoardButton]').addEventListener('click', function() {
        document.querySelector('[addBoardForm]').style.display = 'block';
    });
} catch (e) {}

try {
    document.querySelector('[addListButton]').addEventListener('click', function() {
        document.querySelector('[addListForm]').style.display = 'block';
    });
} catch (e) {}

function openModal(reason, id, extra = '') {
    const modal = document.querySelector('[modal]');
    const modalContent = document.querySelector('[modalContent]');

    let content = '';
    switch (reason) {
        case 'add_card':
            content += renderAddCardForm(reason, id, extra);
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
        case 'edit_card':
            content += renderCardContent(reason, id, extra);
            break;
        case 'sort_list':
            content += renderSortList(id, extra);
            break;
    }

    modalContent.innerHTML = content;
    modal.style.display = 'flex';
}

function renderAddCardForm(reason, id, extra) {
    let statusArray = JSON.parse(JSON.stringify(extra));
    let output = '';
    for (let i in statusArray) {
        output += `
            <option value='${statusArray[i]['id']}'>${statusArray[i]['name']}</option>
        `;
    }

    return `
        <h4> Kaart toevoegen </h4>
        <form method='post' class='addCardForm'>
            <label for='cardTitle'>Titel</label>
            <input type='text' name='cardTitle' />

            <label for='cardDesc'>Beschrijving</label>
            <textarea name='cardDesc'></textarea>

            <label for='cardDuration'>Tijdsduur</label>
            <input type='number' name='cardDuration' />

            <label for='cardStatus'>Status</label>
            <select name='cardStatus'>
            ${output}
            </select>

            <input type='hidden' name='list_id' value='${id}' />

            <input type='submit' name='${reason}' value='Aanmaken' class='w3-button w3-blue'>
        </form>
    `;
}

function renderDeleteList(reason, id) {
    return `
        <h4> Lijst verwijderen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='list_id' value='${id}' />
            <label for='${reason}'>Weet je zeker dat je deze lijst wilt verwijderen?</label>
            <input type='submit' name='${reason}' value='Verwijderen' class='w3-button w3-red'>
        </form>
    `;
}

function renderDeleteBoard(reason, id) {
    return `
        <h4> Bord verwijderen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='board_id' value='${id}' />
            <label for='${reason}'>Weet je zeker dat je dit bord wilt verwijderen?</label>
            <input type='submit' name='${reason}' value='Verwijderen' class='w3-button w3-red'>
        </form>
    `;
}

function renderEditList(reason, id, extra) {
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

function renderEditBoard(reason, id, extra) {
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

function renderCardContent(reason, id, extra) {
    let statusArray = JSON.parse(extra[2]);
    let output = '';
    for (let i in statusArray) {
        if (extra[3] == statusArray[i]['id']) {
            output += `
                <option selected value='${statusArray[i]['id']}'>${statusArray[i]['name']}</option>
            `;
        } else {
            output += `
                <option value='${statusArray[i]['id']}'>${statusArray[i]['name']}</option>
            `;
        }
    }

    return `
        <h4> Kaart aanpassen </h4>
        <form method='post' class='addCardForm'>      
            <input type='hidden' name='card_id' value='${id}' />
            <label for='newName'>Naam</label>
            <input type='text' name='newName' value='${extra[0]}' />

            <label for='newDesc'>Beschrijving</label>
            <textarea type='text' name='newDesc'>${extra[1]}</textarea>

            <label for='newTime'>Tijdsduur</label>
            <input type='number' name='newTime' value='${extra[4]}' />

            <label for='newStatus'>Status</label>
            <select name='newStatus'>
            ${output}
            </select>

            <input type='submit' name='${reason}' value='Aanpassen' class='w3-button w3-blue'>
            <hr>
            <input type='submit' name='delete_card' value='Kaart verwijderen' class='w3-button w3-red'>
        </form>
    `;
}

function renderSortList(id, extra) {
    let statusArray = JSON.parse(JSON.stringify(extra));
    let output = '';
    for (let i in statusArray) {
        output += `
            <option value='${statusArray[i]['id']}'>${statusArray[i]['name']}</option>
        `;
    }
    return `
        <h4> Filter lijst </h4>
        <form method='post' class='sortListModal'>
            <input type='hidden' value='${id}' name='sortedListId'>
            <input type='submit' class='w3-button w3-blue w3-margin-bottom' name='sortASC' value='Tijd oplopend' />
            <input type='submit' class='w3-button w3-blue w3-margin-bottom' name='sortDESC' value='Tijd aflopend' />
            <input type='submit' class='w3-button w3-blue w3-margin-bottom' name='sortGroupBy' value='Groepeer statusen' />
            <select name='statusFilter'>
            ${output}
            </select>
            <input type='submit' class='w3-button w3-blue w3-margin-bottom' name='sortStatus' value='Alleen deze status' />
            <hr>
            <input type='submit' class='w3-button w3-red w3-margin-bottom' name='removeFilters' value='Verwijder filters' />
        </form>
    `;
}
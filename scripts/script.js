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


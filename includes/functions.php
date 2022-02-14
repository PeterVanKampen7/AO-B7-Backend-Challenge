<?php

// Prep functions, globally useful
function openConn(){
    try {
        $conn = new PDO('mysql:host=localhost;dbname=b7_back-end', "root", "mysql");
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    return $conn;
}

function closeConn($conn){
    $conn = null;
}

function clean($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// End prep functions


// Check credentials
function credCheck($name, $pass){
    $conn = openConn();

    $name = clean($name);
    $pass = clean($pass);

    $query = "SELECT * FROM `users` WHERE `username`=:user AND `password`=:pass";
    $result = $conn->prepare($query);
    $result->execute(['user' => $name, 'pass' => $pass]);
    $user = $result->fetch();

    closeConn($conn);

    return $user;
}
// End credentials


// User information functions
function getUser($id){
    $conn = openConn();

    $id = clean($id);

    $query = "SELECT * FROM `users` WHERE `id`=:id";
    $result = $conn->prepare($query);
    $result->execute(['id' => $id]);
    $user = $result->fetch();

    closeConn($conn);

    return $user;
}

function createUser($name, $pass){
    $conn = openConn();

    $name = clean($name);
    $pass = clean($pass);

    $result = $conn->prepare("INSERT INTO users SET 
        username = :user,
        `password` = :pass
    ");
    $result->execute([
        'user' => $name,
        'pass' => $pass
    ]);

    $id = $conn->lastInsertId();

    closeConn($conn);

    return $id;
}
// End user information functions


// Board information functions
function getBoards($id, $admin = false){
    $conn = openConn();

    if($admin){

        $query = "SELECT * FROM `boards`";
        $result = $conn->prepare($query);
        $result->execute(['id' => $id]);
        $boards = $result->fetchAll();

    } else {

        $query = "SELECT * FROM `boards` WHERE `user_id`=:id";
        $result = $conn->prepare($query);
        $result->execute(['id' => $id]);
        $boards = $result->fetchAll();

    }

    closeConn($conn);

    return $boards;
}
function createBoard($id, $name){
    $conn = openConn();

    $name = clean($name);
    $id = clean($id);

    $result = $conn->prepare("INSERT INTO boards SET 
        `user_id` = :user,
        `name` = :name
    ");
    $result->execute([
        'user' => $id,
        'name' => $name
    ]);

    $id = $conn->lastInsertId();

    closeConn($conn);

    return $id;
}
function getLists($board_id){
    $conn = openConn();

    $board_id = clean($board_id);

    $query = "SELECT * FROM `lists` WHERE `board_id`=:board_id";
    $result = $conn->prepare($query);
    $result->execute(['board_id' => $board_id]);
    $lists = $result->fetchAll();

    closeConn($conn);

    return $lists;
}
function createList($board_id, $name){
    $conn = openConn();

    $name = clean($name);
    $board_id = clean($board_id);

    $result = $conn->prepare("INSERT INTO lists SET 
        `board_id` = :id,
        `name` = :name
    ");
    $result->execute([
        'id' => $board_id,
        'name' => $name
    ]);

    closeConn($conn);
}
function getCards($list_id){
    $conn = openConn();

    $list_id = clean($list_id);

    $query = "SELECT * FROM `cards` WHERE `list_id`=:list_id";
    $result = $conn->prepare($query);
    $result->execute(['list_id' => $list_id]);
    $cards = $result->fetchAll();

    closeConn($conn);

    return $cards;
}
function createCard($list_id, $title, $desc){
    $conn = openConn();

    $list_id = clean($list_id);
    $title = clean($title);
    $desc = clean($desc);

    $result = $conn->prepare("INSERT INTO cards SET 
        `list_id` = :list_id,
        `title` = :title,
        `description` = :descrip
    ");
    $result->execute([
        'list_id' => $list_id,
        'title' => $title,
        'descrip' => $desc
    ]);

    closeConn($conn);
}
// End board information functions

// Start delete functions
function deleteBoard($board_id){
    $conn = openConn();

    $board_id = clean($board_id);

    $query = "SELECT `id` FROM `lists` WHERE `board_id`=:board_id";
    $result = $conn->prepare($query);
    $result->execute(['board_id' => $board_id]);
    $lists = $result->fetchAll();


    $board = $conn->prepare("DELETE FROM boards WHERE id=:safe");
    $board->execute(['safe' => $board_id]);

    foreach($lists as $list){
        deleteList($list['id']);
    }

    closeConn($conn);
}
function deleteList($list_id){
    $conn = openConn();

    $list_id = clean($list_id);

    $list = $conn->prepare("DELETE FROM lists WHERE id=:safe");
    $list->execute(['safe' => $list_id]);

    $cards = $conn->prepare("DELETE FROM cards WHERE list_id=:safe");
    $cards->execute(['safe' => $list_id]);

    closeConn($conn);
}
// End delete functions

// Start edit functions
function editList($list_id, $name){
    $conn = openConn();

    $list_id = clean($list_id);
    $name = clean($name);

    $result = $conn->prepare("UPDATE lists SET 
        `name` = :safe
        WHERE id=:id"
    );
    $result->execute([
        'safe' => $name,
        'id' => $list_id
    ]); 

    closeConn($conn);
}
// End edit functions
?>
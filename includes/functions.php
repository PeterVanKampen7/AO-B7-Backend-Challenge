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
    $boards = $result->fetchAll();

    closeConn($conn);

    return $boards;
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
// End board information functions

?>
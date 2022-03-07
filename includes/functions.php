<?php

// Globally useful functions
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
// End global functions



// Check credentials
function credCheck($name, $pass){
    $conn = openConn();

    $name = clean($name);
    $pass = clean($pass);

    $query = "SELECT users.*, roles.name AS 'role_name' 
    FROM `users` 
    LEFT JOIN roles on users.role_id = roles.id  
    WHERE `username`=:user AND `password`=:pass";

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

    $query = "SELECT users.*, roles.name AS 'role_name' 
    FROM `users` 
    LEFT JOIN roles on users.role_id = roles.id 
    WHERE users.id=:id";

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
function editUser($user, $pass, $role, $id){
    $conn = openConn();

    $user = clean($user);
    $pass = clean($pass);
    $role = clean($role);
    $id = clean($id);

    $result = $conn->prepare("UPDATE users SET 
        `username` = :user,
        `password` = :pass,
        `role_id` = :role
        WHERE id=:id"
    );
    $result->execute([
        'user' => $user,
        'pass' => $pass,
        'role' => $role,
        'id' => $id
    ]); 

    closeConn($conn);
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
function editBoard($board_id, $name){
    $conn = openConn();

    $board_id = clean($board_id);
    $name = clean($name);

    $result = $conn->prepare("UPDATE boards SET 
        `name` = :safe
        WHERE id=:id"
    );
    $result->execute([
        'safe' => $name,
        'id' => $board_id
    ]); 

    closeConn($conn);
}
// End board functions



// Start List functions
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
function deleteList($list_id){
    $conn = openConn();

    $list_id = clean($list_id);

    $list = $conn->prepare("DELETE FROM lists WHERE id=:safe");
    $list->execute(['safe' => $list_id]);

    $cards = $conn->prepare("DELETE FROM cards WHERE list_id=:safe");
    $cards->execute(['safe' => $list_id]);

    closeConn($conn);
}
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
// End list functions



// Start card functions
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
function createCard($list_id, $title, $desc, $duration, $status){
    $conn = openConn();

    $list_id = clean($list_id);
    $title = clean($title);
    $desc = clean($desc);
    $duration = clean($duration);
    $status = clean($status);

    $result = $conn->prepare("INSERT INTO cards SET 
        `list_id` = :list_id,
        `title` = :title,
        `description` = :descrip,
        `duration` = :duration,
        `status` = :status
    ");
    $result->execute([
        'list_id' => $list_id,
        'title' => $title,
        'descrip' => $desc,
        'duration' => $duration,
        'status' => $status
    ]);

    closeConn($conn);
}
function deleteCard($card_id){
    $conn = openConn();

    $card_id = clean($card_id);

    $cards = $conn->prepare("DELETE FROM cards WHERE id=:safe");
    $cards->execute(['safe' => $card_id]);

    closeConn($conn);
}
function editCard($card_id, $name, $desc, $time, $status){
    $conn = openConn();

    $card_id = clean($card_id);
    $name = clean($name);
    $desc = clean($desc);

    $result = $conn->prepare("UPDATE cards SET 
        `title` = :name,
        `description` = :desc,
        `duration` = :time,
        `status` = :status
        WHERE id=:id"
    );
    $result->execute([
        'name' => $name,
        'desc' => $desc,
        'time' => $time,
        'status' => $status,
        'id' => $card_id       
    ]); 

    closeConn($conn);
}
// End Card functions



// Start Status functions
function getStatuses(){
    $conn = openConn();

    $query = "SELECT * FROM `statuses`";
    $result = $conn->prepare($query);
    $result->execute();
    $statuses = $result->fetchAll();

    closeConn($conn);

    return $statuses;
}
// End Status functions



// Start Roles functions
function getRoles(){
    $conn = openConn();

    $query = "SELECT * FROM `roles`";
    $result = $conn->prepare($query);
    $result->execute();
    $roles = $result->fetchAll();

    closeConn($conn);

    return $roles;
}
function rolesToOptions($roles, $current_role = null){
    $return = '<option disabled selected> Kies jouw rol </option>';

    foreach($roles as $role){
        if($role['id'] == $current_role){
            $return .= "<option selected value={$role['id']}> {$role['name']} </option>";
        } else {
            $return .= "<option value={$role['id']}> {$role['name']} </option>";
        }
    }

    return $return;
}
// End roles functions
?>
<?php

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

function clean($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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

?>
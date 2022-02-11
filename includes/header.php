<?php
    session_start();
    include('functions.php');
    $navLinks = array();
    switch($pageDepth){
        case 0:
            $navLinks['Home'] = 'index.php';
            $navLinks['Mijn borden'] = 'pages/boardArchive.php';
            break;
        case 1:
            $navLinks['Home'] = '../index.php';
            $navLinks['Mijn borden'] = '../pages/boardArchive.php';
            break;
    }

    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <?php
        if($pageDepth == 0){
            echo '
            <link rel="stylesheet" href="styles/style.css">
            <script defer src="scripts/script.js"></script>';
        } else if($pageDepth == 1){
            echo '
            <link rel="stylesheet" href="../styles/style.css">
            <script defer src="../scripts/script.js"></script>';
        }
    ?>
    <title>To Do App</title>
</head>
<body>
    <header class='header_nav w3-bar w3-blue-gray'>
        <div class="header-left">
            <h1 class="nav_title">
                <a href="<?php echo $navLinks['Home']; ?>" >To Do App</a>
            </h1>
        </div>
        <div class="w3-bar header-right">
            <?php
                foreach($navLinks as $key => $value){
                    echo "<a href='{$value}' class='w3-bar-item'>{$key}</a>";
                }
            ?>
        </div>
        <div class="logout">
            <form action="" method="post">
                <input type="submit" value="Log uit" name="logout" class="logout-btn w3-bar-item">
            </form>
        </div>
    </header>
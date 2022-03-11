<?php
    // Always start a SESSION on all pages
    session_start();
    // Include all functions, header is included on all pages, so functions will be on all pages as well
    include('functions.php');
    // Make empty array to build nav menu
    $navLinks = array();
    // Depending on page depth fill the array with key value containing links to pages
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

    // If user logs out unset and destroy the SESSION
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
    <script src="https://kit.fontawesome.com/7cbd5a96fb.js" crossorigin="anonymous"></script>
    
    <?php
        // Link JS and CSS
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
            // Loop through the menu array, and put these items in the menu
                foreach($navLinks as $key => $value){
                    echo "<a href='{$value}' class='w3-bar-item'>{$key}</a>";
                }
            ?>
        </div>
        <div class="logout">
            <?php
            // Add account page link to menu
                if($pageDepth == 0){
                    echo '
                        <a href="pages/settings.php">Account</a>
                    ';
                } else if($pageDepth == 1){
                    echo '
                        <a href="../pages/settings.php">Account</a>
                    ';
                }
            ?>
            <form action="" method="post">
                <input type="submit" value="Log uit" name="logout" class="logout-btn w3-bar-item">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </form>
        </div>
    </header>
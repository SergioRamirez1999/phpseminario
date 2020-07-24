<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminario</title>
    <link rel="stylesheet" href="views/css/fontello.css">
    <link rel="stylesheet" href="views/css/styles.css">
    
</head>
<body>


<?php

    if(isset($_GET["page"])){
        echo '<div class="fx fx-jc-ctr">
            <div class="center-container fx fx-jc-btw">';
        switch($_GET["page"]){
            case "home": 
                include 'pages/home.php';
            break;
            case "profile":
                include 'pages/profile.php';
            break;
            case "follows":
                include 'pages/follows.php';
            break;
            case "search":
                include 'pages/search.php';
            case "logout":
                include 'pages/logout.php';
            break;
        }

        echo '    </div>

        </div>';

    }else {
        include 'pages/init.php';
    }
    
    
?>



    
</body>
</html>
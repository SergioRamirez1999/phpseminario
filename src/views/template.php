<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminario</title>
    <link rel="stylesheet" href="views/css/fontello.css">
    <link rel="stylesheet" href="views/css/styles.css">
    <script type="module" src="views/js/main.js"></script>
</head>
<body>
<div class="fx fx-jc-ctr">
    <!-- UTILIZADO PARA EL RESPONSIVE-->
    <div class="center-container fx fx-jc-btw">
        <?php
            include 'pages/modules/sidebar.php';
        ?>

        <section class="between-content" id="between-content"></section>
        <?php
            include 'pages/modules/trending.php';
        ?>

    </div>

</div>
    
</body>
</html>
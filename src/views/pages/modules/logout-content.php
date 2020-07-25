<?php
    if(session_status() == PHP_SESSION_NONE)
        session_start();
    session_destroy();
    unset($_SESSION['user_data']);
    header("Location: http://localhost/phpseminario/src");
    exit;
?>
<?php


    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        echo '<script> window.location.href = "http://localhost/phpseminario/src?page=home" </script>';
    }



?>

<header class="header-container">
    <nav class="nav-content fx fx-jc-sa">


        <a href="http://localhost/phpseminario/src">

            <img src="views/img/logo-white.png" class="logo-web" alt="world logo">

        </a>


        <div class="buttons-content">

            <button id="btn-signin" class="btn btn-primary">Iniciar</button>

            <button id="btn-signup" class="btn btn-primary">Registrarse</button>

        </div>

        <script type="module" src="views/js/modal-signup.js"></script>
        <script type="module" src="views/js/modal-signin.js"></script>

    </nav>
</header>

<div class="body-container fx fx-jc-ctr">

    <div class="center-container-idx fx fx-jc-sa">

        <div class="explore-container">
            <div class="title-content">
                <h2 class="title">Explorar</h2>
            </div>


            <div class="displayer-content fx fx-column fx-ai-ctr">
                <div class="post-displayed-content">
                    <img src="views/img/post-example-1.jpg" alt="post image">
                </div>
                <div class="post-displayed-content">
                    <img src="views/img/post-example-2.jpg" alt="post image">
                </div>

                <div class="post-displayed-content">
                    <img src="views/img/post-example-3.jpg" alt="post image">
                </div>
            </div>
        </div>

        <div class="side-container fx fx-column fx-ai-ctr">
            <div class="welcome-content">
                <img src="views/img/welcome.jpg" alt="welcome image">
            </div>

            <footer class="footer-container fx fx-jc-ctr fx-ai-ctr">
                <div class="ctr-foot-container fx fx-column fx-jc-sa fx-ai-ctr">
                    <div class="social-network-container fx fx-column fx-jc-sa">
                        <a href="http://www.instagram.com" target="_blank">
                            <i class="fab fa-instagram" style="font-size: 26px"></i>
                        </a>
                        <a href="http://www.facebook.com" target="_blank">
                            <i class="fab fa-facebook-square" style="font-size: 26px"></i>
                        </a>
                        <a href="http://www.twitter.com" target="_blank">
                            <i class="fab fa-twitter-square" style="font-size: 26px"></i>
                        </a>
                    </div>
                    <div class="footer-text fx fx-column fx-ai-ctr">
                        <span>&copy; Copyright 2019 - 2025.</span>
                        <span>Todos los derechos reservados.</span>
                    </div>
                </div>


            </footer>
        </div>


    </div>

</div>
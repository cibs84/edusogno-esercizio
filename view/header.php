<!-- HEADER -->
<header>
    <div class="row">
        <!-- Logo -->
        <a href="../index.php">
            <img class="logo" src="../assets/img/logo_edusogno.svg" alt="Logo Edusogno">
        </a>

        <!-- Login/Logout -->
        <?php
        // SE l'utente è loggato ALLORA viene reindirizzato alla 'pagina-personale.php'
        if (isUserLoggedin()) {
            echo '<a href="../pages/log-out.php">Logout</a>';
        // ALTRIMENTI verrà reindirizzato alla pagina 'log-in.php'
        } else {
            echo '<a href="../pages/log-in.php">Login</a>';
        }
        ?>
    </div>
</header>
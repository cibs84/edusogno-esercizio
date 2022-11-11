<?php
session_start();
require_once 'headerInclude.php';

// SE l'utente è loggato ALLORA viene reindirizzato alla 'pagina-personale.php'
if (isUserLoggedin()) {
    header('Location: pages/pagina-personale.php');
    exit;
// ALTRIMENTI verrà reindirizzato alla pagina 'log-in.php'
} else {
    header('Location: pages/log-in.php');
    exit;
}
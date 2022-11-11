<?php
session_start();
require_once 'headerInclude.php';

$userFormData = $_POST;
$token = $_POST['_csrf'];
$email = $_POST['email'];
$password = $_POST['password'];

$_SESSION['email'] = $email;
$_SESSION['csrf'] = $token;

$requiredColumns = ['email', 'password'];

var_dump($email);

// Controlla che i campi obbligatori del form siano stati inseriti
$validationError = formValidation($requiredColumns, $userFormData);
if (!empty($validationError)) {
    $_SESSION['validationError'] = $validationError; 
    header('Location: pages/log-in.php?email='.$email);
    die;
}

// Verifica che l'utente si sia loggato
// poi elimina il token csrf dalla sessione 
$result = verifyLogin($token, $email, $password);
unset($_SESSION['csrf']); 

// SE l'utente è loggato
if ($result['success']) {
    // Per ragioni di sicurezza, rigenera l'id della sessione
    // ed elimina la password dell'utente
    session_regenerate_id();
    unset($result['user']['password']);

    // Assegno alla sessione i dati dell'utente loggato per passarli alla view
    $_SESSION['user'] = $result['user'];

    // Tramite sessione, passo alle views 
    // la conferma dell'avvenuto log-in dell'utente 
    $_SESSION['loggedin'] = true;

    // Prende tutti gli eventi collegati all'utente e li passa tramite sessione
    $_SESSION['user']['events'] = getEventsByUserEmail($email);

    // Reindirizza alla pagina-personale.php
    header('Location: pages/pagina-personale.php');

// ALTRIMENTI Reindirizza alla pagina log-in.php
} else {
    // Assegno alla sessione l'esito della verifica del login 
    // e il messaggio da stampare in view
    $_SESSION['message'] = $result['message'];
    $_SESSION['success'] = $result['success'];

    header('Location: pages/log-in.php');
}
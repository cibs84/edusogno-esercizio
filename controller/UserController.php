<?php
session_start();
require_once '../functions.php';
require_once '../models/User.php';
require_once '../models/Event.php';

$userFormData = $_POST; // Dati passati dal form
$conn = $GLOBALS['mysqli'];
$requiredColumns = getConfig('requiredColumns'); // Campi del form obbligatori

// Querystring per reinviare al form di registrazione i valori dei campi già immessi
// per evitare che si resettino in caso di redirect per errore di validazione 
$queryString = http_build_query($userFormData, "&");

// Controlla che i campi obbligatori del form siano stati inseriti
$validationError = formValidation($requiredColumns, $userFormData);
if (!empty($validationError)) {
    $_SESSION['validationError'] = $validationError; 
    header('Location:../pages/registrazione.php?'.$queryString);
    die;
}

// Effettua l'escaping di tutti i valori immessi nel form ad esclusione della password
// che verrà criptata prima di essere utilizzata per la query al db
foreach ($userFormData as $key => $val) {
    if ($key !== 'password') {
        $userFormData[$key] = mysqli_real_escape_string($conn, $val);
    }
}

// Cripta la password dopo aver controllato che sia stata inserita nel form
$userFormData['password'] = password_hash($userFormData['password'], PASSWORD_DEFAULT);

// Crea un nuovo utente invocando userCreate() dal model 'User.php'  
$res = userCreate($userFormData, $conn);

// Variabili da passare tramite sessione per la stampa in view 
// dell'esito della creazione del nuovo utente
$message = $res ? "L'Utente {$userFormData['nome']}, è stato creato con successo!" : "Errore nella creazione dell'Utente {$userFormData['nome']}";
$alertType = $res ? 'success' : 'danger';
$_SESSION['message'] = $message;
$_SESSION['alertType'] = $alertType;

// Dati del nuovo utente che vengono passati tramite sessione
unset($userFormData['password']);
$_SESSION['user'] = $userFormData;
$_SESSION['loggedin'] = true;

// Prende tutti gli eventi collegati all'utente e li passa tramite sessione
$_SESSION['user']['events'] = getEventsByUserEmail($_SESSION['user']['email']);

// Reindirizzamento alla 'pagina-personale.php'
header('Location:../pages/pagina-personale.php');
die;
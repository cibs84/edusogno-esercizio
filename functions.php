<?php
require_once 'connection.php';

function verifyLogin($token, $email, $password) {

    // Verifica che ci sia corrispondenza tra il CSRF di sessione e quello inviato tramite form
    if ($_SESSION['csrf'] !== $token) {
        $result = [
            'message' => 'Utente non loggato. Mancata corrispondenza con il token della sessione.',
            'success' => false
        ];
        return $result;
    }

    // Verifica che l'email inserita sia un'email
    $res = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$res) {
        $result = [
            'message' => 'Utente non loggato. L\'email inserita non è valida.',
            'success' => false
        ];
        return $result;
    }

    // Verifica se nel db esiste un utente associato 
    // all'email inserita nel form di log-in
    $resUserByEmail = getUserByEmail($email);
    if (!$res) {
        $result = [
            'message' => 'Non esiste un utente associato a questa email',
            'success' => false
        ];
        return $result;
    }

    // Verifica che la password sia corretta
    if (!password_verify($password, $resUserByEmail['password'] ?? '')) {
        $result = [
            'message' => 'Utente non loggato. Password non valida',
            'success' => false
        ];
        return $result;
    }

    // L'utente è loggato e viene restituito il risultato con
    // il messaggio di conferma da stampare nella view, l'esito della validazione
    // e l'array con i dati dell'utente loggato
    $result = [
        'message' => 'Utente loggato',
        'success' => true,
        'user' => $resUserByEmail
    ];

    return $result;
}

// Restituisce un booleano relativo al log-in dell'utente
function isUserLoggedin() {
    return $_SESSION['loggedin'] ?? false;
}

// Restituisce il $param passato per argomento
// SE è presente nella $_REQUEST ALTRIMENTI $default
function getParam($param, $default = null) {
    return !empty($_REQUEST[$param]) ? $_REQUEST[$param] : $default;
}

// Restituisce il $param passato per argomento
// SE è presente in $config ALTRIMENTI $default
function getConfig($param, $default = null) {
    $config = require 'config.php';
    return array_key_exists($param, $config) ? $config[$param] : $default;
}


// Esegue la migrazione nel db dei dati contenuti in 'Migrations.sql'
function migrateInit($conn) {
    $sql = file_get_contents('assets/db/Migrations.sql');

    // $conn->multi_query($sql);

    if ($conn->multi_query($sql) === TRUE) {
        echo "Inserimento terminato correttamente";
    } else {
        echo "Errore in fase di inserimento:" . $conn->error;
    }
}
// ESEGUE LA MIGRAZIONE DEL DB
// migrateInit($GLOBALS['mysqli']);


// Valida se sono stati compilati i campi richiesti nel form
// Restituisce un array $validationError con:
// - $validationError['errnumb'] >>> il numero di campi non compilati
// - $validationError[$column] >>> il nome dei campi non compilati
// - $validationError['message'] il messaggio da stampare nel form sotto il campo da compilare
// Vengono passati:
// - $requiredColumns con i nomi degli input required
// - $userFormData con i dati raccolti dal form
function formValidation($requiredColumns, $userFormData) {
    
    $i = 0;
    $validationError = [];
    foreach ($requiredColumns as $column) {
        
        if (empty($userFormData[$column])) {
            $i++;
            $validationError[$column] = true;
            $validationError['message'] = 'Compila questo campo!';
            $validationError['errnumb'] = $i; 
        }
    }
    return $validationError;
}
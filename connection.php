<?php
// Assegna a $config i parametri di configurazione della 
// connessione al db contenuti nell'array presente in 'config.php' 
$config = require 'config.php';
// Effettua la connessione al db attraverso i parametri presenti in $config
$mysqli = new mysqli($config['mysql_host'], $config['mysql_user'], $config['mysql_password'], $config['mysql_dbname']);
// La variabile '$config' viene eliminata una volta che 
// è stata utilizzata per la connessione al db dall'oggetto $mysqli
// Questo per evitare di ritrovarla in altri punti del progetto
unset($config);

// SE la connessione non è andata a buon fine 
// ALLORA stampa 'Connessione non riuscita' e l'errore restituito
if (isset($mysqli->connect_error)) {
    echo 'Connessione non riuscita';
    die($mysqli->connect_error);
}
<?php
// Crea un nuovo utente nella tabella 'utenti' del database
function userCreate($userData, mysqli $conn) {
    $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES ('{$userData['nome']}', '{$userData['cognome']}', '{$userData['email']}', '{$userData['password']}')";

    $result = [
        'success' => true,
        'affected_rows' => false,
        'error' => '',
        'sql' => '',
        'userId' => '',
    ];

    $res = $conn->query($sql);

    if ($res) {
        $result['affected_rows'] = $conn->affected_rows;
        $result['userId'] = $conn->insert_id;
    } else {
        $result['success'] = false;
        $result['error'] = $conn->error;
        $result['sql'] = $sql;
    }
    return $result;
}

function getUserByEmail($userEmail) {
    $conn = $GLOBALS['mysqli'];
    $sql = "SELECT * FROM utenti WHERE utenti.email LIKE '$userEmail'";

    $res = $conn->query($sql);

    // SE c'è una risposta ('$res') alla query
    if ($res) {
        // Pusha in '$records' ogni '$row' estratta dalla risposta 
        // '$res' del db alla query, FINCHE' non ce ne sono più
        // while ($row = $res->fetch_assoc()) {
        //     $records[] = $row;
        // }
        $user = $res->fetch_assoc();
    }
    return $user;
}
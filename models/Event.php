<?php
// Restituisce un array con gli eventi associati 
// all'email che le viene passata
function getEventsByUserEmail($userEmail) {
    $events = [];
    $conn = $GLOBALS['mysqli'];
    $sql = "SELECT * FROM eventi WHERE eventi.attendees LIKE '%$userEmail%'";

    $res = $conn->query($sql);

    // SE c'è una risposta ('$res') alla query
    // restituisce un array ($user) con i dati dell'utente per cui si è passata l'email
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $events[] = $row;
        }
    }
    return $events;
}
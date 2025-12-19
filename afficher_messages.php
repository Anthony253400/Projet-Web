<?php
session_start();
require_once('bd.php');


try {
    $bdd = getBD('toto');

    $suppr = $bdd->query("
        DELETE from messages WHERE heure_envoie < (NOW()-INTERVAL 10 MINUTE)
    ");

    $stmt = $bdd->query("
        SELECT m.id_message, m.contenu, m.heure_envoie, c.prenom AS client
        FROM messages m
        JOIN clients c ON m.id_client = c.id_client
        ORDER BY m.heure_envoie ASC
    ");


    
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'messages' => $messages]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

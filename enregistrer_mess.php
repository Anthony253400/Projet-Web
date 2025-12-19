<?php
session_start();
require_once('bd.php');

if(!isset($_POST['message']) ){
    echo json_encode(['success' => false, 'message' => 'Message non envoyer']);
    exit;
}
if(!isset($_SESSION['client']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté']);
    exit;
}
if (strlen($message) > 256) {
    echo json_encode(['success' => false, 'message' => 'Le message ne peut pas dépasser 256 caractères']);
    exit;
}
// TOKEN

if(isset($_POST['token'])){
    if ($_POST['token'] != $_SESSION['token']){
        echo json_encode(['success' => false, 'message' => 'Csrf']);
        exit;
    }
}

$message = $_POST['message'] ?? ''; 
$bdd = getBD('toto');

 
if (!empty($message)) {

    $stmt = $bdd->prepare("INSERT INTO messages (id_client, contenu, heure_envoie) VALUES (:id_client, :contenu, NOW())");
    $stmt->execute([':id_client' => $_SESSION['client']['id'],':contenu'   => $message]);
    echo json_encode(['success' => true, 'message' => 'message envoyer']);
    exit;
}else{
    echo json_encode(['success' => false, 'message' => 'Message non envoyer']);
    exit;
}

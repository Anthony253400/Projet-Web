<?php
session_start();
require_once('bd.php');

if(!isset($_POST['email']) || !isset($_POST['mdp1'])){
    header("Location: index.php");
    exit;
}

$email = $_POST['email'] ?? ''; 
$mdp1  = $_POST['mdp1'] ?? '';

if (!empty($email) && !empty($mdp1)) {
    $bdd = getBD('toto');

    $stmt = $bdd->prepare("SELECT * FROM clients WHERE mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp1, $user['mdp'])) {
        $_SESSION['client'] = ['id' => $user['id_client'], 'id_stripe' => $user['id_client_stripe'] ,'email' => $user['mail'],'nom' => $user['nom'],'prenom' => $user['prenom'],'adresse' => $user['adresse']];

        // TOKEN
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }

          echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Mot de passe ou identifiant invalide']);
         exit;
        }
  } else {
    echo json_encode(['success' => false, 'message' => 'Champs vide']);
    exit;
}
?>

<?php
session_start();
require_once('bd.php'); 
require_once('stripe.php');

header('Content-Type: application/json');

try {
    $bdd = getBD('toto'); 

    $nom = $_POST['nom'] ?? '';
     $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $tel = $_POST['num'] ??  '';
    $mail = $_POST['email'] ?? '';
    $mdp1 = $_POST['mdp1'] ?? '';
    $mdp2 = $_POST['mdp2'] ?? '';

    




    if (empty($nom) || empty($prenom) || empty($mail) || empty($mdp1) || empty($mdp2)) {
        echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        exit;
    }

    if ($mdp1 !== $mdp2) {
        echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas.']);
        exit;
    }

    $stmt = $bdd->prepare("SELECT id_client FROM clients WHERE mail = ?");
    $stmt->execute([$mail]);

    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
        exit;
    }

    // STRIPE
    $customer = $stripe->customers->create([
        'name' => $nom." ".$prenom,
        'email' => $mail,
        //'address' => $adresse,
        'phone' => $tel
    ]);



    $stripe_id = $customer->id;  



    $hash = password_hash($mdp1, PASSWORD_DEFAULT);
    $stmt = $bdd->prepare("INSERT INTO clients (nom, prenom, adresse, numero, mail, mdp , id_client_stripe) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $adresse, $tel, $mail, $hash ,$stripe_id ]);

    $stmt = $bdd->prepare("SELECT id_client FROM clients WHERE mail = ?");
    $stmt->execute([$mail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['client'] = [
         'id' => $user['id_client'],
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $mail ,
        'id_stripe' =>$stripe_id 

    ];

    // TOKEN
    if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
    };

    echo json_encode(['success' => TRUE, 'message' => 'Comptte creer !!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()]);
    //echo ';)';
    exit;
}
?>
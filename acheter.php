<?php
session_start();
require_once 'bd.php'; 


if (!isset($_SESSION['client'] )){
    $message = "Vous n'etes pas connecter ";
    

}
else{

$bdd = getBD('toto');



if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    $message = "Votre panier est vide.";
    
}
if (!isset($_GET['token']) || !isset($_SESSION['token_achat']) || $_SESSION['token_achat'] != $_GET['token']) {
    $message = "NON NON NON ";
   

}
else{

try {
    $bdd->beginTransaction();

$sql = "INSERT INTO Commandes (id_art, id_client, quantite, envoi)
        VALUES (:id_art, :id_client, :quantite, FALSE)";
$stmt = $bdd->prepare($sql);

$sql_update_articles = "UPDATE articles SET quantite = quantite - :quantite WHERE id_art = :id_art";
$stmt_update = $bdd->prepare($sql_update_articles);
$articles_supprimes=[];

$tampon_sql = "DELETE FROM commandes_tampon WHERE id_art = :id_art AND id_client = :id_client";
$tampon = $bdd->prepare($tampon_sql);

foreach ($_SESSION['panier'] as $index => $article) {
     $verif = $bdd->prepare("SELECT quantite FROM articles WHERE id_art = ?");
    $verif->execute([$article['id']]);
    $result = $verif->fetch(PDO::FETCH_ASSOC);



    if ($article['quantite'] > $result['quantite']) {   
        unset($_SESSION['panier'][$index]);
                $articles_supprimes[] = $article['nom'];
                continue;
    }
    $stmt->execute([
        ':id_art' => $article['id'],
        ':id_client' => $_SESSION['client']['id'],
        ':quantite' => $article['quantite']
    ]);
    $stmt_update->execute([
        ':quantite' => $article['quantite'],
        ':id_art' => $article['id']
    ]);

    $tampon->execute([
        ':id_art' => $article['id'],
        ':id_client'=> $_SESSION['client']['id']
    ]);
    


}


    $bdd->commit();
     if (empty($_SESSION['panier'])) {
            unset($_SESSION['panier']);
        }

    if  (!empty($articles_supprimes)) {
         $message = "Votre commande a été enregistrée, mais les articles suivants ont été retirés car leur stock était insuffisant :  "; 
         foreach ($article as $articles_supprimes){
            echo $article;
         }
    } else {
            $message = "Votre commande a bien été enregistrée.";
        }

    unset($_SESSION['panier']);
    unset($_SESSION['token_achat']);


} catch (Exception  $e) {
    if ($bdd->inTransaction()) {
        $bdd->rollBack();
    }
    $message = $e->getMessage()  ;}

}
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Validation Commandes</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <?php echo $message; ?>

    <a href="index.php"> <div class="bloc">Retour à l'acceuil</div> </a>
    
</body>
</html>
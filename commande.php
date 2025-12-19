<?php
session_start();
if (!isset($_SESSION['client']) && empty($_SESSION['client']['adresse'])) {
    header('Location: connexion.php');
    exit();
}

if (!isset($_SESSION['panier']) ||
    !is_array($_SESSION['panier']) ||
    empty($_SESSION['panier']) ||
    !isset($_SESSION['panier'][0]['id']) ||
    empty($_SESSION['panier'][0]['id'])) {
    header('Location: pannier.php');
    exit();
}else {
    $message = "Votre Panier";}

$panier = $_SESSION['panier'];
$total_commande = 0;


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <p> Récapitulatif de votre commande :</p>
    
        <div class="panier">
        
            <?php
        foreach ($panier as $article) {
    $id = $article['id_art'];
    $nom = $article['nom'];
    $prix = $article['prix'];
    $quantite = $article['quantite'];
    $total_article = $prix * $quantite;
    $total_commande += $total_article;
    $stripe = $article['id_stripe'];
        $price = $article['id_price'];

    ?>
    
    <div class="panier-article">
        <div class="panier-details">
            <a href="PageArticles/article.php?id_art=<?php echo $id; ?>">
                <p class='titre'><?php echo $nom; ?></p>
            </a>
            <p>Prix : <?php echo number_format($prix, 2, ',', ' '); ?> €</p>
            <p>Quantité : <?php echo $quantite; ?></p>
            <p>Total : <?php echo number_format($total_article, 2, ',', ' '); ?> €</p>


        </div>
    </div>
    <?php
}    ?>
   
<p>Montant total de votre commande : <?php echo number_format($total_commande, 2, ',', ' '); ?> €</p>

        
             <p> La commande sera expédiée à l’adresse suivante : </p>
            <p> <?php echo $_SESSION['client']['adresse']; ?> </p>
    

             <?php
            
            ?>
            </div>
            <?php

    ?>


<form action="commande_v2.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="submit" class="bloc Grand">Valider la commande</button>
</form>

<a href="pannier.php"> <div class="bloc Footer">   Retour au pannier </div> </a> 

    


    
</body>
</html>
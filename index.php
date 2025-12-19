
<?php
session_start();
require_once 'bd.php';

$bdd = getBD('toto');

$stmt = $bdd->query("SELECT 
        a.nom, 
        a.prix, 
        a.quantite, 
        a.url_photo, 
        a.id_art,
        COALESCE(AVG(c.note), 0) AS moyenne_note
    FROM 
        articles a
    LEFT JOIN 
        commentaire c ON a.id_art = c.id_art
    GROUP BY 
        a.id_art
    ORDER BY 
        moyenne_note DESC, 
        a.nom ASC");
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Toto</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>  
  


<!-- ===== NAVBAR ===== -->
<?php include 'navbar.php'; ?>

<!-- ===== BLOCS ===== -->
<?php 
if (isset($_SESSION['client'] ) ){
    echo 'Bonjour '.$_SESSION['client']['nom'];

}
?>
<div class="container">
<?php
    while ($produit = $stmt->fetch(PDO::FETCH_ASSOC)) {
      
        ?>
        
        <a href="PageArticles/article.php?id_art=<?php echo $produit['id_art']; ?>">
        
            <div class="bloc">
              <p class="nom"></p>
                <img src="<?php echo $produit['url_photo']; ?>" alt="<?php echo $produit['nom']; ?>">
                <p class="nom"><?php echo $produit['nom']; ?></p>
                <p> Note : <?php echo $produit['moyenne_note']; ?></p>
                <p class="prix"><?php echo number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                <p class="stock"><?php echo $produit['quantite']; ?> en stock</p>
                <p class="ref">ref: <?php echo $produit['id_art']; ?></p>
            </div>
        </a>
        <?php
    }
?>
</div>



<?php include 'chat.php'; ?>















<!-- ===== FOOTER
  ===== -->

  <footer>
     <a href="contact/contact.php"><div class="bloc Footer">Contactez-moi</div></a>

  </footer>

</body>
</html>
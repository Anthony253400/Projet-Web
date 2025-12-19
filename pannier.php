<?php
session_start();
require_once 'bd.php';

try {
    $bd = getBD('toto');
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

if (!isset($_SESSION['client'])) {
    header('Location: connexion.php');
    exit();
}

// Vérifie si le panier existe et contient des articles
if (!isset($_SESSION['panier']) || !is_array($_SESSION['panier']) || empty($_SESSION['panier'])) {
    $message = "Votre panier est vide";
}else {
    $message = "Votre Panier";}

$panier = $_SESSION['panier'];
$total_commande = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon panier</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<h5> <?php echo $message ?> </h5>


<div class="panier">

<?php
foreach ($panier as $article) {
    $id = intval($article['id']);
    $quantite = intval($article['quantite']);

    $stmt = $bd->prepare("SELECT nom, prix , url_photo FROM articles WHERE id_art = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $nom = $result['nom'];
        $prix = $result['prix'];
        $url_photo = $result['url_photo'];

        $total_article = $prix * $quantite;
        $total_commande += $total_article;

    ?>
        <div class="panier-article">
            <div class="panier-image" >
                <a href="PageArticles/article.php?id_art=<?php echo $id; ?>">
                <img src="<?php echo $url_photo ?>" alt=<?php echo $nom ?> > </a>
            </div>
            <div class="panier-details">
                <a href="PageArticles/article.php?id_art=<?php echo $id; ?>"><p class='titre'> <?php echo ($nom) ?> </p></a>
                <p></p>
                <p>Prix : <?php echo number_format($prix, 2, ',', ' ') ?> €</p>
                <p>Quantité : <?php echo $quantite; ?></p>
                <p>Total : <?php echo number_format($total_article, 2, ',', ' ') ?> €</p>

                <form method="post" action="supprimer_article.php">
                    <input type="hidden" name='token' value = "<?php echo $_SESSION['token']; ?>"> 
                    <input type="hidden" name="index" value="<?php echo $article['id']; ?>">
                    <button type="submit" class="bloc Footer"> <img src="images/pobelle.png"> </button>
                </form>
                
            </div>
        </div>             
    <?php
    }
}
?>

<div class="panier-total ">
    <p>Total de la commande</p>
    <p><?php echo number_format($total_commande, 2, ',', ' '); ?> €</p>


</div>


<?php
if (isset($_SESSION['panier']) || !empty($_SESSION['panier'])) {
?>

<a href="commande.php" > <div class="bloc Grand"> Passer	la	commande  </div></a>
<?php }
?>


</div>

<a href="index.php" > <div class="bloc Footer"> Retourner à la boutique  </div></a>
</html>

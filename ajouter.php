<?php   
session_start();

require_once 'bd.php';
$valide = FALSE;


if ( isset($_POST['quantite'], $_POST['id_art'], $_POST['token'])  && ctype_digit($_POST['quantite']) && ctype_digit($_POST['id_art'])    ) {
    $quantite = intval($_POST['quantite']);
    $id_art = intval($_POST['id_art']);
    $token = $_POST['token'];

    $bd = getBD('toto');
    $stmt = $bd->prepare("SELECT * FROM articles WHERE id_art = ?");
    $stmt->execute([$id_art]); 
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if(  $quantite > $result['quantite']){
        $message = "Quantité demandée non disponible.";
          
    }else{

        if (!isset($_SESSION['token']) || $_SESSION['token']!= $token) {
            $message = "Requête invalide.";
        } else {
        
            if ( !isset($_SESSION['panier'])     ) {
            $_SESSION['panier'] = array(array('id' => $id_art , 'id_stripe' => $result['id_stripe']  ,'id_price' => $result['id_price']  , 'quantite' => $quantite , 'nom' => $result['nom'] , 'prix' => $result['prix'] ));
            $message = "Article ajouté au panier";
            $valide = TRUE;
            }else{
                // verifier pas doubler
            array_push($_SESSION['panier'], array('id' => $id_art, 'id_stripe' => $result['id_stripe'] ,'id_price' => $result['id_price']  ,'quantite' => $quantite , 'nom' => $result['nom'] , 'prix' => $result['prix'] ));
            $message = "Article ajouté au panier";
            $valide = TRUE;}}}

        }else{
    $message = "Erreur lors de l'ajout au panier";
}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Ajouter</title>
</head>
<body>

<?php include 'navbar.php';?>

<?php


print_r($message); 

if (isset($_POST['id_art']) && ctype_digit($_POST['id_art'])  && $valide == FALSE )
    echo '<meta http-equiv="refresh" content="1;url=PageArticles/article.php?id_art='.$_POST['id_art'].'">';
else{
    echo '<meta http-equiv="refresh" content="1;url=index.php">';
}?>

    
</body>
</html>
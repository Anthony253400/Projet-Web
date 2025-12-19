
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('vendor/autoload.php');
require_once('stripe.php');
require_once('bd.php');
require_once ('verif_tampon.php'); 




if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 $message =  'probleme de methode';
}

 if ($_SESSION['token']!= $_POST['token'] ){
    $message = "Une erreur est survenue";
 }
 else{

$liste = array();
foreach ($_SESSION['panier'] as $article) {
    array_push($liste , array('price' => $article['id_price'], 'quantity' => $article['quantite']));
}

$token = bin2hex(random_bytes(16));
$_SESSION['token_achat'] = $token;

$bdd = getBD('toto');
verif_bd_tampon();


try {
    $panier = $_SESSION['panier'];

    //quantite dans le stock
    foreach ($_SESSION['panier'] as  $index => $article) {
    $verif = $bdd->prepare("SELECT quantite FROM articles WHERE id_art = ?");
    $verif->execute([$article['id']]);
    $stock = $verif->fetch(PDO::FETCH_ASSOC);

    //quantite dans le stock tampon
    $req = $bdd->prepare("SELECT SUM(quantite) AS total_quantite FROM commandes_tampon WHERE id_art = ? ");
    $req->execute([$article['id']]);
    $result = $req->fetch(PDO::FETCH_ASSOC);  
    $tampon = $result['total_quantite'] ?? 0;
    


    //verif stock -stock tampon
    if ($article['quantite'] > $stock['quantite']- $tampon) {  
        unset($_SESSION['panier'][$index]);
        
        }
    }

    if (count($_SESSION['panier']) !== count($panier)) {
        header('Location: pannier.php?stock_insuffisant=1');
        exit();
    }

    foreach ($_SESSION['panier'] as $article) {
        $tampon = $bdd->prepare("
            INSERT INTO commandes_tampon (id_art, id_client, quantite, envoi)
            VALUES (:id_art, :id_client, :quantite, FALSE)
        ");
        $tampon->execute([
            ':id_art' => $article['id'],
            ':id_client' => $_SESSION['client']['id'],
            ':quantite' => $article['quantite']
        ]);
    }


    




    $checkout_session = $stripe->checkout->sessions->create([
        'customer' => $_SESSION['client']['id_stripe'],
        'success_url' => 'http://localhost/MIRANDA/acheter.php?token='.$token,
        'cancel_url' => 'http://localhost/MIRANDA/pannier.php?err=1',
        'mode' => 'payment',
        'automatic_tax' => ['enabled' => false],
        'line_items' => $liste,
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    

} catch (\Stripe\Exception\ApiErrorException $e) {
    $message = "tripe";
    echo "Erreur Stripe : " . $e->getMessage();
    
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $message ; ?>
</body>
</html>
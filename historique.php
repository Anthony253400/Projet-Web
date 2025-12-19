<?php
session_start();
require_once 'bd.php';

$bdd = getBD('toto');

if (!isset($_SESSION['client'])) {
    echo "Veuillez vous connecter pour consulter votre historique.";
    echo "<br><a href='login.php'>Se connecter</a>";
    exit;
}

$idClient = $_SESSION['client']['id'];

try {
    // Requête pour récupérer les commandes du client avec les détails de l’article
    $sql = "
        SELECT 
            c.id_commande,
            c.id_art,
            a.nom AS nom_article,
            a.prix,
            c.quantite,
            c.envoi
        FROM Commandes c
        INNER JOIN Articles a ON c.id_art = a.id_art
        WHERE c.id_client = :id_client
        ORDER BY c.id_commande DESC
    ";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([':id_client' => $idClient]);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">

    <title>Historique des commandes</title>
</head>
<body>
<?php include 'navbar.php'; ?>

<h5>Historique de vos commandes</h2>

<?php if (count($commandes) > 0): ?>
<table>
    <tr>
        <th>ID Commande</th>
        <th>ID Article</th>
        <th>Nom de l'article</th>
        <th>Prix unitaire (€)</th>
        <th>Quantité</th>
        <th>État de la commande</th>
    </tr>
    <?php foreach ($commandes as $cmd): ?>
    <tr>
        <td><?= htmlspecialchars($cmd['id_commande']) ?></td>
        <td><?= htmlspecialchars($cmd['id_art']) ?></td>
        <td><?= htmlspecialchars($cmd['nom_article']) ?></td>
        <td><?= htmlspecialchars(number_format($cmd['prix'], 2)) ?></td>
        <td><?= htmlspecialchars($cmd['quantite']) ?></td>
        <td class="<?= $cmd['envoi'] ? 'true' : 'false' ?>">
            <?= $cmd['envoi'] ? 'Envoyée' : 'En attente' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p style="text-align:center;">Vous n'avez encore passé aucune commande.</p>
<?php endif; ?>

<a href="compte.php"> <div class="bloc">Retour à mon compte</div> </a>
</body>
</html>
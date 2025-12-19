<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Compte</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<?php include 'navbar.php'; ?>

<?php echo $_SESSION['client']['prenom']; ?>
 <?php echo $_SESSION['client']['nom']; ?>

 <a href="historique.php"> <div class="bloc centre">Historique des commandes </div></a>

 <a href="deconnexion.php"> <div class="bloc centre">Se déconnecter </div></a>


</body>
</html>
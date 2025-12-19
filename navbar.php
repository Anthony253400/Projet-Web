<?php
session_start();
$base = '/MIRANDA'; 
?>


<nav class="navbar">
  <div class="nav-gauche">
    <img src="<?php echo $base; ?>/images/TotoLogo.png" alt="Image gauche">
  </div>
  
  <div class="nav-center">
    <a href="<?php echo $base; ?>/index.php">
      <span>Toto</span>
    </a>
  </div>
    
  <div class="nav-droite">
<?php
    if (isset($_SESSION['client'])) {?>
        <a href="<?php echo $base; ?>/pannier.php"><img src="<?php echo $base; ?>/images/PannierLogo.png" alt="PannierLogo"></a>
    <a href="<?php echo $base; ?>/nouveau.php"><img src="<?php echo $base; ?>/images/CompteLogo.png" alt="CompteLogo"></a>
    <?php } else { ?>
    <a href="<?php echo $base; ?>/connexion.php"><div class="bloc connexion">Se connecter</div></a>
    <?php }
    ?>
  </div>
</nav>

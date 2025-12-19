<?php 
session_start();
if (isset($_SESSION['client'])){
    header("Location: compte.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style/style.css">
<title>Nouveau</title>
</head>
<body>
<?php include 'navbar.php'; ?>

<h1 id="creercompte">Créer un nouveau compte</h1>

<form id= 'form-nouveau' method="post" autocomplete="off">
  <p>Nom :
    <input id="nom" class="champ" type="text"  name="nom" data-error="err-nom" value="<?php echo $_GET['nom'] ?? '' ?>"/>
    <div class="logo"></div>
    <div id="err-nom" class="err"></div>
  </p>

  <p>Prénom :
    <input id="prenom" class="champ" type="text" name="prenom" data-error="err-prenom" value="<?php echo $_GET['prenom'] ?? '' ?>"/>
    <div class="logo"></div>
    <div id="err-prenom" class="err"></div>
  </p>

  <p>Adresse :
    <input id="adresse" class="champ" type="text" name="adresse" data-error="err-adresse" value="<?php echo $_GET['adresse'] ?? '' ?>"/>
    <div class="logo"></div>
    <div id="err-adresse" class="err"></div>
  </p>

  <p>Numéro de téléphone :
    <input id="tel" class="champ"  type="text" name="num" data-error="err-tel" value="<?php echo $_GET['num'] ?? '' ?>"/>
    <div class="logo"></div>
    <div id="err-tel" class="err"></div>
  </p>

  <p>Adresse e-mail :
    <input id="mail" class="champ" type="text" name="email" data-error="err-mail" value="<?php echo $_GET['email'] ?? '' ?>"/>
    <div class="logo"></div>
    <div id="err-mail" class="err"></div>
  </p>

  <p>Mot de passe :
    <input id="mdp1" class="champ" type="password" name="mdp1" data-error="err-mdp1" value=""/>
    <div class="logo"></div>
    <div id="err-mdp1" class="err"></div>
  </p>

  <p>Confirmer votre mot de passe :
    <input id="mdp2" class="champ" type="password" name="mdp2" data-error="err-mdp2" value=""/>
    <div class="logo"></div>
    <div id="err-mdp2" class="err"></div>
  </p>

  <p><input id="envoyer" type="submit" value="S'inscrire"></p>
</form>

<div id="message"></div>
<div id="image_valid"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function(){

  function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }

  function validatePassword(mdp) { 
    // Il faut suppr les espaces
    const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&._-]).{6,}$/;
    return regex.test(mdp);
  }

  function Valid() {
    let valid = true;

    $('.champ').each(function() {
      const $input = $(this);
      const id = $input.attr('id');
      const value = $input.val().trim();
      const $logo = $input.siblings('.logo')

      //pas de moi 
      const $err = $('#' + $input.data('error')); //permet de viser #err-...

      


      if (value === "") {
        $err.text("Champ vide");
        $logo.css('background-image', 'url("images/faux.png")');
        $input.css('background-color', '#ee5f5fff');
        valid = false;
        return true;
      } else {
        $err.text("");
        $logo.css('background-image', 'url("images/vrai.png")');
        $input.css('background-color', '#7dcb7dff');
      }
    
      if (id === "tel") {
        const telRegex = /^\d{10}$/; 
        if (!telRegex.test(value)) {
                 $err.text("Numéro invalide (10 chiffres requis)");
                 $logo.css('background-image', 'url("images/faux.png")');
                 $input.css('background-color', '#ee5f5f');
                  valid = false;
             } else {
              $err.text("");
              $logo.css('background-image', 'url("images/vrai.png")');
               $input.css('background-color', '#7dcb7d');
              }
        }

      if (id === "mail") {
        if (!validateEmail(value)) {
          $err.text("Email invalide");
          $logo.css('background-image', 'url("images/faux.png")');
          $input.css('background-color', '#ee5f5fff');
          valid = false;
        } else {
          $.ajax({
            url: "mail.php?mail=" + encodeURIComponent(value),
            success: function(result){
              if (result == 1) {
                $err.text("Email déjà existant");
                $logo.css('background-image', 'url("images/faux.png")');;
                $input.css('background-color', '#ee5f5fff');
              } else {
                $err.text("");
                $logo.css('background-image', 'url("images/vrai.png")');
                $input.css('background-color', '#7dcb7dff');
              }
            }
          });
        }
      }

      if (id === "mdp1" && !validatePassword(value)) {
        $err.text("Mot de passe : min 6 caractères, 1 lettre, 1 chiffre, 1 symbole.");
        $logo.css('background-image', 'url("images/faux.png")');
        $input.css('background-color', '#ee5f5fff');
        valid = false;
      }

      if (id === "mdp2" && value !== $('#mdp1').val()) {
        $err.text("Les mots de passe ne correspondent pas");
        $logo.css('background-image', 'url("images/faux.png")');
        $input.css('background-color', '#ee5f5fff');
        valid = false;
      }

    });

    $('#envoyer').prop('disabled', !valid);
  }

  


  $('.champ').on('input', Valid);
  Valid();


  $("#form-nouveau").on("submit", function(e) {
    e.preventDefault();
    Valid();

    if ($("#envoyer").is(":disabled")) {
      $("#message").css("color", "red").text("Veuillez corriger les erreurs avant de continuer.");
      return;
    }

    $.ajax({
      url: "enregistrement.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(reponse) {
        if (reponse.success) {
          $("form").css('display', 'none');
          $("h1").css('display', 'none');
          $("#message").css("font-size", "3rem").text("Compte créé avec succès !");
          $("#image_valid").css('background-image', 'url("images/vrai.png")');
        

          setTimeout(() => { window.location.href = "index.php"; }, 2000);
        } else {
          $("#message").css("color", "red").text(reponse.message);
        }
      },
      error: function() {
        $("#message").css("color", "red").text("Erreur serveur — réessayez plus tard.");
      }
    });

  });

});


</script>

</body>
</html>

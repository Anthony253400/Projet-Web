<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">

    <title>Connexion</title>
</head>
<body>
    <?php include 'navbar.php'; ?>


<h1 id="creercompte">Se connecter à un compte</h1>

<form id="connexion" method="post" autocomplete="off">
    <p>
        Adresse e-mail :
        <input id="mail" type="text" name="email" value="<?php echo $_GET['email'] ?? '' ?>"/>
    </p>
    <p>
        Mot de passe :
        <input type="password" name="mdp1" value=""/>
    </p>
    <div id="message-err"></div>
    <p>
        <input id="envoyer" type="submit" value="Se connecter">
    </p>
    <p class="bloc"><a href="nouveau.php"> Nouveau client ! </a></p>
</form>
<div id="message"></div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
<script>
$(document).ready(function(){
    $("#connexion").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "connecter.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(reponse) {
                if (reponse.success) {
                    $("form").hide();
                    $("h1").hide();
                    $("#message").css("font-size", "2rem").text("Connecté !");
                    setTimeout(() => { window.location.href = "index.php"; }, 2000);
                } else {
                    $("#message-err").css("color", "red").text(reponse.message);
                }
            },
            error: function() {
                $("#message-err").css("color", "red").text("Problemes");
            }
        });
    });
});
</script>


</body>
</html>


<?php
require_once 'bd.php';


function enregistrer($nomBD, $nomTable , $nom, $prenom, $adresse,  $num ,$email, $mdp) {
    $bdd = getBD($nomBD);
    $stmt = $bdd->prepare("INSERT INTO ".$nomTable." (  nom, prenom, adresse, numero, mail, mdp) VALUES (?, ?, ?, ?, ?, ?)");
    
    $mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);
    
    $stmt->execute([$nom, $prenom, $adresse, $num, $email, $mdp_hache]);
}

?>  



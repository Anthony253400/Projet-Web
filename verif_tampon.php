<?php
require_once 'bd.php'; 


function verif_bd_tampon() {
    $bdd = getBD('toto');


$del = $bdd->prepare("DELETE FROM commandes_tampon WHERE time < (NOW() - INTERVAL 2 MINUTE)");
$del->execute();

}
?>

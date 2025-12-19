<?php
session_start();

if (isset($_POST['index']) && isset($_SESSION['panier'][$_POST['index']]) && isset($_SESSION['client'], $_SESSION['token'] , $_POST['token'])) {
    if ($_SESSION['token'] != $_POST('token')){
        header("Location: pannier.php");
        exit;

    }else{
    
    $index = intval($_POST['index']);
    unset($_SESSION['panier'][$index]);}
} 

header("Location: pannier.php");
exit;

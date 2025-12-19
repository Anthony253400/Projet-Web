<?php
require_once 'bd.php';
if ( isset($_GET['mail'] ) ){

    $mail = $_GET['mail']; 

    $bd = getBD('toto');
      $stmt = $bd->prepare("SELECT COUNT(*) FROM clients WHERE mail = ?");
      $stmt->execute([$mail]);
      $res = $stmt->fetchColumn();

      if ($res > 0) {
          echo '1';

      }else{
        echo '0' ; 
      }  


}
?>
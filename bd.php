<?php
    function getBD($dbName){
        $host = 'localhost';
        $port = '3306';
        $dbname = $dbName;
        $user = 'root';
        $pass = 'root';

        try {
            $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",$user,$pass);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $bdd;


        } catch (PDOException $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }
}
?>
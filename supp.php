<?php
    $bdd = new PDO('mysql:host=localhost; dbname=scanIp',"root","root");

    if (isset($_POST['nom-supp']))
        $nom = $_POST['nom-supp'];


    $requete = "DELETE FROM cameras WHERE name = '".$nom."'";
    $reponse = $bdd->query($requete);

$reponse->closeCursor();

if ($bdd) {
    $bdd = NULL;
}
?>

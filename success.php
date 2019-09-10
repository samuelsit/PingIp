<?php
    $bdd = new PDO('mysql:host=localhost; dbname=scanIp',"root","root");

    if (isset($_POST['nom']))
        $nom = $_POST['nom'];
    if (isset($_POST['adresse']))
        $adresse = $_POST['adresse'];


    $requete = "INSERT INTO cameras (name, address) VALUES (\"$nom\", \"$adresse\")";
    $reponse = $bdd->query($requete);

$reponse->closeCursor();

if ($bdd) {
    $bdd = NULL;
}
?>

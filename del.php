<?php
    $bdd = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');


    if (isset($_POST['id-supp']))
        $id = $_POST['id-supp'];


    $requete = "DELETE FROM cameras WHERE id = '".$id."'";
    $reponse = $bdd->query($requete);

$reponse->closeCursor();

if ($bdd) {
    $bdd = NULL;
}
header('Location: scan.php');

?>

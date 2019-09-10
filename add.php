<?php
    $bdd = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');


    if (isset($_POST['nom']))
        $nom = $_POST['nom'];
    if (isset($_POST['adresse']))
        $adresse = $_POST['adresse'];
    if (isset($_POST['port']))
        $port = $_POST['port'];

            $req = $bdd->query('SELECT id FROM cameras WHERE address = "'.$_POST['adresse'].'" AND port = "'.$_POST['port'].'"');
            $resultat = $req->fetch();
            if (!$resultat)
            {
                $requete = "INSERT INTO cameras (name, address, port) VALUES (\"$nom\", \"$adresse\", \"$port\")";
                $reponse = $bdd->query($requete);

                $reponse->closeCursor();

                if ($bdd) {
                    $bdd = NULL;
                }
                header('Location: scan.php');
            }
            else
                header('Location: scan.php');




?>

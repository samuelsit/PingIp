<?php
    $db = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');


    if (isset($_POST['nom']))
        $nom = $_POST['nom'];
    if (isset($_POST['groupe']))
        $groupe = $_POST['groupe'];
    if (isset($_POST['adresse']))
        $adresse = $_POST['adresse'];
    if (isset($_POST['port']))
        $port = $_POST['port'];

            $req = $db->query('SELECT id FROM cameras WHERE address = "'.$_POST['adresse'].'" AND port = "'.$_POST['port'].'"');
            $resultat = $req->fetch();
            if (!$resultat)
            {
                $reponse = $db->query("INSERT INTO cameras (name, groups, address, port) VALUES (\"$nom\", \"$groupe\", \"$adresse\", \"$port\")");

                $reponse->closeCursor();

                if ($bdd) {
                    $bdd = NULL;
                }
                header('Location: display.php');
            }
            else
                header('Location: display.php');

?>

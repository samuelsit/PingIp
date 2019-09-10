<?php
    $bdd = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');

    if (isset($_POST['pseudo']) && isset($_POST['pass']))
    {
        $req = $bdd->query('SELECT id FROM user WHERE username = "'.$_POST['pseudo'].'" AND passwd = "'.$_POST['pass'].'"');
        $resultat = $req->fetch();
        if (!$resultat)
        {
            echo '<script language="JavaScript">
            window.location.replace("index.php");
            alert("Login ou mot de passe incorrect. Merci de recommencer.");
            </script>';
        }
        else
            header('Location: scan.php');
    }
?>

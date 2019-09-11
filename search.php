<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>ScanIp</title>
        <link rel="shortcut icon" href="images/ico.png"/>
        <link rel="stylesheet" type="text/css" href="css/input.css" media="screen" />
        <meta name="robots" content="noindex">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container p-2">
            <div class="text-center bg-light">
                    <a href="display.php" class="btn btn-lg btn-dark">Retourner à l'accueil</a>
            </div>
        </div>
        <?php
			session_start();
			if (!isset($_SESSION['pseudo']) || !isset($_SESSION['pass'])) {
				echo '<script language="JavaScript">
	            window.location.replace("index.php");
	            alert("Variable de session non definies.");
	            </script>';
			}
			$db = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');
		?>
        <div class="container-fluid">
            <div class="shadow-lg p-3 mb-5 bg-white rounded">
                <div class="container mb-3">
                <form id="form-search" method="post" action="search.php">
                  <div class="form-row">
                    <div class="col">
                      <input id="login" type="text" class="form-control" value="<?php if ( isset($_POST['id-search']) ) echo htmlentities($_POST['id-search']) ?>" placeholder="Entrez un nom" name="id-search">
                    </div>
                    <button type="submit" class="btn btn-dark" id="submit-search">Rechercher</button>
                  </div>
                </form>
                </div>
                <table class="table table-sm table-dark border border-dark">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">NOM</th>
                      <th scope="col">GROUPE</th>
                      <th scope="col">ADRESSE</th>
                      <th scope="col">STATUT</th>
                      <?php
                        if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
                            echo '<th scope="col">ON/OFF</th>';
                        }
                          ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['id-search']))
                        $_SESSION['search'] = $_POST['id-search'];
                    if (isset($_SESSION['search'])) {
                        $req_data = $db->query('SELECT * FROM cameras WHERE name LIKE "'.$_SESSION['search'].'%" ORDER BY groups DESC');
                        while ($donnees = $req_data->fetch()) {
                            $color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
                            $status = $donnees['status'] == 1 ? 'ON' : 'OFF';
                            echo '<tr class="'.$color.'">';
                            echo '<th scope="row">'.$donnees['id'].'</th>';
                            echo '<td>'.$donnees['name'].'</td>';
                            echo '<td>'.$donnees['groups'].'</td>';
                            echo '<td>'.$donnees['address'].'</td>';
                            echo '<td>'.$status.'</td>';
                            if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
                                echo '<td><form method="post" action="switch.php"><input type="hidden" name="onoff" value="'.$donnees['id']."+".$_POST['id-search'].'"></input><button type="submit" class="btn btn-dark"></button></form></td>';
}
                            echo '</tr>';
                        }
                    }
                    else if (isset($_POST['id-search'])) {
                        $req_data = $db->query('SELECT * FROM cameras WHERE name LIKE "'.$_POST['id-search'].'%" ORDER BY groups DESC');
                        while ($donnees = $req_data->fetch()) {
                            $color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
                            $status = $donnees['status'] == 1 ? 'ON' : 'OFF';
                            echo '<tr class="'.$color.'">';
                            echo '<th scope="row">'.$donnees['id'].'</th>';
                            echo '<td>'.$donnees['name'].'</td>';
                            echo '<td>'.$donnees['groups'].'</td>';
                            echo '<td>'.$donnees['address'].'</td>';
                            echo '<td>'.$status.'</td>';
                            if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
                                echo '<td><form method="post" action="switch.php"><input type="hidden" name="onoff" value="'.$donnees['id']."+".$_POST['id-search'].'"></input><button type="submit" class="btn btn-dark"></button></form></td>';
                            }
                            echo '</tr>';
                        }
                    }
                    else {
                        $req_data = $db->query('SELECT * FROM cameras ORDER BY groups DESC');
                        while ($donnees = $req_data->fetch()) {
                            $color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
                            $status = $donnees['status'] == 1 ? 'ON' : 'OFF';
                            echo '<tr class="'.$color.'">';
                            echo '<th scope="row">'.$donnees['id'].'</th>';
                            echo '<td>'.$donnees['name'].'</td>';
                            echo '<td>'.$donnees['groups'].'</td>';
                            echo '<td>'.$donnees['address'].'</td>';
                            echo '<td>'.$status.'</td>';
                            if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
                                echo '<td><form method="post" action="switch.php"><input type="hidden" name="onoff" value="'.$donnees['id'].'"></input><button type="submit" class="btn btn-dark"></button></form></td>';
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="text-center mb-3">
				<a href="disconect.php" class="btn btn-lg btn-dark">Se déconnecter</a>
		</div>
    </body>
</html>

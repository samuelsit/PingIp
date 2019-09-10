<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Eye-Tech | Scan IP</title>
		<link rel="shortcut icon" href="images/ico.png"/>
		<meta name="robots" content="noindex">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body class="bg-light">
		<script type="text/javascript">
			var x = document.referrer;
			if ((x != "https://www.xavsit.fr/") && (x != "https://www.xavsit.fr/scan.php")) {
				alert("Identifiez-vous !");
				document.location.href="https://www.xavsit.fr/";
			}
		</script>
		<?php
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', -1);
			$db = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');
			$ip = array();
			$req_ip = "SELECT address FROM `cameras`";
			foreach  ($db->query($req_ip) as $row) {
				    $ip[] = $row['address'];
			}
			foreach ($ip as $key) {
				$req_port = 'SELECT port FROM cameras WHERE address = "'.$key.'"';
				$query = $db->query($req_port);
				$port = $query->fetch();
			//	echo "<p>ip = ".$key." sur le port ".$port['port']."</p>";
				$connection = @fsockopen($key, $port['port'], $errno, $errstr, 2);
			    if (is_resource($connection))
			    {
					$req_stat = 'UPDATE cameras SET status = 1 WHERE address = "'.$key.'"';
					$reponse = $db->query($req_stat);
			    }
			    else
			    {
					$req_stat = 'UPDATE cameras SET status = 0 WHERE address = "'.$key.'"';
					$reponse = $db->query($req_stat);
			    }
			}
		?>

		<div class="container-fluid mt-3">
			<div class="row">
				<div class="p-3 mb-5 bg-white rounded col">
					<h2 class="text-center text-dark">AJOUTER UN DVR :</h2>
					<form method="post" action="add.php" id="form-data">
					  <div class="form-row">
					    <div class="col">
					      <input type="text" class="form-control" placeholder="Nom" name="nom">
					    </div>
					    <div class="col">
					      <input type="text" class="form-control" placeholder="Adresse" name="adresse">
					    </div>
						<div class="col">
					      <input type="text" value="37777" class="form-control" placeholder="Port" name="port">
					    </div>
						<button type="submit" class="btn btn-dark" id="submit">Ajouter</button>
					  </div>
					</form>
				</div>
				<div class="p-3 mb-5 bg-white rounded col">
					<h2 class="text-center text-dark">SUPPRIMER UN DVR :</h2>
					<form method="post" action="del.php" id="form-data-supp">
					  <div class="form-row">
					    <div class="col">
					      <input type="text" class="form-control" placeholder="Id" name="id-supp">
					    </div>
						<button type="submit" class="btn btn-dark" id="submit-supp">Supprimer</button>
					  </div>
					</form>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="shadow-lg p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">EFFECTUER UNE RECHERCHE :</h2>
				<div class="container mb-3">
				<form id="form-search" method="post">
				  <div class="form-row">
					<div class="col">
					  <input type="text" class="form-control" value="<?php if ( isset($_POST['id-search']) ) echo htmlentities($_POST['id-search']) ?>" placeholder="Entrez un nom" name="id-search">
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
				      <th scope="col">ADRESSE</th>
					  <th scope="col">PORT</th>
				      <th scope="col">STATUT</th>
				    </tr>
				  </thead>
				  <tbody>
					<?php
					if (isset($_POST['id-search'])) {
						$req_data = $db->query('SELECT * FROM cameras WHERE name LIKE "'.$_POST['id-search'].'%"');
						while ($donnees = $req_data->fetch()) {
							$color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
							$status = $donnees['status'] == 1 ? 'ON' : 'OFF';
					    	echo '<tr class="'.$color.'">';
					      	echo '<th scope="row">'.$donnees['id'].'</th>';
					      	echo '<td>'.$donnees['name'].'</td>';
					      	echo '<td>'.$donnees['address'].'</td>';
							echo '<td>'.$donnees['port'].'</td>';
					      	echo '<td>'.$status.'</td>';
					    	echo '</tr>';
						}
					}
					?>
				  </tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid">
			<div class="shadow-lg p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">DVR OFF :</h2>
				<table class="table table-sm table-dark border border-dark">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">NOM</th>
				      <th scope="col">ADRESSE</th>
					  <th scope="col">PORT</th>
				      <th scope="col">STATUT</th>
				    </tr>
				  </thead>
				  <tbody>
					<?php
						$req_data = $db->query('SELECT * FROM cameras WHERE status = 0');
						while ($donnees = $req_data->fetch()) {
							$color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
							$status = $donnees['status'] == 1 ? 'ON' : 'OFF';
					    	echo '<tr class="'.$color.'">';
					      	echo '<th scope="row">'.$donnees['id'].'</th>';
					      	echo '<td>'.$donnees['name'].'</td>';
					      	echo '<td>'.$donnees['address'].'</td>';
							echo '<td>'.$donnees['port'].'</td>';
					      	echo '<td>'.$status.'</td>';
					    	echo '</tr>';
						}
					?>
				  </tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid">
			<div class="shadow-lg p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">DVR ON :</h2>
				<table class="table table-sm table-dark border border-dark">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">NOM</th>
				      <th scope="col">ADRESSE</th>
					  <th scope="col">PORT</th>
				      <th scope="col">STATUT</th>
				    </tr>
				  </thead>
				  <tbody>
					<?php
						$req_data = $db->query('SELECT * FROM cameras WHERE status = 1');
						while ($donnees = $req_data->fetch()) {
							$color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
							$status = $donnees['status'] == 1 ? 'ON' : 'OFF';
					    	echo '<tr class="'.$color.'">';
					      	echo '<th scope="row">'.$donnees['id'].'</th>';
					      	echo '<td>'.$donnees['name'].'</td>';
					      	echo '<td>'.$donnees['address'].'</td>';
							echo '<td>'.$donnees['port'].'</td>';
					      	echo '<td>'.$status.'</td>';
					    	echo '</tr>';
						}
					?>
				  </tbody>
				</table>
			</div>
		</div>
	</body>
</html>

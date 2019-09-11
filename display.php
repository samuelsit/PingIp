<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Eye-Tech | Scan IP</title>
		<link rel="shortcut icon" href="images/ico.png"/>
		<meta name="robots" content="noindex">
		<link rel="stylesheet" type="text/css" href="css/input.css" media="screen" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body class="bg-light">
		<script type="text/javascript">
			var x = document.referrer;
			if ((x != "https://www.xavsit.fr/") && (x != "https://www.xavsit.fr/display.php") && (x != "https://www.xavsit.fr/search.php") && (x != "https://www.xavsit.fr/index.php")) {
				alert("Identifiez-vous !");
				document.location.href="https://www.xavsit.fr/";
			}
		</script>
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
		<div class="container bg-white shadow rounded mt-3 text-center">
			<?php
				if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
						echo '<div class="p-3 rounded">';
							echo '<form method="post" action="add.php" id="form-data">';
								echo '<div class="row">';
									echo '<div class="col">';
										echo '<input type="text" class="form-control" placeholder="Nom" name="nom">';
									echo '</div>';
									echo '<div class="col">';
										echo '<input type="text" class="form-control" placeholder="Groupe" name="groupe">';
									echo '</div>';
									echo '<div class="col">';
										echo '<input type="text" class="form-control" placeholder="Adresse" name="adresse">';
									echo '</div>';
									echo '<div class="col">';
										echo '<input type="text" value="37777" class="form-control" placeholder="Port" name="port">';
									echo '</div>';
									echo '<div class="col">';
										echo '<button type="submit" class="btn btn-dark" id="submit">Ajouter</button>';
									echo '</div>';
								echo '</div>';
							echo '</form>';
						echo '</div>'; } ?>
						<hr>
							  <div class="p-3 rounded">
								  <div class="row">
									  <div class="col">
										  <form id="form-search" method="post" action="search.php">
											  <div class="row">
												  <div class="col">
										  	  		<input type="text" class="form-control" value="<?php if ( isset($_POST['id-search']) ) echo htmlentities($_POST['id-search']) ?>" placeholder="Nom" name="id-search">
												  </div>
												  <div class="col">
													  <button type="submit" class="btn btn-dark text-left" id="submit-search">Rechercher</button>
												  </div>
											  </div>
										  </form>
									  </div>
			<?php
				if ($_SESSION['pseudo'] == "xavier" || $_SESSION['pseudo'] == "david") {
						echo '<div class="col">';
							echo '<form method="post" action="del.php" id="form-data-supp">';
								echo '<div class="row">';
									echo '<div class="col">';
										echo '<input type="text" class="form-control" placeholder="ID" name="id-supp">';
									echo '</div>';
									echo '<div class="col">';
										echo '<button type="submit" class="btn btn-dark" id="submit-supp">Supprimer</button>';
									echo '</div>';
								echo '</div>';
							echo '</form>';
						echo '</div>';
				}
			?>
									</div>
								</div>
								<hr>
				<div class="container p-3 mb-3">
					<div class="text-center">
							<a href="scan.php" class="btn btn-lg btn-dark">Scan</a>
					</div>
				</div>
		</div>
		<div class="container-fluid">
			<div class="shadow-lg p-3 mb-3 bg-white rounded">
				<h2 class="text-center text-dark">DVR OFF : <?php $req_nboff = $db->query('SELECT COUNT(status) FROM cameras WHERE status = 0');
				 												$nboff = $req_nboff->fetch();
																echo $nboff[0];?></h2>
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
						  echo '<th scope="col">ON</th>';
					  }
						  ?>
				    </tr>
				  </thead>
				  <tbody>
					<?php
						$req_data = $db->query('SELECT * FROM cameras WHERE status = 0 ORDER BY groups DESC');
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
					?>
				  </tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid">
			<div class="shadow-lg p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">DVR ON : <?php $req_nbon = $db->query('SELECT COUNT(status) FROM cameras WHERE status = 1');
				 												$nbon = $req_nbon->fetch();
																echo $nbon[0];?></h2>
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
						   echo '<th scope="col">OFF</th>';
					   }

 ?>
				    </tr>
				  </thead>
				  <tbody>
					<?php
						$req_data = $db->query('SELECT * FROM cameras WHERE status = 1 ORDER BY groups DESC');
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

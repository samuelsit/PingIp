<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Eye-Tech | Scan IP</title>
		<link rel="shortcut icon" href="images/ico.png"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body class="bg-light">
		<?php
			$db = new PDO('mysql:host=localhost;dbname=scanIp', "root", "root");
			$ip = array();
			$req_ip = "SELECT address FROM `cameras`";
			foreach  ($db->query($req_ip) as $row) {
				    $ip[] = $row['address'];
			}
			foreach ($ip as $key) {
				exec("ping -c 1 $key", $array, $result);
				if (!$result) {
					$req_stat = 'UPDATE cameras SET status = 1 WHERE address = "'.$key.'"';
					$reponse = $db->query($req_stat);
				}
				else {
					$req_stat = 'UPDATE cameras SET status = 0 WHERE address = "'.$key.'"';
					$reponse = $db->query($req_stat);
				}
			}
		?>

		<div class="container mt-3 text-center">
			<img src="images/ico.png" class="img-thumbnail">
		</div>
		<div class="container-fluid mt-3">
			<div class="shadow p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">AJOUTER UNE CAMÉRA :</h2>
				<form method="post" id="form-data">
				  <div class="form-row">
				    <div class="col">
				      <input type="text" class="form-control" placeholder="Nom" name="nom">
				    </div>
				    <div class="col">
				      <input type="text" class="form-control" placeholder="Adresse" name="adresse">
				    </div>
					<a href="#" class="btn btn-dark" id="submit">Ajouter</a>
				  </div>
				</form>
			</div>
		</div>
		<div class="container-fluid mt-3">
			<div class="shadow p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">SUPPRIMER UNE CAMÉRA :</h2>
				<form method="post" id="form-data-supp">
				  <div class="form-row">
				    <div class="col">
				      <input type="text" class="form-control" placeholder="Nom" name="nom-supp">
				    </div>
					<a href="#" class="btn btn-dark" id="submit-supp">Supprimer</a>
				  </div>
				</form>
			</div>
		</div>
		<div class="container-fluid mt-3">
			<div class="shadow-lg p-3 mb-5 bg-white rounded">
				<h2 class="text-center text-dark">CAMÉRAS ENREGISTRÉES :</h2>
				<table class="table table-sm table-dark border border-dark">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">NOM</th>
				      <th scope="col">ADRESSE</th>
				      <th scope="col">STATUT</th>
				    </tr>
				  </thead>
				  <tbody>
					<?php
						$req_data = $db->query('SELECT * FROM cameras');
						while ($donnees = $req_data->fetch()) {
							$color = $donnees['status'] == 1 ? 'bg-success' : 'bg-danger';
							$status = $donnees['status'] == 1 ? 'ON' : 'OFF';
					    	echo '<tr class="'.$color.'">';
					      	echo '<th scope="row">'.$donnees['id'].'</th>';
					      	echo '<td>'.$donnees['name'].'</td>';
					      	echo '<td>'.$donnees['address'].'</td>';
					      	echo '<td>'.$status.'</td>';
					    	echo '</tr>';
						}
					?>
				  </tbody>
				</table>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#submit").click(function(e) {
					e.preventDefault();
					$.ajax({
						url:'success.php',
						method:'post',
						data: $("#form-data").serialize(),
					});
					return true;
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#submit-supp").click(function(e) {
					e.preventDefault();
					$.ajax({
						url:'supp.php',
						method:'post',
						data: $("#form-data-supp").serialize(),
					});
					return true;
				});
			});
		</script>
	</body>
</html>

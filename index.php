<?php
$user = "root";
$pass = "Kerrigan";
$db = new PDO('mysql:host=192.168.99.100:8081;dbname=scanIp;charset=UTF-8', $user, $pass);

$ipSQL = array();
$req = "SELECT adress FROM `cameras`";
foreach  ($db->query($req) as $row) {
	    $ipSQL[] = $row['adress'];
}
 
print_r($ipSQL);
 
$ping = exec("ping -n 1 google.com");

echo $ping;
?>

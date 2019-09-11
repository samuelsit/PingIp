<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');

$id = strstr($_POST['onoff'], '+', true);

//$search = substr(strstr($_POST['onoff'], '+'), 1);

$req_status = $db->query('SELECT status FROM cameras WHERE id = "'.$id.'"');
$donnee = $req_status->fetch();

//$_SESSION['search'] = $search;

if ($donnee[0] == 0) {
    $db->query('UPDATE cameras SET status = "1" WHERE id = "'.$id.'"');
}
else {
    $db->query('UPDATE cameras SET status = "0" WHERE id = "'.$id.'"');
}



header ('location: '.$_SERVER['HTTP_REFERER'].'');
?>

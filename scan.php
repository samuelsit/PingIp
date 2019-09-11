<?php
$db = new PDO('mysql:host=localhost;dbname=scanIp', 'root', 'root');

    ini_set('max_execution_time', 0);
    ini_set('memory_limit', -1);

    $ip = array();
    $req_ip = 'SELECT address FROM cameras WHERE address REGEXP "([0-9]{1,3}\.){3}[0-9]{1,3}"';
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
    header('Location: display.php');
?>

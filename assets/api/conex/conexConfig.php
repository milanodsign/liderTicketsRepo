<?php 
date_default_timezone_set('America/Bogota');
	
// $mysqli = new mysqli('localhost', 'root', 'Lm16541651lM', 'lidertickets');
$mysqli = new mysqli('localhost', 'hotshipi_liderti', 'Lm16541651lM', 'hotshipi_lidertickets_cl');


if ($mysqli->connect_errno) {

    echo "Lo sentimos, este sitio web está experimentando problemas.";

    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    

    exit;
}
?>
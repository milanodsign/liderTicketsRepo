<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');

$id = $_GET['id'];

$update = "UPDATE `ticketsSales` SET `status`=1 WHERE id= (SELECT MAX(id) FROM ticketsSales)";
$result = $mysqli->query($update);

if ($result) {
    $response = true;
} else {
    $response = false;
}

echo $response;

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
require('../conex/cors.php');
$id = $_GET['id'];
$sql = "SELECT * FROM `ticketsType` WHERE `id` = '" . $id . "'";
$result = $mysqli->query($sql);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {    
    $response[] = array(
        'price' => $row['price'],
        'desc' => $row['descriptionTickets'],
    );
};

echo json_encode($response);

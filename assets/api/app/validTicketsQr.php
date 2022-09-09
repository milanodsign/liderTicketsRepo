<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');

$codTicket = $_GET['codTicket'];
$sqlCourtesy = "SELECT * FROM `courtesyTickets` WHERE `codTicket` = '" . $codTicket . "'";
$resultCourtesy = $mysqli->query($sqlCourtesy);

// var_dump($resultCourtesy);

$sqlSales = "SELECT * FROM `ticketsSales` WHERE `codTicket` = '" . $codTicket . "'";
$resultSales = $mysqli->query($sqlSales);

$dateValidate = date('Y-m-d H:i:s');

if ($resultCourtesy) {
    $sqlAct = "UPDATE `courtesyTickets` SET `validated`= 1, `dateValidated`='" . $dateValidate . "' WHERE `codTicket` = '" . $codTicket . "'";
    $resultAct = $mysqli->query($sqlAct);
    while ($row = $resultCourtesy->fetch_array(MYSQLI_ASSOC)) {
        $response[] = $row;
    }
} else {
    $sqlAct = "UPDATE `ticketsSales` SET `validated`= 1, `dateValidated`='" . $dateValidate . "' WHERE `codTicket` = '" . $codTicket . "'";
    $resultAct = $mysqli->query($sqlAct);
    while ($row = $resultSales->fetch_array(MYSQLI_ASSOC)) {
        $response[] = $row;
    }
}



echo json_encode($response);

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');

$id = $_GET['idEvent'];
$cantTickets = 0;
$cantTicketsType = 0;

// total tickets event
$sqlTicketsEvent = "SELECT * FROM `ticketsType` WHERE `idEvent` = " . $id;
$resultTicketsEvent = $mysqli->query($sqlTicketsEvent);
while ($row = $resultTicketsEvent->fetch_array(MYSQLI_ASSOC)) {
    $cantTickets  +=  $row['cant'];
}

// total tickets sales & courtesy
$sqlCourtesy = "SELECT * FROM `courtesyTickets` WHERE `idEvent` = '" . $id . "'";
$resultCourtesy = $mysqli->query($sqlCourtesy);
$dataCourtesy = mysqli_num_rows($resultCourtesy);

$sqlSales = "SELECT * FROM `ticketsSales` WHERE `idEvent` = '" . $id . "'";
$resultSales = $mysqli->query($sqlSales);
$dataSales = mysqli_num_rows($resultSales);

// total tickets sales & courtesy valid
$sqlCourtesyValid = "SELECT * FROM `courtesyTickets` WHERE `idEvent` = " . $id . " AND `status`= 1";
$resultCourtesyValid = $mysqli->query($sqlCourtesyValid);
$dataCourtesyValid = mysqli_num_rows($resultCourtesyValid);

$sqlSalesValid = "SELECT * FROM `ticketsSales` WHERE `idEvent` = " . $id . " AND `status`= 1";
$resultSalesValid = $mysqli->query($sqlSalesValid);
$dataSalesValid = mysqli_num_rows($resultSalesValid);

$response[] = array(
    'cantTicketEvent' => $cantTickets,
    'totalCourtesy' => $dataCourtesy,
    'courtesyCountValid' => $dataCourtesyValid,
    'totalSales' => $dataSales,
    'salesCountValid' => $dataSalesValid,
);


echo json_encode($response);

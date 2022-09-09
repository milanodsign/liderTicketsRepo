<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');

$idEvent = $_GET['idEvent'];
$ticketType = $_GET['ticketType'];
$cant = $_GET['cant'];
$name = $_GET['name'];
$email = $_GET['email'];
$docType = $_GET['docType'];
$numDoc = $_GET['numDoc'];
$phone = $_GET['phone'];
$referencia = $_GET['referencia'];

// var_dump($referencia);exit();

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$codTicket = 'TS' . substr(str_shuffle($permitted_chars), 0, 10);
$shoppingDate = date('Y-m-d');
$shoppingTime = date('H:i:s');

$sql = "INSERT INTO `ticketsSales`(`id`, `idEvent`, `ticketType`, `cant`, `name`, `email`, `docType`, `numDoc`, `phone`, `shoppingDate`, `shoppingTime`, `codTicket`, `ref`, `payMethod`, `status`) VALUES (NULL, '" . $idEvent . "','" . $ticketType . "','" . $cant . "','" . $name . "','" . $email . "','" . $docType . "','" . $numDoc . "','" . $phone . "','" . $shoppingDate . "','" . $shoppingTime . "','" . $codTicket . "','" . $referencia . "','WOMPY',0)";
$saveBD = $mysqli->query($sql);

if ($saveBD == true) {
    $response = true;
} else {
    $response = false;
}

// echo json_encode($response);
echo $response;

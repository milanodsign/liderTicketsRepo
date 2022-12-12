<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../../conex/conexConfig.php');
require("../../../../lib/flow/FlowApi.class.php");

$referencia = $_POST['referencia'];
$idEvent = $_POST['idEvent'];
$cant = $_POST['cant'];
$idTickets = $_POST['idTickets'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$docType = $_POST['type'];
$numDoc = $_POST['numDoc'];
$porcentaje = $_POST['porcentaje'];

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

$shoppingDate = date('Y-m-d');
$shoppingTime = date('H:i:s');

$totalSale = 0;


foreach ($idTickets as $ticketType) {
    $sqlTickets = "SELECT * FROM `ticketsType` WHERE `id`= " . $ticketType;
    $resultTickets = $mysqli->query($sqlTickets);
    while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
        // var_dump($_POST);
        foreach ($cant as $quantity) {
            for ($i = 0; $i < $quantity; $i++) {
                $totalSale = $totalSale + $rowTickets['price'];
                $codTicket = 'TS' . substr(str_shuffle($permitted_chars), 0, 10);

                $sql = "INSERT INTO `ticketsSales`(`id`, `idEvent`, `ticketType`, `cant`, `name`, `email`, `docType`, `numDoc`, `phone`, `shoppingDate`, `shoppingTime`, `codTicket`, `ref`, `payMethod`, `status`) VALUES (NULL, '" . $idEvent . "','" . $ticketType . "','1','" . $name . "','" . $email . "','" . $docType . "','" . $numDoc . "','" . $phone . "','" . $shoppingDate . "','" . $shoppingTime . "','" . $codTicket . "','" . $referencia . "','WePay',0)";

                $result = $mysqli->query($sql);
            }
        }
    }
}
$amount = $totalSale + round($porcentaje);


//Para datos opcionales campo "optional" prepara un arreglo JSON
$optional = array(
	"rut" => $numDoc,
	"nombre" => $name
);
$optional = json_encode($optional);

//Prepara el arreglo de datos
$params = array(
	"commerceOrder" => $referencia,
	"subject" => "Lidertickets",
	"currency" => "CLP",
	"amount" => $amount,
	"email" => $email,
	"paymentMethod" => 1,
	"urlConfirmation" => Config::get("BASEURL") . "/api/php/tickets/payments/confirm.php",
	"urlReturn" => Config::get("BASEURL") ."/api/php/tickets/payments/confirm.php",
	"optional" => $optional
);
//Define el metodo a usar
$serviceName = "payment/create";

try {
	// Instancia la clase FlowApi
	$flowApi = new FlowApi;
	// Ejecuta el servicio
	$response = $flowApi->send($serviceName, $params,"POST");
	//Prepara url para redireccionar el browser del pagador
	// var_dump($response);exit();
	$redirect = $response["url"] . "?token=" . $response["token"];
	header("location:$redirect");
} catch (Exception $e) {
	echo $e->getCode() . " - " . $e->getMessage();
}

?>
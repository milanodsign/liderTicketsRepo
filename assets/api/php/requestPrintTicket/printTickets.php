<?php
require('../../conex/conexConfig.php');
require('../../conex/cors.php');
ob_start();
include('../../../lib/dompdf/autoload.inc.php');
include('../functions/fechaEs.php');;
$id = $_GET['id'];

$sql = "SELECT * FROM `requestPrintTickets` WHERE id = $id";
$result = $mysqli->query($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $idUser = $row['idUser'];
    $nomEvent = $row['nomEvent'];
    $ticketType = $row['ticketType'];
    $lugar = $row['lugar'];
    $dir = $row['dir'];
    $productora = $row['productora'];
    $numDoc = $row['numDoc'];
    $idEvent = $row['idEvent'];
    $fecha = $row['fecha'];
    $hora = $row['hora'];
    $descriptionTickets = $row['descriptionTickets'];
    $showPrice = $row['showPrice'];
    $priceTicket = $row['priceTicket'];
    $cant = $row['cant'];
    $imgTicket= $row['imgTicket'];

    if ($ticketType == 'c') {
        $nomTicketType = 'Cortesía';
        $price = 'Cortesía';
    } else {
        $sqlTT = "SELECT * FROM `ticketsType` WHERE `id`='" . $ticketType . "'";
        $resultTT = $mysqli->query($sqlTT);
        while ($rowTT = mysqli_fetch_assoc($resultTT)) {
            $nomTicketType = $rowTT['name'];
            $price = '$' . number_format($priceTicket);
        }
    }



    $sqlEvent = "SELECT * FROM `eventos` WHERE id = $idEvent";
    $resultEvent = $mysqli->query($sqlEvent);
    while ($rowEvent = mysqli_fetch_assoc($resultEvent)) {
        $lugar = $rowEvent['lugar'];
    }
}

require_once('plantilla.php');


$sqlUpdate = "UPDATE `requestPrintTickets` SET `status`=1 WHERE `id`='" . $id . "'";
$resultUpdate = $mysqli->query($sqlUpdate);

use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml(ob_get_clean());
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('lt', 'portrait');
// Render the HTML as PDF
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
// Output the generated PDF to Browser
$dompdf->stream($cant . ' Tickets- ' . $nomTicketType . ' de ' . $nomEvent . '.pdf');
?>

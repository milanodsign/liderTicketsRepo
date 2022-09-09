<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');

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

                $sql = "INSERT INTO `ticketsSales`(`id`, `idEvent`, `ticketType`, `cant`, `name`, `email`, `docType`, `numDoc`, `phone`, `shoppingDate`, `shoppingTime`, `codTicket`, `ref`, `payMethod`, `status`) VALUES (NULL, '" . $idEvent . "','" . $ticketType . "','1','" . $name . "','" . $email . "','" . $docType . "','" . $numDoc . "','" . $phone . "','" . $shoppingDate . "','" . $shoppingTime . "','" . $codTicket . "','" . $referencia . "','WOMPY',0)";

                $result = $mysqli->query($sql);
            }
        }
    }
}
$Total = $totalSale + $porcentaje;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../../img/favicon.png">
    <title>Lider Tickets - Wompi</title>
</head>

<body style="background: #20212b">

    <div>
        <form action="https://checkout.wompi.co/p/" method="GET">
            <!-- OBLIGATORIOS -->
            <input type="hidden" name="public-key" value="pub_prod_iVDk3rrRJX3jxgZJOFF4Gu9cbBaL8bNK" />
            <input type="hidden" name="currency" value="COP" />
            <input type="hidden" name="amount-in-cents" value="<?php echo $Total * 100 ?>" />
            <input type="hidden" name="reference" value="<?php echo $referencia ?>" />
            <!-- OPCIONALES -->
            <input type="hidden" name="redirect-url" value="https://lidertickets.co/assets/api/php/tickets/transactionResultLoged.php" />
            <input type="hidden" name="customer-data:email" value="<?php echo $email ?>" />
            <input type="hidden" name="customer-data:full-name" value="<?php echo $name ?>" />
            <input type="hidden" name="customer-data:phone-number" value="<?php echo $phone ?>" />
            <input type="hidden" name="customer-data:legal-id" value="<?php echo $numDoc ?>" />
            <input type="hidden" name="customer-data:legal-id-type" value="<?php echo $docType ?>" />
            <button id="toPay" style="display: none;" type="submit">Pagar con Wompi</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#toPay').click()
        });
    </script>

</body>

</html>
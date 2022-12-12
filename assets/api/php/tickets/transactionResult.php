<?php
require('../../conex/conexConfig.php');
require_once(dirname(__FILE__) . '../../../../../vendor/autoload.php');

$commerceCode = 597036125462;
$apiKeySecret = '9028c6db-9b11-442b-9313-0849740013a3';

$transaction = (new Transbank\TransaccionCompleta\Transaction())->configureForProduction($commerceCode, $apiKeySecret);

$token = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
$reference = $_GET['reference'] ?? $_POST['reference'] ?? null;

if (!$token) {
    header('Location: https://lidertickets.cl/pages/cancelTransaction.php', true, 302);
}

$response = $transaction->commit($token);

$responseEncode = json_encode($response);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../../img/favicon.png">
    <title>Lider Tickets - Transaction Result</title>
</head>

<body style="background: #20212b">
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(() => {
        getResponse()
    });

    const getResponse = () => {
        let idTransaction = '<?php echo $token ?>';
        let response = <?php echo $responseEncode ?>;
        let reference = '<?php echo $reference ?>';
        response.responseCode === 0 ? actStatus(`${reference}`, `${idTransaction}`) : window.location.href = "https://lidertickets.cl/pages/cancelTransaction.php"
    }

    const actStatus = (reference, id) => {
        $.ajax({
            url: "./actStatus.php?ref=" + reference + "&id=" + id,
            type: "get",
            dataType: "json",
        }).then(window.location.href = "https://lidertickets.cl/pages/successTransaction.php")
    }
</script>

</html>
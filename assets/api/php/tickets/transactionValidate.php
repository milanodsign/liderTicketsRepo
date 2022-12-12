<?php
$codTicket = $_POST['codTicket'];

$sql = "SELECT * FROM `ticketsSales` WHERE `codTicket` = '" . $codTicket . "'";
$response = $mysqli->query($sql);
while ($row = $response->fetch_array(MYSQLI_ASSOC)) {
    $idTransaction = $row['idTransaction'];
}
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

    const getResponse = async () => {
        let idTransaction = '<?php echo $idTransaction ?>'
        let respuesta = [];
        // await fetch('https://sandbox.webPay.co/v1/transactions/' + idTransaction)
        await fetch('https://production.webPay.co/v1/transactions/' + idTransaction)
            .then((response) => response.json())
            .then((result) => {
                respuesta = result
                respuesta.data.status === "APPROVED" ? actStatus(`respuesta.data.reference`, `<?php echo $_GET['id'] ?>`) : window.location.href = "https://lidertickets.co"
            })
            .catch((error) => {
                console.error("ERROR FOUND" + error);
            });
    }

    
</script>

</html>
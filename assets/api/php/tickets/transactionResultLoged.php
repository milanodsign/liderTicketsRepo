<?php
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
    // $(document).ready(() => {
    //     getResponse()
    // });

    // const getResponse = async () => {
    //     let idTransaction = '<?php echo $_GET['id'] ?>'
    //     let respuesta = [];
    //     await fetch('https://production.webPay.co/v1/transactions/' + idTransaction)
    //         .then((response) => response.json())
    //         .then((result) => {
    //             respuesta = result
    //             respuesta.data.status === "APPROVED" ? actStatus(`respuesta.data.reference`, `<?php echo $_GET['id'] ?>`) : window.location.href = "../../../../pages/eventsGrid.php"
    //         })
    //         .catch((error) => {
    //             console.error("ERROR FOUND" + error);
    //         });
    // }

    // const actStatus = async (reference, id) => {
    //     await $.ajax({
    //         url: "./actStatus.php?ref=" + reference + "&id=" + id,
    //         type: "get",
    //         dataType: "json",
    //     }).then(window.location.href = "../../../../pages/myTicketsSale.php")
    // }
</script>

</html>
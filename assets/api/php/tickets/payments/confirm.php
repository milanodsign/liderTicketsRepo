<?php

/**
 * Pagina del comercio para recibir la confirmación del pago
 * Flow notifica al comercio del pago efectuado
 */
require("../../../../lib/flow/FlowApi.class.php");

try {
	if (!isset($_POST["token"])) {
		throw new Exception("No se recibio el token", 1);
	}
	$token = filter_input(INPUT_POST, 'token');
	$params = array(
		"token" => $token
	);
	$serviceName = "payment/getStatus";
	$flowApi = new FlowApi();
	$response = $flowApi->send($serviceName, $params, "GET");
} catch (Exception $e) {
	echo "Error: " . $e->getCode() . " - " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="76x76" href="../../../../img/favicon.png">
	<link rel="icon" type="image/png" href="../../../../img/favicon.png">
	<title>Lider Tickets - Transaction Result</title>
</head>

<body style="background: #20212b">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
		$(document).ready(() => {
			getResponse()
		});

		const getResponse = async () => {
			let response = {};
			response = <?php echo json_encode($response); ?>;
			response.status === 2 ? actStatus(response.commerceOrder, `<?php echo $_POST["token"] ?>`) : window.location.href = "https://lidertickets.cl/pages/cancelTransaction.php"
		}

		const actStatus = (reference, id) => {
			$.ajax({
					url: "../actStatus.php?ref=" + reference + "&id=" + id,
					type: "get",
					dataType: "json",
				})
				.then(window.location.href = "https://lidertickets.cl/pages/successTransaction.php")
		}
	</script>
</body>

</html>
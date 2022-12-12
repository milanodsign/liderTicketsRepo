<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');

$idUser = $_POST['idUser'];
$nomEvent = $_POST['nomEvent'];
$ticketType = $_POST['tTicket'];
$showPrice = $_POST['showPrice'];
$lugar = $_POST['lugar'];
$dir = $_POST['dir'];
$productora = $_POST['prod'];
$numDoc = $_POST['numDoc'];
$idEvent = $_POST['idEvent'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$imgTicket = $_FILES['imgTicket']['name'];
$priceTicket = $_POST['priceTicket'];
$cant = $_POST['cant'];
$descriptionTickets = $_POST['desc'];


// var_dump($_POST);
// exit();

if (isset($imgTicket) && $imgTicket != "") {
    //Obtenemos algunos datos necesarios sobre el archivo
    $type = $_FILES['imgTicket']['type'];
    $tamano = $_FILES['imgTicket']['size'];
    $temp = $_FILES['imgTicket']['tmp_name'];
    //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
    if (!((strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")) && ($tamano < 2000000))) {
        echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
     - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
    } else {
        if (move_uploaded_file($temp, 'imgTicketPrint/' . $imgTicket)) {
            chmod('imgTicketPrint/' . $imgTicket, 0777);
            $ticketPrintImg = '/assets/api/php/requestPrintTicket/imgTicketPrint/' . $imgTicket;
        }
    }
}
else {
    $ticketPrintImg = "";
}

$txtSucces = 'La solicitud de impresión de ticket fue creada satisfactoriamente';
$txtError = 'La solicitud de impresión de ticket no pudo ser creada';
$title = "Solicitud de Impresión de ticket";

$sql = "INSERT INTO `requestPrintTickets`(`id`, `idUser`, `nomEvent`, `ticketType`, `lugar`, `dir`, `productora`, `numDoc`, `idEvent`, `fecha`, `hora`, `descriptionTickets`, `showPrice`, `priceTicket`, `cant`, `imgTicket`, `status`) VALUES (NULL, '" . $idUser . "', '" . $nomEvent . "', '" . $ticketType . "', '" . $lugar . "', '" . $dir . "', '" . $productora . "', '" . $numDoc . "', '" . $idEvent . "', '" . $fecha . "', '" . $hora . "', '" . $descriptionTickets . "', '" . $showPrice . "', '" . $priceTicket . "', '" . $cant . "', '" . $ticketPrintImg . "', 0)";
$response = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../img/favicon.png">
    <title>
        <?php echo $title ?> | Lidertickets
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../../css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../../css/nucleo-svg.css" rel="stylesheet" />
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../../css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link id="pagestyle" href="../../../css/custom.css" rel="stylesheet" />
</head>

<body class="registerSuccess">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <img class="logoRegister" src="../../../img/small-logos/Logo_Home_Svg.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div id="contentCard" class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <h1>
                                <?php
                                if ($response) {
                                    echo $txtSucces;
                                } else {
                                    echo $txtError;
                                } ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <?php include('../../../components/footer.php') ?>

    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <!--   Core JS Files   -->
    <script src="../../../js/core/popper.min.js"></script>
    <script src="../../../js/core/bootstrap.min.js"></script>
    <script src="../../../js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../../js/plugins/smooth-scrollbar.min.js"></script>
    <!-- jquery JS -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $(document).ready(function() {
            setTimeout(() => {
                location.href = "../../../../pages/printedTicketRequests.php";
            }, 3000);
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https:/buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../../js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="../../../js/custom.js"></script>
</body>

</html>
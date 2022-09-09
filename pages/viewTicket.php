<?php
$title = "Mi Ticket Cod." . $_GET['codTicket'];
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$inactivo = 900;
$codTicket = $_GET['codTicket'];

include('../assets/lib/phpqrcode/qrlib.php');
QRcode::png($codTicket, "../assets/api/php/temp/qrTickets.png", 'QR_ECLEVEL_Q', '10', '0');
$qrTickets = '<img src="https://lidertickets.hotshiping.co/assets/api/php/temp/qrTickets.png"/>';

if (isset($_SESSION['tiempo'])) {
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_destroy();
        header("Location: ../assets/api/conex/logout.php");
    }
}

$_SESSION['tiempo'] = time();
require '../assets/api/conex/conexConfig.php';
include('../assets/api/php/functions/fechaEs.php');
if ($_SESSION['userType'] == 0) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $eMailUser = $row['mail'];

        $sqlTickets = "SELECT * FROM `ticketsSales`  WHERE codTicket = '" . $codTicket . "'";
        $resultTickets = $mysqli->query($sqlTickets);
        while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
            $name = $rowTickets['name'];
            $email = $rowTickets['email'];
            $idEvent = $rowTickets['idEvent'];
            $idTicket = $rowTickets['ticketType'];
            $ref = $rowTickets['ref'];
        }
        $sqlTC = "SELECT * FROM `courtesyTickets`  WHERE codTicket = '" . $codTicket . "'";
        $resultTC = $mysqli->query($sqlTC);
        while ($rowTC = $resultTC->fetch_array(MYSQLI_ASSOC)) {
            $cortesia = $rowTC['wayPay'];
            $idEvent = $rowTC['idEvent'];
            $idTicket = $rowTC['ticketType'];
            $name = $rowTC['name'];
            $name = $rowTC['name'];
            $email = $rowTC['email'];
        }
        $sqlNomEvent = "SELECT * FROM `eventos` WHERE `id`= '" . $idEvent . "'";
        $resultNomEvent = $mysqli->query($sqlNomEvent);
        while ($rowEvents = $resultNomEvent->fetch_array(MYSQLI_ASSOC)) {
            $nomEvent = $rowEvents['nomEvent'];
            $fechaHora = fechaEs($rowEvents['fechaIni']) . ' - ' . date('h:i A', strtotime($rowEvents['horaIni']));
            $dir = $rowEvents['dir'] . ' / ' . $rowEvents['comuna'];
            $lugar = $rowEvents['lugar'];
            $flyer = 'https://lidertickets.co/' . $rowEvents['flyer'];
            $idProd = $rowEvents['idUser'];
        }
        $sqlTT = "SELECT * FROM `ticketsType` WHERE `id`= '" . $idTicket . "'";
        $resultTT = $mysqli->query($sqlTT);
        while ($rowTT = $resultTT->fetch_array(MYSQLI_ASSOC)) {
            $ticketName = $rowTT['name'];
            $ticketPrice = $rowTT['price'];
        }
        $sqlProd = "SELECT * FROM `producerData` WHERE `idUser`= '" . $idProd . "'";
        $resultProd = $mysqli->query($sqlProd);
        while ($rowProd = $resultProd->fetch_array(MYSQLI_ASSOC)) {
            $nomProd = $rowProd['nomProd'];
            $numDoc = $rowProd['numDoc'];
        }

?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
            <script>

            </script>
        </head>

        <body class="g-sidenav-show   bg-gray-100 ticketsList">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <div class="main-content position-relative max-height-vh-100 h-100">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->

                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="align-items-center card-header d-flex flex-column justify-content-between pb-0">
                                    <span class="d-flex justify-content-end w-100">
                                        <button class="btn btn-primary goBack" onClick="history.go(-1); return false;" title="Vovler Atras">
                                            <i class="fa-solid fa-backward-fast"></i>
                                        </button>
                                        <button class="btn btn-primary goBack" onClick="printHTML()" title="Imprimir ticket">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn btn-primary goBack" title="reenviar ticket">
                                        <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                        </button>
                                    </span>

                                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: none;" id="ticket">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:20px 60px; border-bottom:1px dotted #ccc;">
                                                    <center>
                                                        <h5>Asistente al evento</h5>
                                                    </center>
                                                    <h1 class="text-center">
                                                        <?php echo $name ?>
                                                    </h1>
                                                    <center>
                                                        <h2><?php echo $email ?></h2>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:20px 40px;  border-bottom:1px dotted #ccc;">
                                                    <table width="100%" height="172" border="0" cellpadding="10" cellspacing="0" class="micro-ticket">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" height="270" valign="top" align="center" style="vertical-align: initial;">
                                                                    <div class="center-block">
                                                                        <img src="<?php echo $flyer ?>" alt="<?php echo $nomEvent ?>" width="210" height="210" style="max-height: 210px; vertical-align: top;margin-bottom: 25px; margin-right: 30px;">
                                                                        <?php echo $qrTickets ?>

                                                                    </div>
                                                                    <p align="center" style="margin:0 0 0px 0 !important; font-size: 12px;">
                                                                        <b>No Escanear/No Scan</b>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: -10px !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="0" valign="top" style="text-align: center;">
                                                                                    <h1 class="text-center">
                                                                                        <?php echo $nomEvent ?>
                                                                                    </h1>
                                                                                    <h2 class="text-center">
                                                                                        <?php echo $ticketName ?>
                                                                                    </h2>
                                                                                    <h4>Los asientos serán asignados por orden
                                                                                        de Llegada.</h4>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: -30px !important ;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="0" valign="top" style="text-align: center;">
                                                                                    <p style="margin:0 0 5px 0 !important; font-size: 17px; color:red !important;">
                                                                                        Válido hasta: <?php echo $fechaHora ?>
                                                                                    </p>
                                                                                    <p style="margin:0 0 5px 0 !important; font-size: 17px;">
                                                                                        Cod. ticket: <?php echo $codTicket ?>
                                                                                    </p>
                                                                                    <p style="margin:0 0 5px 0 !important; font-size: 17px;">
                                                                                        Ref. compra:
                                                                                        <?php
                                                                                        if (isset($ref)) {
                                                                                            echo $ref;
                                                                                        } else {
                                                                                            echo 'Cortesía';
                                                                                        }
                                                                                        ?>
                                                                                    </p>
                                                                                    <p style="margin:0 0 5px 0 !important; font-size: 17px;">
                                                                                        Dónde:
                                                                                        <?php echo $lugar . ' / ' . $dir ?></p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:15px 40px; border-bottom:1px dotted #ccc;">
                                                    <h4 class="text-center">
                                                        Valor Cancelado:
                                                        <?php if (isset($cortesia)) {
                                                            echo 'Cortesía';
                                                        } else {
                                                            echo '$' . number_format($ticketPrice, 2);
                                                        }
                                                        ?> </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:15px 40px; border-bottom:1px dotted #ccc;">
                                                    <ul>
                                                        <li>
                                                            <p style="text-align:center;">Produce: <?php echo $nomProd ?></p>
                                                        </li>
                                                        <li>
                                                            <p style="text-align:center;">RUT Organizador: <?php echo $numDoc ?>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:20px 40px; border-bottom:1px dotted #ccc;">
                                                    <h4 class="text-center">Algunos consejos:</h4>
                                                    <ul>
                                                        <li>
                                                            <p style="text-align:center;">Recuerda presentar tu eTicket en el
                                                                acceso del evento con tu teléfono.</p>
                                                        </li>
                                                        <li>
                                                            <p style="text-align:center;">Siempre podrás acceder a tus compras o
                                                                eTickets desde nuestra web.</p>
                                                        </li>
                                                        <li>
                                                            <p style="text-align:center;">Recuerda llevar tus eTickets abiertos
                                                                en tu celular.</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>





                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include('../assets/components/footer.php') ?>
                </div>
            </div>

            <?php include('../assets/components/script.php') ?>
            <script>
                let win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    let options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }

                const printHTML = () => {
                    let element = document.getElementById('ticket')
                    if (window.print) {
                        window.print();
                    }
                }
            </script>
        </body>

        </html>
<?php
    }
}
?>
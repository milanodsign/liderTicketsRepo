<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');
include('../functions/fechaEs.php');

$idEvent = $_POST['idEvent'];
$ticketType = $_POST['ticketType'];
$ticketCant = $_POST['ticketCant'];
$name = $_POST['name'];
$email = $_POST['email'];
$fechaValid = $_POST['fechaValid'];
$horaValid = $_POST['horaValid'];

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$codTicket = 'TC' . substr(str_shuffle($permitted_chars), 0, 10);
$sendDate = date('Y-m-d');
$sendTime = date('H:i:s');

$sql = "INSERT INTO `courtesyTickets`(`id`, `idEvent`, `ticketType`, `ticketCant`, `name`, `email`, `fechaValid`, `horaValid`, `codTicket`, `sendDate`, `sendTime`, `wayPay`) VALUES (null, '" . $idEvent . "', '" . $ticketType . "', '" . $ticketCant . "', '" . $name . "', '" . $email . "', '" . $fechaValid . "', '" . $horaValid . "', '" . $codTicket . "', '" . $sendDate . "', '" . $sendTime . "', 'cortesia')";
$saveBD = $mysqli->query($sql);

$sqlEvents = "SELECT * FROM `eventos` WHERE `id`= " . $idEvent;
$resultEvents = $mysqli->query($sqlEvents);
while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
    $flayer = $rowEvents['flyer'];
    $nomEvent = $rowEvents['nomEvent'];
    $dir = $rowEvents['dir'];
    $lugar = $rowEvents['lugar'];
    $fechaIni = fechaEs($rowEvents['fechaIni']);
    $horaIni = $rowEvents['horaIni'];
}

$sqlTickets = "SELECT * FROM `ticketsType` WHERE `id`= " . $ticketType;
$resultTickets = $mysqli->query($sqlTickets);
while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
    $ticketName = $rowTickets['name'];
}


include_once '../../../lib/phpqrcode/qrlib.php';
$cont2 = $codTicket;
QRcode::png($cont2, "../temp/qrTickets.png", 'QR_ECLEVEL_Q', '10', '0');
$qrTickets = '<img src="https://lidertickets.hotshiping.co/assets/api/php/temp/qrTickets.png"/>';

if ($saveBD == true) {
    $para      = $email;
    $titulo    = '¡Tu entrada de cortesia está aquí! | Cod: ' . $codTicket;
    $mensaje   = '
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entrada de Cortesia</title>
    </head>
    
    <body>
        <div style="background:#1e1f29;color:#333;font-family:Lato,Arial,sans-serif;font-size:16px!important;line-height:1;text-align:center;min-width:100%">
            <div style="margin:0 auto;text-align:center">
    
                <img src="https://lidertickets.hotshiping.co/assets/img/small-logos/logoMail.png" alt="Lider Tickets"
                    border="0" style="margin:1.5rem 0" class="CToWUd">
            </div>
    
            <table cellpadding="0" cellspacing="0" align="center"
                style="width:640px;margin:0 auto">
                <tbody>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" align="center"
                                style="border-collapse:separate;border-spacing:0;overflow:hidden;text-align:center;width:100%">
    
                                <tbody>
                                    <tr>
                                        <td
                                            style="background:#fff;padding:0 16px;border-top-left-radius:5px;border-top-right-radius:5px">
                                            <h1 style="font-size:30px;font-weight:700">¡Qué envidia ' . $name . '!</h1>
    
                                            <p style="line-height:1.2">Gracias por confiar en nosotros, estas cerca de
                                                disfrutar de tu evento.<br>A continuación encontrarás el código de tu cupón    
                                                ¡Disfrútalo!</p>
    
                                        </td>
                                    </tr>
    
    
                                    <tr>
                                        <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="background:#fff;padding:0 16px">
                                            <table cellpadding="0" cellspacing="10"
                                                style="background:#f7f8f9;border:1px dashed #cecece;text-align:left;width:100%">
    
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-bottom:20px;text-align:center">
                                                            <div class="m_809902376527534251cupFoto"
                                                                style="display:inline-block;font-size:18px;font-weight:700;vertical-align:top;width:260px">
                                                                
                                                                <img src="https://lidertickets.hotshiping.co' . $flayer . '"
                                                                    alt="' . $nomEvent . '" style="width:260px;max-width:100%" class="CToWUd a6T">
                                                                <div class="a6S" dir="ltr" style="opacity: 0.01;">
                                                                    <div id=":2e2" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q"
                                                                        title="Descargar" role="button" tabindex="0"
                                                                        aria-label="Descargar el archivo adjunto "
                                                                        data-tooltip-class="a1V">
                                                                        <div class="akn">
                                                                            <div class="aSK J-J5-Ji aYr"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="m_809902376527534251cupProd"
                                                                style="display:inline-block;font-size:18px;font-weight:700;padding-left:15px;vertical-align:top;width:300px">
                                                                
                                                                <h2
                                                                    style="color:#0094de;font-size:20px;margin:0;padding-bottom:5px">
                                                                    ' . $nomEvent . '
                                                                </h2>
                                                                <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Lugar: 
                                                                    <strong>
                                                                        ' . $lugar . '
                                                                    </strong>
                                                                </span>
                                                                <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Dirección: 
                                                                    <strong>
                                                                        ' . $dir . '
                                                                    </strong>
                                                                </span>
                                                                <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Fecha: 
                                                                    <strong>
                                                                        ' . $fechaIni . '
                                                                    </strong>
                                                                </span>
                                                                <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Hora: 
                                                                    <strong>
                                                                        ' . date('h:i A', strtotime($horaIni)) . '
                                                                    </strong>
                                                                </span>
                                                                <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Ticket: 
                                                                    <strong>
                                                                        ' . $ticketName . '
                                                                    </strong>
                                                                </span>
                                                                
    
                                                                <img src="https://ci3.googleusercontent.com/proxy/IdvEMJeLZukZK8FRBmt3-P_rbLsnv-4dZNdc8dHBY2y6YEj1dOA2LUfNgwg2rrxvwPjEJGmw9Git9RzL-67dztcumzSflGUn6gNgvIYH8MTjMFyYpKianvzy8Sbbjvu6nGnqkXhUrB86hK-cGHxa1Q=s0-d-e1-ft#http://cuponassets.cuponatic-latam.com/front/frontendCo/images/cupon_html/valido-celularS.png"
                                                                    style="display: block;
                                                                    margin: 0 auto;
                                                                    margin-top: 1.5rem;" width="99"
                                                                    alt="Cupón válido en el celular" class="CToWUd">
                                                            </div>
                                                        </td>
                                                    </tr>
    
                                                    <tr>
    
                                                        <td style="padding-bottom:20px;text-align:center">
                                                            <div style="border:1px dotted #a4a4a4;margin:0 auto;text-align:center;vertical-align:top;width:100%, padding: 1.5rem 0;">
                                                            <img src="https://lidertickets.hotshiping.co/assets/api/php/temp/qrTickets.png" style="margin-bottom: 1.5rem"/>
                                                            <span style="display:block;font-size:26px;word-break:break-all">
                                                            ' . $codTicket . '
                                                            </span>
                                                            </div>
                                                        </td>
                                                    </tr>
    
                                                    <tr>
                                                        <td width="52%">&nbsp;</td>
    
                                                    </tr>
    
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="background:#fff;padding:0 16px">
                                            <hr style="background:#c4c4c4;border:0;height:8px">
                                            <p style="font-size:12px!important">¿Tienes alguna sugerencia, duda o consulta
                                                sobre nuestro servicio?
                                                Estaremos felices de ayudarte. Por favor escríbemos a <a
                                                    href="mailto:info@lidertickets.com" style="color:#333"
                                                    target="_blank">info@lidertickets.com</a> o llámanos al PBX
                                                0000000000.</p>
                                            <p><strong>¡Que tengas un día Lidertickets!</strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
    
                </tbody>
            </table>
        </div>
    </body>
    
    </html>';
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: LiderTickets.com <info@lidertickets.com>' . "\r\n";
    mail($para, $titulo, $mensaje, $cabeceras);

    $txtSucces = 'El Ticket de cortesia para ' . $nomEvent . ' fue enviado satisfactoriamente';
    $txtError = 'El Ticket no pudo ser enviado';

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../img/apple-icon.png">
        <link rel="icon" type="image/png" href="../../../img/favicon.png">
        <title>
            Tickets de Cortesia  | Lidertickets
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
                                    if ($saveBD) {
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
                    location.href = "../../../../pages/sendCourtesy.php?id=<?php echo $idEvent ?>&nomEvent=<?php echo $nomEvent ?>";
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

<?php
}
?>
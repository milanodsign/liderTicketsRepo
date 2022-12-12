<?php
$title = "Validador de QR";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
$inactivo = 900;
if (isset($_SESSION['tiempo'])) {
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_destroy();
        header("Location: ../assets/api/conex/logout.php");
    }
}

$_SESSION['tiempo'] = time();
require '../assets/api/conex/conexConfig.php';
require '../assets/api/conex/cors.php';
include('../assets/api/php/functions/fechaEs.php');
if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1 || $_SESSION['userType'] == 2) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($rowUser = $result->fetch_array(MYSQLI_ASSOC)) {
?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
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
                                <div class="align-items-center card-header d-flex justify-content-between pb-0">
                                    <h3><?php echo $title ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div id="reader" style="width:300px;height:300px; margin: 0 auto;">
                                        </div>
                                        <div id="resultado"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include('../assets/components/footer.php') ?>
                </div>
            </div>

            <?php include('../assets/components/script.php') ?>

            <script src="../assets/lib/html5_qrcode/html5-qrcode.min.js"></script>
            <script src="../assets/lib/html5_qrcode/jsqrcode-combined.min.js"></script>
            <script>
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }


                const valTicket = async (code) => {
                    await fetch(
                            `https://api.lidertickets.com/cl/tickets/validTicketsQr.php?codTicket=${code}`, {
                                method: "GET",
                                headers: {
                                    Accept: "application/json",
                                    "Content-Type": "application/json",
                                },
                            }
                        )
                        .then((response) => response.json())
                        .then((result) => {
                            console.log(result)
                            // $('#resultado').html('El ticket ha sido validado con éxito')
                            result[0].message === 1 ? $('#resultado').html('El ticket ha sido validado con éxito') : $('#resultado').html('El ticket no ha sido validado');
                        })
                        .catch((error) => {
                            console.error("ERROR FOUND" + error);
                        });
                }

                $(document).ready(function() {

                    function onScanSuccess(decodedText, decodedResult) {
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        let audio = new Audio('../assets/audio/beep.wav');
                        audio.play();
                        valTicket(decodedText)
                    }

                    var html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: 250
                        });
                    html5QrcodeScanner.render(onScanSuccess);


                });
            </script>
        </body>

        </html>
<?php
    }
}
?>
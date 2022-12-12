<?php
$title = "Reenviar Ticket Cod." . $_GET['codTicket'];
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
$inactivo = 900;
$codTicket = $_GET['codTicket'];
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
if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1 || $_SESSION['userType'] == 2) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($rowUser = $result->fetch_array(MYSQLI_ASSOC)) {
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $sqlSTS = 'SELECT * FROM `ticketsSales` WHERE `codTicket`="' . $codTicket . '"';
                                    $resultSTS = $mysqli->query($sqlSTS);
                                    while ($row = $resultSTS->fetch_array(MYSQLI_ASSOC)) {
                                        if (isset($row['codTicket'])) {
                                            $sqlE = 'SELECT * FROM `eventos` WHERE `id`="' . $row['idEvent'] . '"';
                                            $resultE = $mysqli->query($sqlE);
                                            while ($rowE = $resultE->fetch_array(MYSQLI_ASSOC)) {
                                                echo '<img src="' . $rowE['flyer'] . '" alt="" srcset="" style="width: 100%">';
                                            }
                                        } else {
                                            $sqlSTC = 'SELECT * FROM `courtesyTickets` WHERE `codTicket`="' . $codTicket . '"';
                                            $resultSTC = $mysqli->query($sqlSTC);
                                            while ($row = $resultSTC->fetch_array(MYSQLI_ASSOC)) {
                                                $sqlE = 'SELECT * FROM `eventos` WHERE `id`="' . $row['idEvent'] . '"';
                                                $resultE = $mysqli->query($sqlE);
                                                while ($rowE = $resultE->fetch_array(MYSQLI_ASSOC)) {
                                                    echo '<img src="' . $rowE['flyer'] . '" alt="" srcset="" style="width: 100%">';
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="margin-top: 15px">Reenviar Ticket</h4>
                                    <input type="hidden" name="" id="codTicket" value="<?php echo $codTicket ?>">
                                    <div class="col-md-12">
                                        <label for=""><span class="t_ubicacion">Nombre</span></label>
                                        <input class="form-control form-control-lg" type="text" id="name" />
                                    </div>
                                    <div class="col-md-12">
                                        <label for=""><span class="t_ubicacion">Correo Electrónico</span></label>
                                        <input class="form-control form-control-lg" type="email" id="email" />
                                    </div>
                                    <span class="d-flex justify-content-start w-100 mt-3">
                                        <button class="btn btn-primary goBack" onClick="history.go(-1); return false;" title="Volver Atras">
                                            <i class="fa-solid fa-backward-fast"></i>
                                        </button>
                                        <button class="btn btn-primary goBack" title="reenviar ticket" onClick="sendTicket()">
                                            <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                        </button>
                                    </span>
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
                const sendTicket = () => {
                    let codTicket = $("#codTicket").val();
                    let name = $("#name").val();
                    let email = $("#email").val();
                    $.ajax({
                        url: "../assets/api/php/tickets/sendTicket.php?codTicket=" + codTicket + "&name=" + name + "&email=" + email,
                        type: "get",
                        dataType: "json",
                    }).then(alert('El ticket fue enviado satisfactoriamente'),
                        history.go(-1), )
                }
            </script>
        </body>
        </html>
<?php
    }
}
?>
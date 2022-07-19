<?php
setlocale(LC_ALL, "es_ES");
$idEvent = $_GET['id'];
$nomEvent = $_GET['nomEvent'];
$title = "Crear tickets: " . $nomEvent;
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
include('../assets/api/php/functions/fechaEs.php');
if ($_SESSION['userType'] == 0) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php include('../assets/components/header.php') ?>
        </head>

        <body class="g-sidenav-show   bg-gray-100 ticketsCreate">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <div class="main-content position-relative max-height-vh-100 h-100">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM `eventos` WHERE `id`= " . $idEvent;
                        $result = $mysqli->query($sql);
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                            <div class="col-md-5">
                                <div class="card imgEvent">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h3><?php echo $title ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" action="" method="post">
                                            <input type="hidden" name="idEvent">
                                            <div class="form-group col-md-6">
                                                <label for="">Tipo de entrada</label>
                                                <select class="form-control form-control-lg" name="ticketType" id="ticketType">
                                                    <option value="">Seleccione</option>
                                                    <option value="0">Ticket Presencial</option>
                                                    <option value="1">Ticket Streaming</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Estado</label>
                                                <select class="form-control form-control-lg" name="estado" id="estado">
                                                    <option value="">Seleccione</option>
                                                    <option value="0">Activol</option>
                                                    <option value="1">Agotado</option>
                                                    <option value="2">Cortesía</option>
                                                    <option value="3">Cerrado</option>
                                                    <option value="4">Venta solo RRPP</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Nombre del ticket</label>
                                                <input class="form-control form-control-lg" type="text" name="name" id="name">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Descripción</label>
                                                <textarea name="descriptionTickets" id="" class="form-control form-control-lg"></textarea>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </div>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </div>
            <?php include('../assets/components/script.php') ?>
            <script>
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
            </script>
        </body>

        </html>
<?php
    }
}
?>
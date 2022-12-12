<?php
setlocale(LC_ALL, "es_ES");
$idEvent = $_GET['idEvent'];
$nomEvent = $_GET['nomEvent'];
$title = "Agregar base de datos: " . $nomEvent;
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
                        $sqlE = "SELECT * FROM `eventos` WHERE `id`= '" . $idEvent . "'";
                        $resultE = $mysqli->query($sqlE);
                        while ($rowEvent = $resultE->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                            <div class="col-md-4" style="max-width: 400px;max-height: 400px;box-sizing: border-box;padding: 0;">
                                <div class="card imgEvent" style="height: 100%;">
                                    <div class="card-body" style="background: url(<?php echo '..' . $rowEvent['flyer'] ?>);background-position: center; background-repeat: no-repeat;background-size: cover;width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3><?php echo $title ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" action="../assets/api/php/tickets/sendMasiveCourtesy.php" method="post" enctype="multipart/form-data">

                                            <input type="hidden" name="idEvent" value="<?php echo $idEvent ?>">
                                            <div class="form-group col-md-12">
                                                <label for="">Nombre de la Base de Datos</label>
                                                <input class="form-control form-control-lg" type="text" name="name" id="name" required placeholder="Nombre de la Base de Datos">
                                            </div>

                                            <div class="form-group col-md-7">
                                                <label for="">Tipo de ticket</label>
                                                <select class="form-control form-control-lg" name="ticketType" id="ticketType" required>
                                                    <option value="">Seleccione</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `ticketsType` WHERE `idEvent`= " . $idEvent;
                                                    $result = $mysqli->query($sql);
                                                    while ($rowTicket = $result->fetch_array(MYSQLI_ASSOC)) {
                                                    ?>
                                                        <option value="<?php echo $rowTicket['id'] ?>"><?php echo $rowTicket['name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-5">
                                                <label for="">Ticket válido hasta</label>
                                                <div class="input-group">
                                                    <input class="form-control form-control-lg" type="date" name="fechaValid" id="fechaValid" required>
                                                    <input class="form-control form-control-lg" type="time" name="horaValid" id="horaValid" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="">Base de Datos</label>
                                                <input class="form-control form-control-lg" type="file" name="bdFile" id="bdFile" accept=".xls,.xlsx,.csv">
                                            </div>

                                            <div class="form-group col-md-12 btnSubmin d-flex justify-content-end mt-4">
                                                <input type="submit" value="Enviar tickets de Cortesia" class="btn btn-lg btn-primary btn-lg mb-0">
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
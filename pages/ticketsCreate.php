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
                        $sql = "SELECT * FROM `eventos` WHERE `id`= " . $idEvent;
                        $result = $mysqli->query($sql);
                        while ($rowEvent = $result->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                            <div class="col-md-4" style="max-width: 400px;max-height: 400px;box-sizing: border-box;padding: 0;">
                                <div class="card imgEvent" style="height: 100%;">
                                    <div class="card-body" style="background: url('<?php echo '..' . $rowEvent['flyer'] ?>');background-position: center; background-repeat: no-repeat;background-size: cover;width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3><?php echo $title ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" action="../assets/api/php/tickets/saveTickets.php?nomEvent=<?php echo $nomEvent ?>" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="idEvent" value="<?php echo $idEvent ?>">
                                            <div class="form-group col-md-6">
                                                <label for="">Tipo de entrada</label>
                                                <select class="form-control form-control-lg" name="ticketType" id="ticketType" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="0">Ticket Presencial</option>
                                                    <option value="1">Ticket Streaming</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Estado</label>
                                                <select class="form-control form-control-lg" name="estado" id="estado" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="0">Activo</option>
                                                    <option value="1">Agotado</option>
                                                    <option value="2">Cortesía</option>
                                                    <option value="3">Cerrado</option>
                                                    <option value="4">Venta solo RRPP</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Nombre del ticket</label>
                                                <input class="form-control form-control-lg" type="text" name="name" id="name" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Descripción</label>
                                                <textarea name="descriptionTickets" id="" class="form-control form-control-lg" required></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Entradas en venta hasta la siguiente fecha y hora</label>
                                                <div class="input-group">
                                                    <input class="form-control form-control-lg" type="date" name="fechaVenta" id="fechaVenta" required>
                                                    <input class="form-control form-control-lg" type="time" name="horaVenta" id="horaVenta" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Los tickets serán válidos hasta</label>
                                                <div class="input-group">
                                                    <input class="form-control form-control-lg" type="date" name="fechaValid" id="fechaValid" required>
                                                    <input class="form-control form-control-lg" type="time" name="horaValid" id="horaValid" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="price">Price</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="amount">
                                                            <i class="fa-solid fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-lg" id="price" name="price" aria-describedby="amount" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Cantidad</label>
                                                <input class="form-control form-control-lg" type="number" name="cant" id="cant" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Imagen del ticket</label>
                                                <input class="form-control form-control-lg" type="file" name="imgTickets" id="imgTickets">
                                            </div>
                                            <div class="form-group col-md-12 btnSubmin d-flex justify-content-end mt-4">
                                                <input type="submit" value="Agregar Tickets" class="btn btn-lg btn-primary btn-lg mb-0">
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
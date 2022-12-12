<?php
$title = "Datos Bancarios";
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

        <body class="g-sidenav-show   bg-gray-100 bancos">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="align-items-start col-md-4 d-flex justify-content-center">
                            <img class="w-100" src="../assets/img/logo.svg" alt="" srcset="">
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="../assets/api/php/bank/saveBank.php" class="row" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="idUser" value="<?php echo $row['id'] ?>">
                                        <h2>Edita tus datos bancarios</h2>
                                        <div class="col-md-12">
                                            <label for="banco"><span class="t_ubicacion">País:</span></label>
                                            <select class="form-control form-control-lg" id="pais" name="pais" readonly>
                                                <option value="" selected="selected">Selecciona comuna...</option>
                                                <option value="argentina">Argentina</option>
                                                <option value="chile" selected="">Chile</option>
                                                <option value="mexico">México</option>
                                                <option value="paraguay">Paraguay</option>
                                                <option value="peru">Perú</option>
                                                <option value="uruguay">Uruguay</option>
                                                <option value="bolivia">Bolivia</option>
                                                <option value="colombia">Colombia</option>
                                                <option value="ecuador">Ecuador</option>
                                                <option value="usa">USA</option>
                                                <option value="espana">España</option>
                                                <option value="panama">Panamá</option>
                                                <option value="venezuela">Venezuela</option>
                                                <option value="brasil">Brasil</option>
                                                <option value="costarica">Costa Rica</option>
                                                <option value="dominicana">Republica Dominicana</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="nom"><span class="t_ubicacion">Nombre</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="nom" id="nom" placeholder="Escribe el nombre" spellcheck="false" data-ms-editor="true" class="valid">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tDoc"><span class="t_ubicacion">Tipo de Documento:</span></label>
                                            <select name="tDoc" id="tDoc" class="form-control form-control-lg">
                                                <option value="">Seleccione</option>
                                                <option value="4">RUT</option>
                                                <option value="2">PAS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nDoc"><span class="t_ubicacion">Número de Documento</span></label>
                                            <input class="form-control form-control-lg" type="text" size="11" name="nDoc" id="nDoc" placeholder="Escribe el nombre" spellcheck="false" data-ms-editor="true" class="valid">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email"><span class="t_ubicacion">Email</span></label>
                                            <input class="form-control form-control-lg" type="email" size="50" name="email" id="email" placeholder="Escribe el email" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="banco" for="region">Banco</label>
                                            <select class="form-control form-control-lg" name="banco" id="banco"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="banco" for="region">Tipo de Cuenta</label>
                                            <select class="form-control form-control-lg" name="tCuenta" id="tCuenta">
                                                <option value="">Seleccione</option>
                                                <option value="0">Cuenta de Ahorros</option>
                                                <option value="1">Cuenta Corriente</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nCuenta"><span class="t_ubicacion">Número de Cuenta</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="nCuenta" id="nCuenta" placeholder="Escribe el teléfono" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" value="Guardar" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </main>

            <?php include('../assets/components/script.php') ?>

            <script>
                $(document).ready(function() {
                    $("#banco").load('../assets/api/ajaxSearch/selectBank.php');
                });
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
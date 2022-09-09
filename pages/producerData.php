<?php
$title = "Datos de la Productora";
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
if ($_SESSION['userType'] == 0) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $idUser = $row['id'];
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
        </head>

        <body class="g-sidenav-show   bg-gray-100 dashboard">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="align-items-start col-md-4 d-flex justify-content-center">
                            <img class="w-100" src="../assets/img/small-logos/Logo_Home_Svg.svg" alt="" srcset="">
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $sqlDP = "SELECT * FROM `producerData` WHERE `idUser`=" . $idUser;
                                    $responseDP = $mysqli->query($sqlDP);
                                    while ($rowDP = $responseDP->fetch_array(MYSQLI_ASSOC)) {

                                        if (isset($rowDP['$idUser'])) {
                                            $idUser = $rowDP['idUser'];
                                        } else {
                                            $idUser = '';
                                        }
                                        if (isset($rowDP['$pais'])) {
                                            $pais = $rowDP['pais'];
                                        } else {
                                            $pais = '';
                                        }
                                        if (isset($rowDP['$nomProd'])) {
                                            $nomProd = $rowDP['nomProd'];
                                        } else {
                                            $nomProd = '';
                                        }
                                        if (isset($rowDP['$numDoc'])) {
                                            $numDoc = $rowDP['numDoc'];
                                        } else {
                                            $numDoc = '';
                                        }
                                        if (isset($rowDP['$nomRazonSocial'])) {
                                            $nomRazonSocial = $rowDP['nomRazonSocial'];
                                        } else {
                                            $nomRazonSocial = '';
                                        }
                                        if (isset($rowDP['$rubro'])) {
                                            $rubro = $rowDP['rubro'];
                                        } else {
                                            $rubro = '';
                                        }
                                        if (isset($rowDP['$direccion'])) {
                                            $direccion = $rowDP['direccion'];
                                        } else {
                                            $direccion = '';
                                        }
                                        if (isset($rowDP['$departamento'])) {
                                            $departamento = $rowDP['departamento'];
                                        } else {
                                            $departamento = '';
                                        }
                                        if (isset($rowDP['$municipio'])) {
                                            $municipio = $rowDP['municipio'];
                                        } else {
                                            $municipio = '';
                                        }
                                        if (isset($rowDP['$telefono'])) {
                                            $telefono = $rowDP['telefono'];
                                        } else {
                                            $telefono = '';
                                        }
                                        if (isset($rowDP['$email'])) {
                                            $email = $rowDP['email'];
                                        } else {
                                            $email = '';
                                        }
                                        if (isset($rowDP['$descripcion'])) {
                                            $descripcion = $rowDP['descripcion'];
                                        } else {
                                            $descripcion = '';
                                        }

                                    ?>
                                        <form action="../assets/api/php/producer/saveProducerData.php" class="row" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="idUser" value="<?php echo $row['id'] ?>">
                                            <h2>Datos como Productor</h2>
                                            <div class="div-100">
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
                                                    <option value="colombia" selected="">Colombia</option>
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
                                            <p style="font-size: 14px">
                                                Esta información será privada. En tus eventos solo indicaremos el nombre de tu productora.
                                                &nbsp;Los datos serán usados para la confección de las facturas asociadas al resultado de sus eventos.
                                            </p>
                                            <div class="div-100">
                                                <label for="nomProd"><span class="t_ubicacion">Nombre de la productora:</span></label>
                                                <input class="form-control form-control-lg" type="text" size="50" name="nomProd" id="nomProd" placeholder="Escribe el nombre" spellcheck="false" data-ms-editor="true" class="valid" value="<?php echo $nomProd?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="numDoc"><span class="t_ubicacion">NIT:</span></label>
                                                <input class="form-control form-control-lg" type="text" size="50" name="numDoc" id="numDoc" placeholder="Escribe el NIT" spellcheck="false" data-ms-editor="true" value="<?php echo $numDoc?>">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="nomRazonSocial"><span class="t_ubicacion">Razón Social o Nombre Completo:</span></label>
                                                <input class="form-control form-control-lg" type="text" size="50" name="nomRazonSocial" id="nomRazonSocial" placeholder="Escribe razón social" spellcheck="false" data-ms-editor="true" value="<?php echo $nomRazonSocial?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="rubro"><span class="t_ubicacion">Rubro:</span></label>
                                                <input class="form-control form-control-lg" type="text" size="50" name="rubro" id="rubro" placeholder="Escribe el rubro" spellcheck="false" data-ms-editor="true" value="<?php echo $rubro?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="direccion"><span class="t_ubicacion">Dirección Comercial:</span></label>
                                                <input class="form-control form-control-lg" type="text" size="50" name="direccion" id="direccion" placeholder="Escribe la dirección" spellcheck="false" data-ms-editor="true" value="<?php echo $direccion?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="aux1" for="region">Departamento:</label>
                                                <select class="form-control form-control-lg" name="departamento" id="departamento">
                                                    <option value="<?php echo $departamento?>"><?php echo $departamento?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="comuna"><span class="t_ubicacion">Municipio:</span></label>
                                                <select class="form-control form-control-lg" name="municipio" id="municipio">
                                                <option value="<?php echo $municipio?>"><?php echo $municipio?></option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="telefono"><span class="t_ubicacion">Teléfono Organización:</span></label>
                                                <input class="form-control form-control-lg" type="tel" size="50" name="telefono" id="telefono" placeholder="Escribe el teléfono" spellcheck="false" data-ms-editor="true" value="<?php echo $telefono?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email"><span class="t_ubicacion">Email Organización:</span></label>
                                                <input class="form-control form-control-lg" type="email" size="50" name="email" id="email" placeholder="Escribe el email" spellcheck="false" data-ms-editor="true" value="<?php echo $email?>">
                                            </div>

                                            <div class="col-md-12">
                                                <label for="descripcion"><span class="t_ubicacion">Descripción :</span></label>
                                                <textarea class="form-control form-control-lg" name="descripcion" id="descripcion" placeholder="Describe a tu productora de manera breve y precisa." spellcheck="false" data-ms-editor="true"value="<?php echo $descripcion?>"></textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" value="Guardar" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                            </div>
                                        </form>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </main>

            <?php include('../assets/components/script.php') ?>
            <script src="../assets/js/custom.js"></script>

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
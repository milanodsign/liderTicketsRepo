<?php
$title = "Solicitud de tickets";
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

        <body class="g-sidenav-show   bg-gray-100 ticketsList">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <div class="main-content position-relative max-height-vh-100 h-100">
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
                                    <form action="../assets/api/php/requestPrintTicket/request.php" class="row" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="idUser" id="idUser" value="<?php echo $rowUser['id'] ?>">
                                        <h1>¡Solicita la impresión de ticket!</h1>
                                        <div class="col-md-12">
                                            <label for="banco"><span class="t_ubicacion">Selecciona tu evento:</span></label>
                                            <select class="form-control form-control-lg" name="idEvent" id="nomEvent" style="text-transform: uppercase">
                                                <option value="" selected="selected">Seleccione su evento</option>
                                                <?php
                                                $sqlEvent = "SELECT * FROM `eventos` WHERE `idUser` = '" . $_SESSION['id'] . "' AND `estado` = 1";
                                                $resultEvent = $mysqli->query($sqlEvent);
                                                while ($rowEvent = $resultEvent->fetch_array(MYSQLI_ASSOC)) {
                                                    echo '<option value="' . $rowEvent['id'] . '" style="text-transform: uppercase">' . $rowEvent['nomEvent'] . '</option>';
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="nomE"><span class="t_ubicacion">Nombre del Evento</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="nomEvent" id="nomE" placeholder="Escribe el nombre del Evento" spellcheck="false" data-ms-editor="true" class="valid" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tTicket"><span class="t_ubicacion">Tipo de Ticket</span></label>
                                            <select name="tTicket" id="tTicket" name="tTicket" class="form-control form-control-lg">
                                                <option value="-1">Seleccione Ticket</option>
                                                <option value="-1">Seleccione el Evento</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="banco" for="price">Precio</label>
                                            <select class="form-control form-control-lg" name="showPrice" id="price">
                                                <option value="">Seleccione</option>
                                                <option value="1" selected>Si</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="dir"><span class="t_ubicacion">Dirección</span></label>
                                            <input class="form-control form-control-lg" type="text" name="dir" id="dir" placeholder="Dirección del evento" spellcheck="false" data-ms-editor="true" readonly>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="lugar"><span class="t_ubicacion">Lugar</span></label>
                                            <input class="form-control form-control-lg" type="text" name="lugar" id="lugar" placeholder="Lugar del evento" spellcheck="false" data-ms-editor="true" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="prod" for="region">Productora</label>
                                            <input class="form-control form-control-lg" type="text" name="prod" id="prod" placeholder="Nombre de la Productora" spellcheck="false" data-ms-editor="true" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="numDoc"><span class="t_ubicacion">No. Documento</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="numDoc" id="numDoc" placeholder="Documento de la Productora" spellcheck="false" data-ms-editor="true" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="idEvent"><span class="t_ubicacion">Cod. Evento</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="idEvent" id="idEvent" placeholder="Código del Evento" spellcheck="false" data-ms-editor="true" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="datepicker-start">Fecha del evento</label>
                                                <input name="fecha" type="date" id="fecha" class="form-control form-control-lg" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="datepicker-start">Hora del evento</label>
                                                <input name="hora" type="time" id="hora" class="form-control form-control-lg" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="desc"><span class="t_ubicacion">Descripción del ticket</span></label>
                                            <textarea class="form-control form-control-lg" name="desc" id="desc" placeholder="Descripción del ticket" spellcheck="false" data-ms-editor="true" readonly></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="price">Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="amount">
                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control form-control-lg" id="priceTicket" name="priceTicket" aria-describedby="amount" required readonly style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border: 1px solid #d2d6da; padding: 0.75rem 0.75rem;" placeholder="Precio">
                                                <span style="color: red; font-size: 10px;">Valor del ticket + Recargo (Comisión de servicio).</span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Cantidad</label>
                                            <input class="form-control form-control-lg" type="number" name="cant" id="cant" required>
                                            <span style="color: red">*La cantidad debe ser maximo 100 tickets por solicitud</span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Imagen del ticket</label>
                                                <input class="form-control form-control-lg" type="file" name="imgTicket" id="imgTickets">
                                            </div>
                                        </div>
                                        <p class="notaRequest">
                                            <b>IMPORTANTE:</b> La imagen debe medir 537px de ancho por 192px de alto y no pesar más de 1MB. (Se sugiere resolución de 300 PPP). La imagen debe ser en blanco y negro. Extensión JPG o PNG. <b>LA IMAGEN NO ES OBLIGATORIA</b>, si no se coloca, se usará el titulo del evento. 
                                            <b>NO DEBE CONTENER</b> Tipo de ticket (general, vip etc), dirección, precio, día y hora - ya que estos datos salen predeterminados.

                                        </p>
                                        <div class="col-md-12">
                                            <input type="submit" value="Solicitar" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                $('#nomEvent').change(function() {
                    let id = $('#nomEvent').val();
                    $.ajax({
                        type: "get",
                        url: "https://lidertickets.cl/assets/api/ajaxSearch/searchDataEvent.php?id=" + id,
                        dataType: "json",
                        success: function(response) {
                            $('#nomE').val(response[0].nomEvent)
                            $('#dir').val(response[0].dir)
                            $('#lugar').val(response[0].lugar)
                            $('#prod').val(response[0].prod)
                            $('#numDoc').val(response[0].numDoc)
                            $('#idEvent').val(response[0].idEvent)
                            $('#fecha').val(response[0].fechaEvent)
                            $('#hora').val(response[0].horaEvent)
                        }
                    });
                    $("#tTicket").load(
                        "../assets/api/ajaxSearch/selectTickets.php?id=" + id
                    );
                });
                $("#tTicket").change(function() {
                    let id = $('#tTicket').val();
                    $.ajax({
                        type: "get",
                        url: "https://lidertickets.cl/assets/api/ajaxSearch/searchDataTicket.php?id=" + id,
                        dataType: "json",
                        success: function(response) {
                            $porcentaje = Number(response[0].price) * 0.15;
                            $('#priceTicket').val(Number(response[0].price) + Number($porcentaje))
                            $('#desc').val(response[0].desc)
                        }
                    });
                });
            </script>
        </body>

        </html>
<?php
    }
}
?>
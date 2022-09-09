<?php
$title = "CheckOut";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$title = $_POST['nomEvent'];
$idEvent = $_POST['idEvent'];
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$referencia = substr(str_shuffle($permitted_chars), 0, 13);





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
        $name = $rowUser['name'];
        $mail = $rowUser['mail'];
        $phone = $rowUser['phone'];


?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
            <script type="text/javascript" src="https://checkout.wompi.co/widget.js"></script>
        </head>

        <body class="g-sidenav-show bg-gray-100">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <img src="../assets/img/small-logos/Logo_Home_Svg.svg" class="imgCheckOut" alt="main_logo">
                                    <h4 style="margin-top: 15px">Información de la compra</h4>
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th scope="col">Flyer</th>
                                                <th scope="col">Evento</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // var_dump($_POST['idEvent']);exit();
                                            $cant = 0;
                                            $subTotal = 0;
                                            $sqlEvent = "SELECT * FROM `eventos` WHERE `id`= '" . $idEvent . "'";
                                            $resultEvent = $mysqli->query($sqlEvent);
                                            while ($row = $resultEvent->fetch_array(MYSQLI_ASSOC)) {
                                                // var_dump($row);exit();
                                                foreach ($_POST['idTicket'] as $idTicket) {
                                                    $cantidad = $_POST['cant'][$cant];
                                                    if ($cantidad != '0') {
                                                        $sqlTickets = "SELECT * FROM `ticketsType` WHERE `id`= " . $idTicket;
                                                        $resultTickets = $mysqli->query($sqlTickets);
                                                        while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
                                                            $ticket = $rowTickets['name'];
                                                            $price = $rowTickets['price'];
                                                            $subTotal = ($price * $cantidad) + $subTotal;
                                                        }
                                            ?>
                                                        <tr>
                                                            <td scope="row"><img class="imgCheckOutTable" src="<?php echo '..' . $row['flyer'] ?>" /></td>
                                                            <td><?php echo $row['nomEvent'] ?></td>
                                                            <td><?php echo $ticket ?></td>
                                                            </td>
                                                            <td>
                                                                <?php echo 'COP$' . number_format($price, 2) ?>
                                                            </td>
                                                            <td style="text-align: center"><?php echo $cantidad ?></td>
                                                            <td><?php echo 'COP$' . number_format(($price * $cantidad), 2) ?></td>
                                                        </tr>
                                            <?php
                                                    }
                                                    $cant = $cant + 1;
                                                }
                                                $porcentaje = $subTotal * 0.15;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: right"><b>Sub-total:</b></td>
                                                <td style="text-align: right"><?php echo 'COP$' . number_format($subTotal, 2) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right"><b>Tarifa de servicio:</b></td>
                                                <td style="text-align: right">
                                                    <?php echo 'COP$' . number_format($porcentaje, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right"><b>Total:</b></td>
                                                <td style="text-align: right">
                                                    <?php echo 'COP$' . number_format(($subTotal + $porcentaje), 2) ?></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- section Timer -->
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: space-around; height: 175px;">
                                    <i class="fa-regular fa-clock"></i>
                                    <h1 class="text-center" id="count-down-timer" style="margin: 0;"></h1>
                                    <h4>Tienes 10 minutos, para realizar la compra.</h4>
                                </div>
                            </div>
                        </div>
                        <!-- section form -->
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body row">
                                    <h4 style="margin-top: 15px">Información del comprador</h4>
                                    <form class="row" action="../assets/api/php/tickets/saleTicketsLoged.php" method="post">
                                        <input type="hidden" name="referencia" value="<?php echo $referencia ?>">
                                        <input type="hidden" name="idEvent" value="<?php echo $id ?>">
                                        <?php
                                        $cant = 0;
                                        foreach ($_POST['idTicket'] as $idTicket) {
                                            $cantidad = $_POST['cant'][$cant];
                                            if ($cantidad != '0') {
                                                echo '<input type="hidden" name="cant[]" value="' . $cantidad . '">
                    <input type="hidden" name="idTickets[]" value="' . $idTicket . '">
                    <input type="hidden" name="porcentaje" value="' . $porcentaje . '">';
                                            }
                                            $cant++;
                                        }
                                        ?>

                                        <div class="col-md-12">
                                            <label for=""><span class="t_ubicacion">Nombre del comprador</span></label>
                                            <input class="form-control form-control-lg" type="text" name="name" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for=""><span class="t_ubicacion">Correo Electrónico</span></label>
                                            <input class="form-control form-control-lg" type="email" name="email" />
                                        </div>
                                        <div class="col-md-3">
                                            <label for=""><span class="t_ubicacion">Teléfono</span></label>
                                            <input class="form-control form-control-lg" type="text" name="phone" />
                                        </div>
                                        <div class="col-md-2">
                                            <label for=""><span class="t_ubicacion">Tipo de Documentos</span></label>
                                            <select name="type" class="form-control form-control-lg">
                                                <option value="" disabled="">Tipo</option>
                                                <option value="CC">CC - Cédula de Ciudadanía</option>
                                                <option value="CE">CE - Cédula de Extranjería</option>
                                                <option value="NIT">NIT - Número de Identificación Tributaria</option>
                                                <option value="PP">PP - Pasaporte</option>
                                                <option value="TI">TI - Tarjeta de Identidad</option>
                                                <option value="DNI">DNI - Documento Nacional de Identidad</option>
                                                <option value="RG">RG - Carteira de Identidade / Registro Geral</option>
                                                <option value="OTHER">Otro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for=""><span class="t_ubicacion">N° Documento</span></label>
                                            <input class="form-control form-control-lg" type="text" name="numDoc" value="" />
                                        </div>
                                        <button class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 wompi">Pagar
                                            con Wompi</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </main>

            <?php include('../assets/components/script.php') ?>
            <script type="text/javascript">
                const paddedFormat = (num) => {
                    return num < 10 ? "0" + num : num;
                }

                const startCountDown = (duration, element) => {

                    let secondsRemaining = duration;
                    let min = 0;
                    let sec = 0;

                    let countInterval = setInterval(() => {

                        min = parseInt(secondsRemaining / 60);
                        sec = parseInt(secondsRemaining % 60);

                        element.textContent = `${paddedFormat(min)}:${paddedFormat(sec)}`;

                        secondsRemaining = secondsRemaining - 1;
                        if (secondsRemaining < 0) {
                            clearInterval(countInterval)
                        };

                        if (min === 0 && sec === 0) {
                            alert('El tiempo para la compra ah caducado, usted sera redirigido a la pagina de inicio'),
                                window.location.href = "https://lidertickets.co"
                        }
                    }, 1000);
                }
                $(document).ready(() => {
                    let time_minutes = 10;
                    let time_seconds = 00;
                    let duration = time_minutes * 60 + time_seconds;
                    element = document.querySelector('#count-down-timer');
                    element.textContent = `${paddedFormat(time_minutes)}:${paddedFormat(time_seconds)}`;
                    startCountDown(--duration, element);
                });
                let win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    let options = {
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
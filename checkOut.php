<?php
require './assets/api/conex/conexConfig.php';
include('./assets/api/php/functions/fechaEs.php');

$title = $_POST['nomEvent'];
$id = $_POST['idEvent'];
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$referencia = substr(str_shuffle($permitted_chars), 0, 13);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es">
<!--<![endif]-->

<head>
  <?php include('./assets/components/headerIndex.php') ?>
</head>

<body class="checkOut">
  <!-- header section -->
  <?php include('./assets/components/navIndex.php') ?>
  <script type="text/javascript" src="https://checkout.webPay.co/widget.js"></script>


  <section class="container-fluid checkOutIndex">
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <img src="../assets/img/logo.svg" class="imgCheckOut" alt="main_logo">
            <h4 style="margin-top: 15px">Información de la compra</h4>
            <table class="table checkout">
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
                $cant = 0;
$subTotal = 0;
$sql = "SELECT * FROM `eventos` WHERE `id`= " . $id;
$result = $mysqli->query($sql);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
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
                        <td>
                          <?php echo '$' . number_format($price, 2) ?>
                        </td>
                        <td style="text-align: center"><?php echo $cantidad ?></td>
                        <td style="text-align: right"><?php echo '$' . number_format(($price * $cantidad), 2) ?></td>
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
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right"><b>Sub-total:</b></td>
                  <td style="text-align: right"><?php echo '$' . number_format($subTotal, 2) ?></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right"><b>Comisión de transacción:</b></td>
                  <td style="text-align: right"><?php echo '$' . number_format($porcentaje, 2) ?></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right"><b>Total:</b></td>
                  <td style="text-align: right"><?php echo '$' . number_format(($subTotal + $porcentaje), 2) ?></td>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <!-- section Timer -->
      <div class="col-md-12 mt-4">
        <div class="card">
          <div class="card-body">
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
            <!-- <form action="./assets/api/php/tickets/payments/create.php" method="post"> -->
              <form action="./assets/api/php/tickets/saleTicketsIndex.php" method="post">
              <input type="hidden" name="referencia" value="<?php echo $referencia ?>">
              <input type="hidden" name="idEvent" value="<?php echo $id ?>">
              <?php
              $cant = 0;
foreach ($_POST['idTicket'] as $idTicket) {
    echo '<script>console.log(' . $_POST['cant'][$cant] . ')</script>';
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
                  <option value="RUT">RUT - Rol Único Tributario</option>
                  <option value="PP">PP - Pasaporte</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for=""><span class="t_ubicacion">N° Documento</span></label>
                <input class="form-control form-control-lg" type="text" name="numDoc" value="" />
              </div>
              <!-- <button class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 webPay">
                <img src="./assets/img/logos/logo-flow.svg" alt="">
              </button> -->

              <button class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 webPay">
                <img src="./assets/img/logos/webPay.png" alt="">
              </button>

            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include('../assets/components/footer.php') ?>
  </section>
  <!-- Footer section -->
  <?php include('./assets/components/footerIndex.php') ?>
  <!-- Footer section -->

  <!-- JS FILES -->
  <?php include('./assets/components/scriptIndex.php') ?>
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
            window.location.href = "https://lidertickets.cl"
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
  </script>
</body>

<?php  ?>

</html>
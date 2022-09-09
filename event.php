<?php
require './assets/api/conex/conexConfig.php';
include('./assets/api/php/functions/fechaEs.php');
$nomEvent = $_GET['nomEvent'];
$id = $_GET['id'];
$idUser = $_GET['idUser'];
$title = $_GET['nomEvent'];
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
<?php
$sqlEvents = "SELECT * FROM `eventos` WHERE `id`=" . $id;
$resultEvents = $mysqli->query($sqlEvents);
while ($row = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
?>

<body class="event">
  <!-- header section -->
  <?php include('./assets/components/navIndex.php') ?>

  <!-- event contentn -->
  <section class="container eventContentInfo m-auto row section" style="padding-top: 144px !important;">

    <div class="col-lg-9 col-md-6 col-sm-12">
      <h1>
        <?php if ($row['mayores'] = 1) {
            echo $row['nomEvent'] . ' <span style="color: #e09900">(+18)</span>';
          } else {
            echo $row['nomEvent'];
          } ?>
      </h1>
      <h2>
        <i class="fa-solid fa-calendar-days"></i>
        <span>
          <? echo fechaEs($row['fechaIni']) . ' - ' . date('h:i A', strtotime($row['horaIni'])) ?>
        </span>
      </h2>
      <div class="card mt-5">
        <div class="card-body">
          <form class="cantTickets d-flex flex-column" action="./checkOut.php" method="POST">
            <input type="hidden" name="nomEvent" value="<?php echo $nomEvent ?>">
            <input type="hidden" name="idEvent" value="<?php echo $id ?>">
            <table class="table">
              <thead>
                <tr>
                  <th>Tipo de Ticket</th>
                  <th>Valor</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $cont = 0;
                  $sqlTickets = "SELECT * FROM `ticketsType` WHERE `idEvent`=" . $row['id'];
                  $resultTickets = $mysqli->query($sqlTickets);
                  while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {

                    $courtesyTotal = 0;
                    $saleTotal = 0;
                    $cancelTotal = 0;

                    $sumaTotalSales = 0;
                    $sumaTotalCancel = 0;
                    $total = 0;

                    $sqlCT = "SELECT * FROM `courtesyTickets` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'];
                    $resultCT = $mysqli->query($sqlCT);;
                    $courtesyCount = mysqli_num_rows($resultCT);
                    $courtesyTotal += $courtesyCount;

                    $sqlTS = "SELECT * FROM `ticketsSales` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'] . " AND `status` = 1";
                    $resultTS = $mysqli->query($sqlTS);;
                    $salesCount = mysqli_num_rows($resultTS);
                    $saleTotal += $salesCount;

                    $sqlCancelT = "SELECT * FROM `ticketsSales` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'] . " AND `status` = 0";
                    $resultCancelT = $mysqli->query($sqlCancelT);;
                    $cancelCount = mysqli_num_rows($resultCancelT);
                    $cancelTotal += $cancelCount;

                    $ticketsDisponibles = $rowTickets['cant'] - (($courtesyCount + $salesCount) - $cancelCount);
                  ?>
                <tr>
                  <td>
                    <?php echo $rowTickets['name'] ?>
                    <input type="hidden" name="idTicket[]" value="<?php echo $rowTickets['id'] ?>" />
                  </td>
                  <td>
                    <?php echo '$' . number_format($rowTickets['price'], 2) ?>
                  </td>
                  <td>
                    <?php
                        if ($ticketsDisponibles == 0) {
                          echo '<span>AGOTADO</span>';
                        } else { ?>
                    <select class="form-control form-control-lg" name="cant[]" id="cant[]">
                      <?php
                            for ($cant = 0; $cant <= 6; $cant++) {
                              
                              
                              echo '<option value="' . $cant . '">' . $cant . '</option>';
                            }
                            ?>
                    </select>
                    <?php
                        }
                        ?>
                  </td>
                </tr>
                <?php
                    $cont = $cont + 1;
                  }
                  ?>
              </tbody>
            </table>
            <button class="btn btn-primary">Comprar</button>
          </form>
          <div class="description">
            <p>
              <?php if ($row['mayores'] = 1) {
                echo '<span style="color: #ff0000; display: flex;">Evento solo para Mayores de 18 Años.</span>';
              } ?>
              <?php echo $row['descripcion'] ?>
            </p>
          </div>
          <span>Los comentarios y/o textos ingresados son de exclusiva responsabilidad del Productor y/o
            Organizador del Evento. LiderTickets no se hace responsable por declaraciones emitidas por estos en
            lo relativo a los Eventos. El Productor/Organizador es el único y exclusivo responsable de la
            producción y organización del Evento, en forma oportuna y en conformidad a la ley.</span>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 row">
      <span class="d-flex justify-content-end">
        <span>
          <i class="fa-solid fa-location-arrow"></i>
        </span>
        <span class="d-flex flex-column">
          <h2>
            <?php echo $row['lugar']; ?>
          </h2>
          <h2>
            <span>
              <?php echo $row['dir'] ?>
            </span>
          </h2>
        </span>
      </span>
      <div class="card">
        <div class="card-body d-flex flex-column">
          <span class="flyerEvent"
            style="background: url('<?php echo 'https://lidertickets.co' . $row['flyer'] ?>');  background-position: center; background-repeat: no-repeat; background-size: cover; margin: 0; width: 100%; height: 300px;"></span>
          <span class="titleOtherEvent d-flex justify-content-center">
            <?php
              $sqlProduct = "SELECT * FROM `producerData` WHERE `idUser`='" . $idUser . "'";
              $resultProduct = $mysqli->query($sqlProduct);
              while ($rowProduct = $resultProduct->fetch_array(MYSQLI_ASSOC)) {
              ?>
            <h1>
              <?php echo $rowProduct['nomProd'] ?>
            </h1>
            <?php
              }
                ?>
          </span>
          <span class="titleOtherEvent d-flex justify-content-center">
            <h3>Otros eventos de esta Productora</h3>
          </span>
          <div id="evntListProd" class="carousel slide">
            <?php
              $sqlEvents = "SELECT * FROM `eventos` WHERE `idUser`='" . $idUser . "' AND `estado`= 1 ";
              $resultEvents = $mysqli->query($sqlEvents);
              while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
              ?>
            <div><a
                href="<?php echo 'https://lidertickets.co/event.php?nomEvent=' . $rowEvents['nomEvent'] . '&id=' . $rowEvents['id'] . '&idUser' . $rowEvents['idUser'] ?>">
                <img class="d-block w-100" src="<?php echo 'https://lidertickets.co' . $rowEvents['flyer']  ?>"
                  alt="<?php echo $rowEvents['nomEvent']  ?>">
              </a>
            </div>
            <?php
              }
              ?>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Footer section -->
  <?php include('./assets/components/footerIndex.php') ?>
  <!-- Footer section -->

  <!-- JS FILES -->
  <?php include('./assets/components/scriptIndex.php') ?>
  <script type="text/javascript" src="./assets/js/evIndex.js"></script>
</body>

<?php } ?>

</html>
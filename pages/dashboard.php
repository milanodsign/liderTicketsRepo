<?php
$title = "Dashboard";
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
if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1 || $_SESSION['userType'] == 2 ) {
  $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
  $result = $mysqli->query($sql);
  while ($rowUser = $result->fetch_array(MYSQLI_ASSOC)) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
      <?php include('../assets/components/header.php') ?>
    </head>

    <body class="g-sidenav-show   bg-gray-100 dashboard events">
      <div class="min-height-300 bg-primary position-absolute w-100"></div>
      <?php include('../assets/components/nav.php') ?>
      <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <?php include('../assets/components/navBar.php') ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
          <div class="row">
            <?php
            $sqlEvents = "SELECT * FROM `eventos` WHERE `estado`= 1 order by id desc limit 4";
            $resultEvents = $mysqli->query($sqlEvents);
            while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
              $id = $rowEvents['id'];
            ?>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-body">
                    <div class="imgEvent" style="background: url(<?php echo $rowEvents['flyer'] ?>);background-position: center; background-repeat: no-repeat;background-size: cover;">
                    </div>
                    <div class="infoEvent">
                      <span>
                        <?php echo $rowEvents['nomEvent'] ?>
                      </span>
                      <span>
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>
                          <? echo  fechaEs($rowEvents['fechaIni']) . ' - ' . $rowEvents['horaIni'] ?>
                        </span>
                      </span>
                      <span>
                        <i class="fa-solid fa-dollar-sign"></i>
                        <?php
                        $sqlTickets = "SELECT MIN(price), MAX(price) FROM `ticketsType` WHERE `idEvent`=$id";
                        $resultTickets = $mysqli->query($sqlTickets);
                        while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                          <span>
                            <? echo  'Desde $' . number_format($rowTickets['MIN(price)'], 2) . ' - Hasta $' . number_format($rowTickets['MAX(price)'], 2) ?>
                          </span>
                        <? } ?>
                      </span>
                      <span>
                        <i class="fa-solid fa-map-pin"></i>
                        <span>
                          <?php echo $rowEvents['dir'] ?>
                        </span>
                      </span>
                      <span class="btn btn-primary" onclick="eventGo(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                        <i class="fa-solid fa-ticket"></i>
                        <span>Comprar Tickets</span>
                      </span>
                    </div>

                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <?php include('../assets/components/footer.php') ?>
        </div>
      </main>

      <?php include('../assets/components/script.php') ?>

      <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        const eventGo = (id, nomEvent) => {
          window.location.href = 'event.php?id=' + id + '&nomEvent=' + nomEvent;
        }
      </script>

    </body>

    </html>
<?php
  }
}
?>
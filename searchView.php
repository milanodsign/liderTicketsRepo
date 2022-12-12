<?php
require './assets/api/conex/conexConfig.php';
include('./assets/api/php/functions/fechaEs.php');
$nomEvent = $_GET['nomEvent'];
$id = $_GET['id'];
$idUser = $_GET['idUser'];
$title = $_GET['nomEvent'];

if (isset($_POST['key'])) {
  $key = $_POST['key'];
}
if (isset($_POST['region'])) {
  $region = $_POST['region'];
}
if (isset($_POST['comuna'])) {
  $comuna = $_POST['comuna'];
}
if (isset($_POST['month'])) {
  $month = $_POST['month'];
}

// var_dump($key, $region, $comuna, $month);exit;

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

<body class="events">
  <!-- header section -->
  <?php include('./assets/components/navIndex.php') ?>

  <!-- events content -->

  <!-- search section -->
  <section class="search section" style="padding-top: 144px !important;padding-bottom: 50px;">
    <form action="./searchView.php" method="post" class="form-inline">
      <input type="text" name="key" id="key" class="form-control" placeholder="Busca tu evento en Lider Tickets">
      <select name="region" id="regionSearch" class="form-control">
        <option value="">Seleccione Departamento</option>
      </select>
      <select name="comuna" id="comunaSearch" class="form-control">
        <option value="">Seleccione Municipio</option>
        <option value="">Selecciona un Departamento</option>
      </select>
      <select name="month" id="month" class="form-control">
        <option value="">Seleccione Mes</option>
        <?php
        for ($i = 1; $i <= 12; $i++) {
          switch ($i) {
            case '1':
              $mes = 'Ene';
              break;
            case '2':
              $mes = 'Feb';
              break;
            case '3':
              $mes = 'Mar';
              break;
            case '4':
              $mes = 'Abr';
              break;
            case '5':
              $mes = 'May';
              break;
            case '6':
              $mes = 'Jun';
              break;
            case '7':
              $mes = 'Jul';
              break;
            case '8':
              $mes = 'Ago';
              break;
            case '9':
              $mes = 'Sep';
              break;
            case '10':
              $mes = 'Oct';
              break;
            case '11':
              $mes = 'Nov';
              break;
            case '12':
              $mes = 'Dic';
              break;
          }
          echo '<option value="' . $i . '">' . $mes . ' ' . date('Y') . '</option>';
        }
        ?>
      </select>
      <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
  </section>

  <h1 class="w100 d-flex justify-content-center" style="color: #fff;">
    Eventos que coinciden con tu busqueda
  </h1>
  <!-- search section -->

  <section id="eventGrid" class="gallery section">
    <div class="container-fluid">
      <div class="gridEvent">
        <?php
        if (isset($key) && isset($region) && isset($comuna) && isset($month)) {
          $sql = "SELECT * FROM eventos WHERE nomEvent LIKE '%" . $key . "%' OR artista LIKE '%" . $key . "%' AND region = '" . $region . "' AND comuna = '" . $comuna . "' AND MONTH(fechaIni) = '" . $month . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($key) && isset($region) && isset($comuna)) {
          $sql = "SELECT * FROM eventos WHERE nomEvent LIKE '%" . $key . "%' OR artista LIKE '%" . $key . "%' AND region = '" . $region . "' AND comuna = '" . $comuna . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($key) && isset($region)) {
          $sql = "SELECT * FROM eventos WHERE nomEvent LIKE '%" . $key . "%' OR artista LIKE '%" . $key . "%' AND region = '" . $region . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($key)) {
          $sql = "SELECT * FROM eventos WHERE nomEvent LIKE '%" . $key . "%' AND artista LIKE '%" . $key . "%' AND estado = 1 ORDER BY id DESC";
        } else if (isset($key) && isset($month)) {
          $sql = "SELECT * FROM eventos WHERE nomEvent LIKE '%" . $key . "%' AND artista LIKE '%" . $key . "%' AND MONTH(fechaIni) = '" . $month . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($region) && isset($comuna) && isset($month)) {
          $sql = "SELECT * FROM eventos WHERE region = '" . $region . "' AND comuna = '" . $comuna . "' AND MONTH(fechaIni) = '" . $month . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($region) && isset($comuna)) {
          $sql = "SELECT * FROM eventos WHERE region = '" . $region . "' AND comuna = '" . $comuna . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($region)) {
          $sql = "SELECT * FROM eventos WHERE region = '" . $region . "' AND estado = 1 ORDER BY id DESC";
        } else if (isset($month)) {
          $sql = "SELECT * FROM eventos WHERE MONTH(fechaIni) = '" . $month . "' AND estado = 1 ORDER BY id DESC";
        } else {
          $sql = "SELECT * FROM eventos WHERE estado = 1 ORDER BY id DESC";
        }
        $resultEvents = $mysqli->query($sql);
        while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
          $id = $rowEvents['id'];
        ?>
          <div class="eventContent" onclick="eventGo(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`, `<?php echo $rowEvents['idUser'] ?>`)">
            <div class="card">
              <div class="card-body">
                <div class="imgEvent" style="background: url(<?php echo 'https://lidertickets.co' . $rowEvents['flyer'] ?>);background-position: center; background-repeat: no-repeat;background-size: cover;">
                </div>
                <div class="infoEvent">
                  <span>
                    <?php echo $rowEvents['nomEvent'] ?>
                  </span>
                  <span>
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>
                      <? echo  fechaEs($rowEvents['fechaIni']) . ' - ' . date('h:i A', strtotime($rowEvents['horaIni'])) ?>
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
                  <span class="btn btn-primary">
                    <i class="fa-solid fa-ticket"></i>
                    <span>Comprar Tickets</span>
                  </span>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    </div>
  </section>
  <!-- Footer section -->
  <?php include('./assets/components/footerIndex.php') ?>
  <!-- Footer section -->

  <!-- JS FILES -->
  <?php include('./assets/components/scriptIndex.php') ?>
  <!-- <script type="text/javascript" src="./assets/js/index.js"></script> -->
  <script>
    $(document).ready(function() {
      $("#regionSearch").load("./assets/api/ajaxSearch/selectDep.php");
    });

    $("#regionSearch").change(function() {
      let dep = $("#regionSearch").val();
      $("#comunaSearch").load("../assets/api/ajaxSearch/selectMun.php?dep=" + dep);
    });

    const eventGo = (id, nomEvent, idUser) => {
      window.location.href = "./event.php?nomEvent=" + nomEvent + "&id=" + id + "&idUser=" + idUser;
    };
  </script>
</body>

<?php  ?>

</html>
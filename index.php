<?php
require './assets/api/conex/conexConfig.php';
include('./assets/api/php/functions/fechaEs.php');
$title = 'Chile';
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
  <!-- banner text -->
  <div id="bannerPrincipal" class="carousel slide">
    <?php
    $date = date('Y-m-d');
    $sqlEvents = "SELECT * FROM `eventos` WHERE `estado`= 1 AND `fechaIni`>='" . $date . "'  ORDER BY `fechaIni` ASC ";
    $resultEvents = $mysqli->query($sqlEvents);
    while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
      if ($rowEvents['banner'] != '') {

    ?>
        <div class="itemBanner">
          <a href="<?php echo 'https://lidertickets.cl/event.php?nomEvent=' . $rowEvents['nomEvent'] . '&id=' . $rowEvents['id'] . '&idUser' . $rowEvents['idUser'] ?>">
            <img class="d-block w-100" src="<?php echo 'https://lidertickets.cl' . $rowEvents['banner']  ?>" alt="<?php echo $rowEvents['nomEvent']  ?>">
          </a>
        </div>
    <?php
      }
    }
    ?>
  </div>
  <!-- banner text -->

  <!-- search section -->
  <section class="search section">
    <form action="./searchView.php" method="post" class="form-inline">
      <input type="text" name="key" id="key" class="form-control" placeholder="Busca tu evento en Lider Tickets">
      <select name="region" id="region" class="form-control">
        <option value="">Seleccione Región</option>
      </select>
      <select name="comuna" id="comuna" class="form-control">
        <option value="">Seleccione Comuna</option>
        <option value="">Selecciona una Region</option>
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
      <button class="btn btn-primary" type="submit"><img class="isotipo" src="./assets/img/search.png" alt="" class="corona"></button>
    </form>
  </section>
  <!-- search section -->

  <!-- caroussel section -->
  <section class="caroussel section">
    <div class="responsive">
      <?php
      $sqlEvents = "SELECT * FROM `eventos` WHERE `estado`= 1 AND `fechaIni`>='" . $date . "' ORDER BY `fechaIni` ASC";
      $resultEvents = $mysqli->query($sqlEvents);
      while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
      ?>
        <div>
          <a href="<?php echo 'https://lidertickets.cl/event.php?nomEvent=' . $rowEvents['nomEvent'] . '&id=' . $rowEvents['id'] . '&idUser' . $rowEvents['idUser'] ?>">
            <img src="<?php echo 'https://lidertickets.cl' . $rowEvents['flyer'] ?>" alt="<?php echo $rowEvents['nomEvent'] ?>" title="<?php echo $rowEvents['nomEvent'] ?>">
          </a>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
  <!-- caroussel section -->

  <!-- gridEvent section -->
  <section id="eventGrid" class="gallery section">
    <div class="container-fluid">
      <div class="gridEvent">
        <?php
        if (isset($_GET['pageno'])) {
          $pageno = $_GET['pageno'];
        } else {
          $pageno = 1;
        }
        $no_of_records_per_page = 8;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM `eventos` WHERE `estado`= 1 ";
        $result = $mysqli->query($total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil((float)$total_rows / $no_of_records_per_page);


        $sqlEvents = "SELECT * FROM `eventos` WHERE `estado`= 1 AND `fechaIni`>='" . $date . "'  ORDER BY `fechaIni` ASC  LIMIT $offset, $no_of_records_per_page";
        $resultEvents = $mysqli->query($sqlEvents);
        while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
          $id = $rowEvents['id'];
        ?>
          <div class="eventContent" onclick="eventGo(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`, `<?php echo $rowEvents['idUser'] ?>`)">
            <div class="card">
              <div class="card-body">
                <div class="imgEvent" style="background: url('<?php echo 'https://lidertickets.cl' . $rowEvents['flyer'] ?>');background-position: center; background-repeat: no-repeat;background-size: cover;">
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
                    $sqlTickets = "SELECT MIN(price), MAX(price), price FROM `ticketsType` WHERE `idEvent`=$id";
                    $resultTickets = $mysqli->query($sqlTickets);
                    while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
                    ?>
                      <span>
                        <? echo  'Desde $' . number_format($rowTickets['MIN(price)'], 2) . ' - Hasta $' . number_format($rowTickets['MAX(price)'], 2) ?>
                      </span>
                    <?
                    } ?>
                  </span>
                  <span>
                    <i class="fa-solid fa-map-pin"></i>
                    <span>
                      <?php echo $rowEvents['dir'] ?>
                    </span>
                  </span>
                  <span class="btn btn-primary">
                    <img src="./assets/img/saleTickets.png" alt="">
                  </span>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>
        <nav aria-label="Page navigation" class="navPagination">
          <ul class="pagination justify-content-center">
            <?php
            for ($page = 1; $page <= $total_pages; $page++) {
            ?>
              <li class="page-item <?php if ($page == $pageno) {
                                      echo 'active';
                                    } ?>">
                <a class="page-link" href="<?php echo "?pageno=" . $page . "#eventGrid" ?>"><?php echo $page ?></a>
              </li>
            <?php
            }
            ?>
          </ul>
        </nav>
      </div>
    </div>
    </div>
  </section>
  <!-- gridEvent section -->

  <!-- commingSoon section -->
  <section id="commingSoon" class="section teams">
    <div class="container">
      <div class="section-header">
        <h2 class="wow fadeInDown animated">Próximo evento</h2>
      </div>
      <div class="row">
        <?php
        $sqlEventoCercano = "SELECT * FROM `eventos` WHERE `fechaIni` > NOW() ORDER BY `fechaIni` LIMIT 1";
        $resultEventoCercano = $mysqli->query($sqlEventoCercano);
        while ($row = $resultEventoCercano->fetch_array(MYSQLI_ASSOC)) {
          $fechaIni = explode("-", $row['fechaIni']);
          switch ($fechaIni[1]) {
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
        ?>
          <div class="col-md-6">
            <img src="<?php echo 'https://lidertickets.cl' . $row['flyer'] ?>" class="img-responsive" alt="">
          </div>
          <div class="col-md-6">
            <div class="col-md-11">
              <h3><?php echo $row['nomEvent'] ?></h3>
              <h4><?php echo $row['descripcion'] ?></h4>
              <ul class="tour-list">
                <li>
                  <div class="tour-date">
                    <?php echo $fechaIni[2] ?><span><?php echo $mes ?><br><em><?php echo $fechaIni[0] ?></em></span>
                  </div>
                  <span class="d-flex">
                    <div class="tour-info">
                      <?php echo $row['dir'] . ' - ' . $row['comuna'] . '/' . $row['region'] ?></div>
                  </span>
                  <div class="mt-2 tour-ticket"><a href="#">Comprar Tickets</a></div>
                </li>
              </ul>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </section>
  <!-- commingSoon section -->

  <!-- contact section -->
  <section id="contact" class="section">
    <div class="container">
      <div class="align-items-center d-flex justify-content-center">
        <h1 style="color: #fff; margin-right: 10px;">Contactanos directamente a nuestro instagram</h1>
        <a href="https://instagram.com/lidertickets?igshid=YmMyMTA2M2Y=" target="_blank">
          <img src="./assets/img/instagram.png" alt="" style="width: 50px;">
        </a>
      </div>
      <!-- <div class="row">
        <div class="col-md-8 col-md-offset-2 conForm">
          <div id="message"></div>
          <form method="post" action="php/contact.php" name="cform" id="cform">
            <input name="name" id="name" type="text" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" placeholder="Indicanos tu Nombre">
            <input name="email" id="email" type="email" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 noMarr" placeholder="Indicanos tu Correo Electrónico">
            <textarea name="comments" id="comments" cols="" rows="" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" placeholder="Mensaje"></textarea>
            <input type="submit" id="submit" name="send" class="submitBnt" value="Enviar">
            <div id="simple-msg"></div>
          </form>
        </div>
      </div> -->
    </div>
  </section>
  <!-- contact section -->

  <div class="instFloat">
    <a href="https://instagram.com/lidertickets?igshid=YmMyMTA2M2Y=" target="_blank" title="Chatea con nosotros">
      <img src="./assets/img/Icono-Chat.png" alt="" srcset="">
    </a>
  </div>
  <!-- Footer section -->
  <?php include('./assets/components/footerIndex.php') ?>
  <!-- Footer section -->

  <!-- JS FILES -->
  <?php include('./assets/components/scriptIndex.php') ?>
  <script type="text/javascript" src="./assets/js/index.js"></script>
</body>

</html>
<?php ?>
<?php
$title = "Crear Evento";
$type = $_GET['type'];

switch ($type) {
  case 'presencial':
    $typeEvn = 1;
    break;
  case 'streaming':
    $typeEvn = 2;
    break;
  case 'mixto':
    $typeEvn = 3;
    break;
}

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

    <body class="g-sidenav-show   bg-gray-100 dashboard">
      <div class="min-height-300 bg-primary position-absolute w-100"></div>
      <?php include('../assets/components/nav.php') ?>
      <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <?php include('../assets/components/navBar.php') ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h3>¡Ingresa los datos de tu evento <?php echo $type ?>!</h3>
                </div>
                <div class="card-body">
                  <form method="POST" class="row" action="../assets/api/php/event/saveEvent.php?txt=Evento Registrado Satisfactoriamente" enctype="multipart/form-data">
                    <input type="hidden" name="idUser" value="<?php echo $rowUser['id'] ?>">
                    <input type="hidden" name="eventType" value="<?php echo $typeEvn ?>">
                    <div class="form-group col-md-4">
                      <label for="">Pais del evento</label>
                      <select class="form-control form-control-lg" name="pais" id="pais">
                        <option value="">Seleccione</option>
                        <option value="chile" selected>Chile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Tipo de evento</label>
                      <select class="form-control form-control-lg" name="tipo" id="tipo">
                        <option value="0" selected>Público</option>
                        <option value="1">Privado</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Evento para mayores de edad</label>
                      <select class="form-control form-control-lg" name="mayores" id="mayores">
                        <option value="0" selected="selected">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Nombre del evento</label>
                      <input type="text" name="nomEvent" class="form-control form-control-lg">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Categoria</label>
                      <select placeholder="Selecciona hasta 3 tags" class="form-control  form-control-lg select-tags pmd-select2-tags" name="categoria" id="cat">
                        <option value="-1">Selecione</option>

                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Artistas</label>
                      <input type="text" class="form-control form-control-lg" name="artista">
                    </div>
                    <div class="form-group col-md-12">
                      <label for="">Descripción del evento</label>
                      <textarea name="descripcion" id="" class="form-control form-control-lg"></textarea>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="datepicker-start">Fecha inicio del evento</label>
                        <input name="fechaIni" type="date" class="form-control form-control-lg" id="datepicker-start">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="datepicker-start">Hora inicio del evento</label>
                        <input name="horaIni" type="time" class="form-control form-control-lg" id="datepicker-start">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="datepicker-end">Fecha de finalización del evento</label>
                        <input name="fechaFin" type="date" class="form-control form-control-lg" id="datepicker-end">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="datepicker-end">Hora de finalización del evento</label>
                        <input name="horaFin" type="time" class="form-control form-control-lg" id="datepicker-end">
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Región</label>
                      <select name="region" id="regionCreate" class="form-control form-control-lg">
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Comuna</label>
                      <select name="comuna" id="comunaCreate" class="form-control form-control-lg">
                        <option value="-1">Seleccione Comuna</option>
                        <option value="-1">Seleccione Región</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Dirección</label>
                      <input name="dir" id="" class="form-control form-control-lg">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Lugar del evento</label>
                      <input type="text" name="lugar" id="" class="form-control form-control-lg">
                    </div>

                    <div class="form-group col-md-4">
                      <label for="">Flyer del evento</label>
                      <input type="file" name="flyer" id="" class="form-control form-control-lg">
                      <span style="color: #ff0000;font-size: 10px;">La imagen debe ser de 1080x1080px</span>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="">Banner del evento</label>
                      <input type="file" name="banner" id="" class="form-control form-control-lg">
                      <span style="color: #ff0000;font-size: 10px;">La imagen debe ser de 1583x380px</span>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="">Layout del local</label>
                      <input type="file" name="secflyer" id="" class="form-control form-control-lg">
                    </div>

                    <div class="form-group col-md-12 btnSubmin d-flex justify-content-end mt-4">
                      <input type="submit" value="Agregar evento" class="btn btn-lg btn-primary btn-lg mb-0">
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
      <script src="../assets/js/index.js"></script>
      <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $('#datepicker').datepicker({
          uiLibrary: 'bootstrap4'
        });
        $(document).ready(function() {
          $("#cat").load("../assets/api/ajaxSearch/selectCat.php");
        });
      </script>
    </body>

    </html>
<?php
  }
}
?>
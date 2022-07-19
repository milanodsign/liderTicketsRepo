<?php
$title = "Mis Eventos";
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
?>
    <!DOCTYPE html>
    <html lang="en">

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
                  <h3><?php echo $title ?></h3>
                </div>
                <div class="card-body">
                  <table class="display tabEvent  responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th scope="col">Afiche del Evento</th>
                        <th scope="col">Nombre del evento</th>
                        <th scope="col">Pais</th>
                        <th scope="col">Lugar</th>
                        <th scope="col">Código</th>
                        <th scope="col">Fecha y hora del evento</th>
                        <th scope="col">Entradas vendidas</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Suspender</th>
                        <th scope="col">Configuración</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqlEvents = "SELECT * FROM `eventos` WHERE `idUser`= " . $_SESSION['id'];
                      $resultEvents = $mysqli->query($sqlEvents);
                      while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
                        switch ($rowEvents['estado']) {
                          case 1:
                            $estado = 'Activo';
                            break;
                          case 0:
                            $estado = 'Suspendido';
                            break;
                        }
                      ?>
                        <tr>
                          <td scope="row"><img src="<?php echo $rowEvents['flyer'] ?>" alt=""></td>
                          <td><?php echo $rowEvents['nomEvent'] ?></td>
                          <td><?php echo $rowEvents['pais'] ?></td>
                          <td><?php echo $rowEvents['lugar'] ?></td>
                          <td><?php echo $rowEvents['id'] ?></td>
                          <td><?php echo $rowEvents['fechaIni'] . ' - ' . $rowEvents['horaIni'] ?></td>
                          <td></td>
                          <td><?php echo $estado ?></td>
                          <td><button class="btn btn-danger btn-lg btnTable"><i class="fa-solid fa-power-off"></i></button></td>
                          <td class="botonera">
                            <button class="btn btn-success btn-lg btnTable" title="Edita tu evento">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Crear Tickets" onclick="myTickets(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-ticket"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Tickets vendidos y cortesías enviadas">
                              <i class="fa-solid fa-money-bill-transfer"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Link del evento">
                              <i class="fa-solid fa-link"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Lista digital">
                              <i class="fa-solid fa-users"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title=" Activar Planimetría">
                              <i class="fa-solid fa-sitemap"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Envía cortesías">
                              <i class="fa-solid fa-envelope-open-text"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Resumen de Ventas">
                              <i class="fa-solid fa-cash-register"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Envía cortesías por base de datos">
                              <i class="fa-solid fa-envelope-open-text"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Informe de Ventas">
                              <i class="fa-solid fa-file-pen"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Edita y administra tus tickets">
                              <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Visitas">
                              <i class="fa-solid fa-chart-column"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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
        $(document).ready(function() {
          $('.tabEvent').DataTable({
            dom: 'Blfrtp',
            responsive: true,
            buttons: [{
              extend: 'excel',
              text: 'Descargar Listado',
              exportOptions: {
                modifier: {
                  page: 'current'
                }
              }
            }],
            "lengthMenu": [
              [50, -1],
              [50, "Todos"]
            ],
            "language": {
              "sProcessing": "Procesando...",
              "sLengthMenu": "Mostrando _MENU_ Eventos Registradas",
              "sZeroRecords": "No se encontraron resultados",
              "sEmptyTable": "Ningún dato disponible en esta tabla",
              "sInfo": "Mostrando Eventos del _START_ al _END_ de un total de _TOTAL_ Eventos",
              "sInfoEmpty": "Mostrando Empresas del 0 al 0 de un total de 0 Eventos",
              "sInfoFiltered": "(filtrado de un total de _MAX_ Eventos)",
              "sInfoPostFix": "",
              "sSearch": "Buscar Evento:",
              "sUrl": "",
              "sInfoThousands": ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
              },
              "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
            }
          });
        });
        const myTickets = (id, nomEvent) => {
          window.location.href = 'myTickets.php?id=' + id + '&nomEvent=' + nomEvent;
        }
      </script>
    </body>

    </html>
<?php
  }
}
?>
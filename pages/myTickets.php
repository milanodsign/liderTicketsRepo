<?php
$title = "Mis Tickets";
$idEvent = $_GET['id'];
$nomEvent = $_GET['nomEvent'];
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

    <body class="g-sidenav-show   bg-gray-100 ticketsList">
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
                <div class="align-items-center card-header d-flex justify-content-between pb-0">
                  <h3><?php echo $title . ' ' . $nomEvent ?></h3>
                  <input type="button" value="Agregar Tickets" class="btn btn-primary mb-0" onclick="ticketsCreateGo(`<?php echo $idEvent ?>`, `<?php echo $nomEvent ?>`)">
                </div>
                <div class="card-body">
                  <table class="display tabEvent  responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th scope="col">Nombre del Ticket</th>
                        <th scope="col">Disponibles</th>
                        <th scope="col">Comprados</th>
                        <th scope="col">Devueltos</th>
                        <th scope="col">Cortesías</th>
                        <th scope="col">Validadas</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqlEvents = "SELECT * FROM `ticketsType` WHERE `idEvent`= " . $idEvent;
                      $resultEvents = $mysqli->query($sqlEvents);
                      while ($rowTickets = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
                        switch ($rowTickets['estado']) {
                          case 0:
                            $estado = '<span class="estatus active"><i class="fa-solid fa-check"></i>Activo</span>';
                            break;
                          case 1:
                            $estado = '<span class="estatus soldOut"><i class="fa-solid fa-exclamation"></i>Agotado</span>';
                            break;
                          case 2:
                            $estado = '<span class="estatus courtesy"><i class="fa-solid fa-gift"></i>Cortesia</span>';
                            break;
                          case 3:
                            $estado = '<span class="estatus close"><i class="fa-solid fa-times"></i>Cerrado</span>';
                            break;
                          case 4:
                            $estado = '<span class="estatus rrpp"><i class="fa-solid fa-bullhorn"></i>Venta solo RRPP</span>';
                            break;
                        }
                      ?>
                        <tr>
                          <td><?php echo $rowTickets['name'] ?>
                            <br>
                            <?php echo $estado ?>
                          </td>
                          <td><?php echo $rowTickets['cant'] . ' de ' . $rowTickets['cant'] ?></td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>$<?php echo $rowTickets['price'] ?></td>
                          <td>$<?php echo $rowTickets['price'] ?></td>
                          <td class="botonera">
                            <button class="btn btn-danger btn-lg btnTable" title="Cerrar">
                              <i class="fa-solid fa-power-off"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Editar">
                              <i class="fa-solid fa-pen-to-square"></i>
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
              "sLengthMenu": "Mostrando _MENU_ Tickets Registradas",
              "sZeroRecords": "No se encontraron resultados",
              "sEmptyTable": "Ningún dato disponible en esta tabla",
              "sInfo": "Mostrando Tickets del _START_ al _END_ de un total de _TOTAL_ Tickets",
              "sInfoEmpty": "Mostrando Empresas del 0 al 0 de un total de 0 Tickets",
              "sInfoFiltered": "(filtrado de un total de _MAX_ Tickets)",
              "sInfoPostFix": "",
              "sSearch": "Buscar Tickets:",
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
        const ticketsCreateGo = (id, nomEvent) => {
          window.location.href = 'ticketsCreate.php?id=' + id + '&nomEvent=' + nomEvent;
        }
      </script>
    </body>

    </html>
<?php
  }
}
?>
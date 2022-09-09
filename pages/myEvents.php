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
include('../assets/api/php/functions/fechaEs.php');
require '../assets/api/conex/conexConfig.php';
if ($_SESSION['userType'] == 0) {
  $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
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
                  <h3><?php echo $title ?></h3>
                </div>
                <div class="card-body">
                  <table class="display tabEvent  table-responsive nowrap" style="width:100%">
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
                          <td scope="row"><img src="<?php echo '..'.$rowEvents['flyer'] ?>" alt=""></td>
                          <td><?php echo $rowEvents['nomEvent'] ?></td>
                          <td><?php echo $rowEvents['pais'] ?></td>
                          <td><?php echo $rowEvents['lugar'] ?></td>
                          <td><?php echo $rowEvents['id'] ?></td>
                          <td><?php echo fechaEs($rowEvents['fechaIni']) . ' - ' . date('h:i A', strtotime($rowEvents['horaIni'])) ?></td>
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
                            <button class="btn btn-success btn-lg btnTable" title="Tickets vendidos y cortesías enviadas" onclick="ticketsSale(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-money-bill-transfer"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Link del evento">
                              <i class="fa-solid fa-link"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Lista digital" onclick="digitalList(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-users"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title=" Activar Planimetría">
                              <i class="fa-solid fa-sitemap"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Envía cortesías"  onclick="sendCourtesy(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-envelope-open-text"></i>
                            </button>
                            <button class="btn btn-success btn-lg btnTable" title="Resumen de Ventas" onclick="salesSummary(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
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
          var table = $('.tabEvent').DataTable({
            dom: 'Blfrtpi',
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                exportOptions: {
                  modifier: {
                    page: 'all'
                  }
                }
              },
              {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                  modifier: {
                    page: 'all'
                  }
                }
              }
            ],
            "lengthMenu": [
              [10, 25, 50, 75, 100, -1],
              [10, 25, 50, 75, 100, "TODOS"]
            ],
            "language": {
              "aria": {
                "sortAscending": ": orden ascendente",
                "sortDescending": ": orden descendente"
              },
              "autoFill": {
                "cancel": "Cancelar",
                "fill": "Llenar todas las celdas con <i>%d&lt;\\\/i&gt;<\/i>",
                "fillHorizontal": "Llenar celdas horizontalmente",
                "fillVertical": "Llenar celdas verticalmente"
              },
              "buttons": {
                "collection": "Colección <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                "colvis": "Visibilidad de la columna",
                "colvisRestore": "Restaurar visibilidad",
                "copy": "Copiar",
                "copyKeys": "Presiona ctrl or u2318 + C para copiar los datos de la tabla al portapapeles.<br \/><br \/>Para cancelar, haz click en este mensaje o presiona esc.",
                "copySuccess": {
                  "_": "Copió %ds registros al portapapeles",
                  "1": "Copió un registro al portapapeles"
                },
                "copyTitle": "Copiado al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                  "_": "Mostrar %ds registros",
                  "-1": "Mostrar todos los registros"
                },
                "pdf": "PDF",
                "print": "Imprimir"
              },
              "datetime": {
                "amPm": [
                  "AM",
                  "PM"
                ],
                "hours": "Horas",
                "minutes": "Minutos",
                "months": {
                  "0": "Enero",
                  "1": "Febrero",
                  "10": "Noviembre",
                  "11": "Diciembre",
                  "2": "Marzo",
                  "3": "Abril",
                  "4": "Mayo",
                  "5": "Junio",
                  "6": "Julio",
                  "7": "Agosto",
                  "8": "Septiembre",
                  "9": "Octubre"
                },
                "next": "Siguiente",
                "previous": "Anterior",
                "seconds": "Segundos",
                "weekdays": [
                  "Dom",
                  "Lun",
                  "Mar",
                  "Mie",
                  "Jue",
                  "Vie",
                  "Sab"
                ]
              },
              "decimal": ",",
              "editor": {
                "close": "Cerrar",
                "create": {
                  "button": "Nuevo",
                  "submit": "Crear",
                  "title": "Crear nuevo registro"
                },
                "edit": {
                  "button": "Editar",
                  "submit": "Actualizar",
                  "title": "Editar registro"
                },
                "error": {
                  "system": "Ocurrió un error de sistema (&lt;a target=\"\\\" rel=\"nofollow\" href=\"\\\"&gt;Más información)."
                },
                "multi": {
                  "info": "Los elementos seleccionados contienen diferentes valores para esta entrada. Para editar y configurar todos los elementos de esta entrada con el mismo valor, haga clic o toque aquí, de lo contrario, conservarán sus valores individuales.",
                  "noMulti": "Esta entrada se puede editar individualmente, pero no como parte de un grupo.",
                  "restore": "Deshacer cambios",
                  "title": "Múltiples valores"
                },
                "remove": {
                  "button": "Eliminar",
                  "confirm": {
                    "_": "¿Está seguro de que desea eliminar %d registros?",
                    "1": "¿Está seguro de que desea eliminar 1 registro?"
                  },
                  "submit": "Eliminar",
                  "title": "Eliminar registro"
                }
              },
              "emptyTable": "Sin registros",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
              "infoEmpty": "Mostrando 0 a 0 de 0 registros",
              "infoFiltered": "(filtrado de _MAX_ registros)",
              "infoThousands": ".",
              "lengthMenu": "Mostrar _MENU_ registros",
              "loadingRecords": "Cargando...",
              "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
              },
              "processing": "Procesando...",
              "search": "Buscar:",
              "searchBuilder": {
                "add": "Agregar Condición",
                "button": {
                  "_": "Filtros (%d)",
                  "0": "Filtrar"
                },
                "clearAll": "Limpiar Todo",
                "condition": "Condición",
                "conditions": {
                  "array": {
                    "contains": "Contiene",
                    "empty": "Vacío",
                    "equals": "Igual",
                    "not": "Distinto",
                    "notEmpty": "No vacío",
                    "without": "Sin"
                  },
                  "date": {
                    "after": "Mayor",
                    "before": "Menor",
                    "between": "Entre",
                    "empty": "Vacío",
                    "equals": "Igual",
                    "not": "Distinto",
                    "notBetween": "No entre",
                    "notEmpty": "No vacío"
                  },
                  "number": {
                    "between": "Entre",
                    "empty": "Vacío",
                    "equals": "Igual",
                    "gt": "Mayor",
                    "gte": "Mayor o igual",
                    "lt": "Menor",
                    "lte": "Menor o igual",
                    "not": "Distinto",
                    "notBetween": "No entre",
                    "notEmpty": "No vacío"
                  },
                  "string": {
                    "contains": "Contiene",
                    "empty": "Vacío",
                    "endsWith": "Termina con",
                    "equals": "Igual",
                    "not": "Distinto",
                    "notEmpty": "No vacío",
                    "startsWith": "Comienza con"
                  }
                },
                "data": "Datos",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Filtros anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Filtro",
                "title": {
                  "_": "Filtros (%d)",
                  "0": "Filtrar"
                },
                "value": "Valor"
              },
              "searchPanes": {
                "clearMessage": "Limpiar todo",
                "collapse": {
                  "_": "Paneles de búsqueda (%d)",
                  "0": "Paneles de búsqueda"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda...",
                "title": "Filtros activos - %d"
              },
              "select": {
                "cells": {
                  "_": "%d celdas seleccionadas",
                  "1": "Una celda seleccionada"
                },
                "columns": {
                  "_": "%d columnas seleccionadas",
                  "1": "Una columna seleccionada"
                },
                "rows": {
                  "1": "Una fila seleccionada",
                  "_": "%d filas seleccionadas"
                }
              },
              "thousands": ".",
              "zeroRecords": "No se encontraron registros"
            }
          });
        });
        const myTickets = (id, nomEvent) => {
          window.location.href = 'myTickets.php?id=' + id + '&nomEvent=' + nomEvent;
        }
        const ticketsSale = (id, nomEvent) => {
          window.location.href = 'ticketsSale.php?id=' + id + '&nomEvent=' + nomEvent;
        }
        const digitalList = (id, nomEvent) => {
          window.location.href = 'digitalList.php?id=' + id + '&nomEvent=' + nomEvent;
        }
        const sendCourtesy = (id, nomEvent) => {
          window.location.href = 'sendCourtesy.php?id=' + id + '&nomEvent=' + nomEvent;
        }
        const salesSummary = (id, nomEvent) => {
          window.location.href = 'salesSummary.php?id=' + id + '&nomEvent=' + nomEvent;
        }
      </script>
    </body>

    </html>
<?php
  }
}
?>
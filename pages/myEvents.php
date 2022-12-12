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
                  <h3><?php echo $title ?></h3>
                </div>
                <div class="card-body">
                  <table class="display tabEvent table-responsive" style="width:100%">
                    <thead>
                      <tr>
                        <!-- <th scope="col">Afiche del Evento</th> -->
                        <th scope="col">Nombre del evento</th>
                        <th scope="col">Pais</th>
                        <th scope="col">Lugar</th>
                        <th scope="col">Código</th>
                        <th scope="col">Fecha y hora del evento</th>
                        <th scope="col">Tickets vendidos</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Suspender o Reactivar</th>
                        <th scope="col">Configuración</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqlEvents = "SELECT * FROM `eventos` WHERE (`estado`=1 OR `estado`=0) AND `idUser`= " . $_SESSION['id'];
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
                          <!-- <td scope="row"><img src="<?php echo '..' . $rowEvents['flyer'] ?>" alt=""></td> -->
                          <td style="text-transform: uppercase"><?php echo $rowEvents['nomEvent'] ?><span class="arrowResponsive"><i class="fa-sharp fa-solid fa-circle-chevron-down"></i></span></td>
                          <td style="text-transform: uppercase"><?php echo $rowEvents['pais'] ?></td>
                          <td><?php echo $rowEvents['lugar'] ?></td>
                          <td style="text-align: center;"><?php echo $rowEvents['id'] ?></td>
                          <td><?php echo fechaEs($rowEvents['fechaIni']) . ' - ' . date('h:i A', strtotime($rowEvents['horaIni'])) ?></td>
                          <td style="text-align: center;">
                            <?php
                            $salesCount = 0;
                            $sqlTS = "SELECT * FROM `ticketsSales` WHERE `idEvent`='" . $rowEvents['id'] . "' AND `status`=1";
                            $resultTS = $mysqli->query($sqlTS);;
                            $salesCount = mysqli_num_rows($resultTS);

                            echo $salesCount;
                            ?>
                          </td>
                          <td><?php echo $estado ?></td>
                          <td>
                            <?php
                            if ($rowEvents['estado'] == 1) {
                            ?>
                              <button class="btn btn-danger btn-lg btnTable" onclick="actionsEvent(`<?php echo $rowEvents['id'] ?>`,`<?php echo $rowEvents['nomEvent'] ?>`,0)" title="Suspender el Evento"><i class="fa-solid fa-power-off"></i></button>
                            <?php
                            } else {
                            ?>
                              <button class="btn btn-success btn-lg btnTable" onclick="actionsEvent(`<?php echo $rowEvents['id'] ?>`,`<?php echo $rowEvents['nomEvent'] ?>`,1)" title="Reactivar el Evento"><i class="fa-solid fa-power-off"></i></button>
                            <?php
                            }
                            ?>
                          </td>
                          <td class="botonera">
                            <button class="btn btn-success btn-lg btnTable" title="Edita tu evento" onclick="eventEdit(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['eventType'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Agregar banner del evento" onclick="addBanner(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-sharp fa-solid fa-images"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Crear Tickets" onclick="myTickets(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-ticket"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Tickets vendidos y cortesías enviadas" onclick="ticketsSale(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-money-bill-transfer"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Link del evento" onclick="window.location = 'event.php?id='+<?php echo $rowEvents['id'] ?>+'&nomEvent=' + `<?php echo $rowEvents['nomEvent'] ?>`">
                              <i class="fa-solid fa-link"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Lista digital" onclick="digitalList(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-users"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title=" Activar Planimetría">
                              <i class="fa-solid fa-sitemap"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Envía cortesías" onclick="sendCourtesy(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-envelope-open-text"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Resumen de Ventas" onclick="salesSummary(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
                              <i class="fa-solid fa-cash-register"></i>
                            </button>

                            <button class="btn btn-success btn-lg btnTable" title="Envía cortesías por base de datos" onclick="sendCourtesyMasive(`<?php echo $rowEvents['id'] ?>`, `<?php echo $rowEvents['nomEvent'] ?>`)">
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
        const actionsEvent = (idEvent, nomEvent, action) => {
          let mensaje = ''
          if (action === 0) {
            mensaje = "¿Deseas suspender el evento " + nomEvent + "?"
          } else {
            mensaje = "¿Deseas reactivar el evento " + nomEvent + "?"
          }
          let confirmacion = confirm(mensaje);
          if (confirmacion === true) {
            window.location.href = '../assets/api/php/event/actionsEvent.php?idEvent=' + idEvent + '&action=' + action;
          }

        }
        const eventEdit = (idEvent, type, nomEvent) => {
          window.location.href = 'eventEdit.php?idEvent=' + idEvent + '&type=' + type + '&nomEvent=' + nomEvent;
        }
        const addBanner = (idEvent, nomEvent) => {
          window.location.href = 'addBannerEvent.php?idEvent=' + idEvent + '&nomEvent=' + nomEvent;
        }
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
        const sendCourtesyMasive = (idEvent, nomEvent) => {
          window.location.href = 'courtesyDataBase.php?id=' + idEvent + '&nomEvent=' + nomEvent;
        }
      </script>
    </body>

    </html>
<?php
  }
}
?>
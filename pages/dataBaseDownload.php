<?php
$title = "Base de Datos";
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

        <body class="g-sidenav-show   bg-gray-100 bancos">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header pb-0">
                                        <h3><?php echo $title . ' - Usuarios que han asistido a tus eventos' ?></h3>
                                        <h4>Asistencia de usuarios a tus eventos en los ultimos 3 meses</h4>
                                    </div>
                                    <table class="display tabEvent table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Ult. Fecha de Compra</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Ultimo evento</th>
                                                <th>Tickets en LiderTickets</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlEvents = "SELECT * FROM `eventos` WHERE `idUser`= " . $_SESSION['id'];
                                            $resultEvents = $mysqli->query($sqlEvents);
                                            while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
                                                $sqlBD = "SELECT DISTINCT email, fechaValid, name,COUNT(name) tickets FROM courtesyTickets WHERE idEvent=" . $rowEvents['id'] . " GROUP BY name HAVING tickets > 0";
                                                $resultBD = $mysqli->query($sqlBD);
                                                $tickets = mysqli_num_rows($resultBD);
                                                while ($rowBD = $resultBD->fetch_array(MYSQLI_ASSOC)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $rowBD['fechaValid'] ?></td>
                                                        <td><?php echo $rowBD['name'] ?></td>
                                                        <td><?php echo $rowBD['email'] ?></td>
                                                        <td><?php echo $rowEvents['nomEvent'] ?></td>
                                                        <td><?php echo $tickets ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </main>

            <?php include('../assets/components/script.php') ?>

            <script>
                $(document).ready(function() {
                    var table = $('.tabEvent').DataTable({
                        dom: 'Blfrt',
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
                            [-1],
                            ["TODOS"]
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
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
            </script>

        </body>

        </html>
<?php
    }
}
?>
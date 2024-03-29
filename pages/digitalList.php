<?php
setlocale(LC_ALL, "es_ES");
$idEvent = $_GET['id'];
$nomEvent = $_GET['nomEvent'];
$title = "Lista Digital";
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
                                    <h3><?php echo $title . ' ' . $nomEvent ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                            $courtesyCount = 0;
        $salesCount = 0;
        $saleValidated = 0;
        $courtesyValidated = 0;
        $sqlCT = "SELECT * FROM `courtesyTickets` WHERE `idEvent`='" . $idEvent . "'";
        $resultCT = $mysqli->query($sqlCT);
        $courtesyCount = mysqli_num_rows($resultCT);

        $sqlCTV = "SELECT * FROM `courtesyTickets` WHERE `validated` = 1 AND `idEvent`='" . $idEvent . "'";
        $resultCTV = $mysqli->query($sqlCTV);
        $courtesyValidated = mysqli_num_rows($resultCTV);

        $sqlTS = "SELECT * FROM `ticketsSales` WHERE `idEvent`='" . $idEvent . "'";
        $resultTS = $mysqli->query($sqlTS);
        $salesCount = mysqli_num_rows($resultTS);

        $sqlTSV = "SELECT * FROM `ticketsSales` WHERE `validated` = 1 AND `idEvent`='" . $idEvent . "'";
        $resultTSV = $mysqli->query($sqlTSV);
        $saleValidated = mysqli_num_rows($resultTSV);

        $totalTickets = $courtesyCount + $salesCount;

        echo '<span class="align-items-center countTickets d-flex">
                                    <h4><b>Total de tickets:</b> ' . $totalTickets . '</h4>  |  <h4><b>Total vendidos:</b> ' . $salesCount . '</h4>  |  <h4><b>Total cortesias:</b> ' . $courtesyCount . '</h4>  |  <h4><b>Total vendidos validados:</b> ' . $saleValidated . '</h4>  |  <h4><b>Total cortesias validadas:</b> ' . $courtesyValidated . '</h4>
                                    </span>';
        ?>
                                    <table class="display tabTicketsSale  table-responsive table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">N° Documento</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Costo</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Hora</th>
                                                <th scope="col">ID Ticket</th>
                                                <th scope="col">Validado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                $sqlTC = "SELECT * FROM `courtesyTickets` WHERE `idEvent`='" . $idEvent . "'";
        $resultTC = $mysqli->query($sqlTC);
        while ($rowTC = $resultTC->fetch_array(MYSQLI_ASSOC)) {
            $sqlTTC = "SELECT * FROM `ticketsType` WHERE `id`= " . $rowTC['ticketType'];
            $resultTTC = $mysqli->query($sqlTTC);
            while ($rowTTC = $resultTTC->fetch_array(MYSQLI_ASSOC)) {
                $ticketNameTC = $rowTTC['name'];
            }
            $itemsTC[] = array(
                'name' => $rowTC['name'],
                'email' => $rowTC['email'],
                'numDoc' => '',
                'ticketName' => $ticketNameTC,
                'price' => 'Cortesía',
                'codTicket' => $rowTC['codTicket'],
                'validated' => $rowTC['validated'],
                'date' => $rowTC['sendDate'],
                'times' => $rowTC['sendTime']
            );
        }

        $total = 0;
        $sqlT = "SELECT * FROM `ticketsSales` WHERE `status`=1 AND `idEvent`='" . $idEvent . "'";
        $resultT = $mysqli->query($sqlT);
        while ($rowT = $resultT->fetch_array(MYSQLI_ASSOC)) {
            $sqlTT = "SELECT * FROM `ticketsType` WHERE `id`= " . $rowT['ticketType'];
            $resultTT = $mysqli->query($sqlTT);
            while ($rowTT = $resultTT->fetch_array(MYSQLI_ASSOC)) {
                $ticketNameTS = $rowTT['name'];
                $price = $rowTT['price'];
            }
            $itemsTS[] = array(
                'name' => $rowT['name'],
                'email' => $rowT['email'],
                'numDoc' => $rowT['numDoc'],
                'ticketName' => $ticketNameTS,
                'price' => $price,
                'codTicket' => $rowT['codTicket'],
                'validated' => $rowT['validated'],
                'date' => $rowT['shoppingDate'],
                'times' => $rowT['shoppingTime']
            );
        }

        if (isset($itemsTC)) {
            $arrayUnion = array_merge($itemsTS, $itemsTC);
        } elseif (isset($itemsTS)) {
            $arrayUnion = $itemsTS;
        } else {
            $arrayUnion[] = array(
                'name' => '',
                'email' => '',
                'numDoc' => '',
                'ticketName' => '',
                'price' => 'Cortesía',
                'codTicket' => '',
                'validated' => '',
                'date' => '',
                'times' => '',
            );
        }

        foreach ($arrayUnion as $item) {
            if ($item['price'] === 'Cortesía' || $item['price'] === '') {
                $price = $item['price'];
            } else {
                $price = '$' . number_format($item['price'], 2);
            }
            switch ($item['validated']) {
                case '1':
                    $validated = 'Si';
                    break;

                default:
                    $validated = '';
                    break;
            }
            ?>
                                                <tr>
                                                    <td><?php echo $item['name'] ?></td>
                                                    <td><?php echo $item['email'] ?></td>
                                                    <td><?php echo $item['numDoc'] ?></td>
                                                    <td><?php echo $item['ticketName'] ?></td>
                                                    <td><?php echo $price ?></td>
                                                    <td><?php echo date("d/m/Y", strtotime($item['date'])) ?></td>
                                                    <td><?php echo date('h:i A', strtotime($item['times'])) ?></td>
                                                    <td><?php echo $item['codTicket'] ?></td>
                                                    <td><?php echo $validated ?></td>
                                                </tr>
                                            <?php
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
                    var table = $('.tabTicketsSale').DataTable({
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
            </script>
        </body>

        </html>
<?php
    }
}
?>
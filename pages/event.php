<?php
setlocale(LC_ALL, "es_ES");
$idEvent = $_GET['id'];
$nomEvent = $_GET['nomEvent'];
$title = "Evento / " . $nomEvent;
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
if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1 || $_SESSION['userType'] == 2) {
    $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'];
    $result = $mysqli->query($sql);
    while ($rowUser = $result->fetch_array(MYSQLI_ASSOC)) {
        $idUser = $rowUser['id'];

        $sqlEvents = "SELECT * FROM `eventos` WHERE `id`=" . $idEvent;
        $resultEvents = $mysqli->query($sqlEvents);
        while ($row = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
?>
            <!DOCTYPE html>
            <html lang="es">

            <head>
                <?php include('../assets/components/header.php') ?>
                <script type="text/javascript" src="https://checkout.wompi.co/widget.js"></script>
            </head>

            <body class="g-sidenav-show   bg-gray-100 eventSale">
                <div class="min-height-300 bg-primary position-absolute w-100"></div>
                <?php include('../assets/components/nav.php') ?>
                <div class="main-content position-relative max-height-vh-100 h-100">
                    <!-- Navbar -->
                    <?php include('../assets/components/navBar.php') ?>
                    <!-- End Navbar -->
                    <section class="container-fluid py-4 eventContentInfo m-auto row section">

                        <div class="col-lg-9 col-md-6 col-sm-12">
                            <h1>
                                <?php if ($row['mayores'] = 1) {
                                    echo $row['nomEvent'] . ' <span style="color: #e09900">(+18)</span>';
                                } else {
                                    echo $row['nomEvent'];
                                } ?>
                            </h1>
                            <h2>
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>
                                    <?php echo fechaEs($row['fechaIni']) . ' - ' . date('h:i A', strtotime($row['horaIni'])) ?>
                                </span>
                            </h2>
                            <div class="card mt-5">
                                <div class="card-body">
                                    <form class="cantTickets d-flex flex-column" action="./checkOut.php" method="POST">
                                        <input type="hidden" name="nomEvent" value="<?php echo $nomEvent ?>">
                                        <input type="hidden" name="idEvent" value="<?php echo $idEvent ?>">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tipo de Ticket</th>
                                                    <th>Valor</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cont = 0;
                                                $sqlTickets = "SELECT * FROM `ticketsType` WHERE `idEvent`=" . $row['id'];
                                                $resultTickets = $mysqli->query($sqlTickets);
                                                while ($rowTickets = $resultTickets->fetch_array(MYSQLI_ASSOC)) {
                                                    $courtesyTotal = 0;
                                                    $saleTotal = 0;
                                                    $cancelTotal = 0;

                                                    $sumaTotalSales = 0;
                                                    $sumaTotalCancel = 0;
                                                    $total = 0;

                                                    $sqlCT = "SELECT * FROM `courtesyTickets` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'];
                                                    $resultCT = $mysqli->query($sqlCT);;
                                                    $courtesyCount = mysqli_num_rows($resultCT);
                                                    $courtesyTotal += $courtesyCount;

                                                    $sqlTS = "SELECT * FROM `ticketsSales` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'] . " AND `status` = 1";
                                                    $resultTS = $mysqli->query($sqlTS);;
                                                    $salesCount = mysqli_num_rows($resultTS);
                                                    $saleTotal += $salesCount;

                                                    $sqlCancelT = "SELECT * FROM `ticketsSales` WHERE `idEvent`=" . $idEvent . " AND `ticketType` =" . $rowTickets['id'] . " AND `status` = 0";
                                                    $resultCancelT = $mysqli->query($sqlCancelT);;
                                                    $cancelCount = mysqli_num_rows($resultCancelT);
                                                    $cancelTotal += $cancelCount;

                                                    $ticketsDisponibles = $rowTickets['cant'] - (($courtesyCount + $salesCount) - $cancelCount);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $rowTickets['name'] ?>
                                                            <input type="hidden" name="idTicket[]" value="<?php echo $rowTickets['id'] ?>" />
                                                        </td>
                                                        <td>
                                                            <?php echo '$' . number_format($rowTickets['price'], 2) ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($ticketsDisponibles <= 0) {
                                                                echo '<span class="soldOut">AGOTADO</span>';
                                                            } else { ?>
                                                                <select class="form-control form-control-lg" name="cant[]" id="cant[]">
                                                                    <?php
                                                                    for ($cant = 0; $cant <= 6; $cant++) {
                                                                        echo '<option value="' . $cant . '">' . $cant . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $cont = $cont + 1;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-primary">Comprar</button>
                                    </form>
                                    <div class="description">
                                        <p>
                                            <?php if ($row['mayores'] = 1) {
                                                echo '<span style="color: #ff0000; display: flex;">Evento solo para Mayores de 18 Años.</span>';
                                            } ?>
                                            <?php echo $row['descripcion'] ?>
                                        </p>
                                    </div>
                                    <span>Los comentarios y/o textos ingresados son de exclusiva responsabilidad del Productor y/o
                                        Organizador del Evento. LiderTickets no se hace responsable por declaraciones emitidas por estos en
                                        lo relativo a los Eventos. El Productor/Organizador es el único y exclusivo responsable de la
                                        producción y organización del Evento, en forma oportuna y en conformidad a la ley.</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-12 row">
                            <span class="d-flex justify-content-end">
                                <span>
                                    <i class="fa-solid fa-location-arrow"></i>
                                </span>
                                <span class="d-flex flex-column">
                                    <h2>
                                        <?php echo $row['lugar']; ?>
                                    </h2>
                                    <h2>
                                        <span>
                                            <?php echo $row['dir'] ?>
                                        </span>
                                    </h2>
                                </span>
                            </span>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <span class="flyerEvent" style="background: url('<?php echo 'https://lidertickets.co' . $row['flyer'] ?>');  background-position: center; background-repeat: no-repeat; background-size: cover; margin: 0; width: 100%; height: 300px;"></span>
                                    <span class="titleOtherEvent d-flex justify-content-center">
                                        <?php
                                        $sqlProduct = "SELECT * FROM `producerData` WHERE `idUser`='" . $idUser . "'";
                                        $resultProduct = $mysqli->query($sqlProduct);
                                        while ($rowProduct = $resultProduct->fetch_array(MYSQLI_ASSOC)) {
                                        ?>
                                            <h1>
                                                <?php echo $rowProduct['nomProd'] ?>
                                            </h1>
                                        <?php
                                        }
                                        ?>
                                    </span>
                                    <span class="titleOtherEvent d-flex justify-content-center">
                                        <h3>Otros eventos de esta Productora</h3>
                                    </span>
                                    <div id="evntListProd" class="carousel slide">
                                        <?php
                                        $sqlEvents = "SELECT * FROM `eventos` WHERE `idUser`='" . $idUser . "' AND `estado`= 1 ";
                                        $resultEvents = $mysqli->query($sqlEvents);
                                        while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
                                        ?>
                                            <div>
                                                <a href="<?php echo '?nomEvent=' . $rowEvents['nomEvent'] . '&id=' . $rowEvents['id'] ?>">
                                                    <img class="d-block w-100" src="<?php echo 'https://lidertickets.co' . $rowEvents['flyer']  ?>" alt="<?php echo $rowEvents['nomEvent']  ?>">
                                                </a>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                    <?php include('../assets/components/footer.php') ?>
                </div>
                </div>
                <?php include('../assets/components/script.php') ?>
                <!-- <script src="../assets/js/custom.js"></script> -->
                <script>
                    $(document).ready(function() {
                        $(".carousel").slick({
                            infinite: true,
                            speed: 300,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            responsive: [{
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3,
                                        infinite: true,
                                        dots: true,
                                    },
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2,
                                    },
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                    },
                                },
                            ],
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
}
?>
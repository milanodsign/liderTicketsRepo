<?php
setlocale(LC_ALL, "es_ES");
$idEvent = $_GET['id'];
$nomEvent = $_GET['nomEvent'];
$title = "Evento / " . $nomEvent . " / Mercado Pago";
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
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
            <script src="https://sdk.mercadopago.com/js/v2"></script>
        </head>

        <body class="g-sidenav-show   bg-gray-100 eventSale">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <div class="main-content position-relative max-height-vh-100 h-100">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <?php
                    $sqlEvents = "SELECT * FROM `eventos` WHERE `id`=" . $idEvent;
                    $resultEvents = $mysqli->query($sqlEvents);
                    while ($rowEvents = $resultEvents->fetch_array(MYSQLI_ASSOC)) {
                        $id = $rowEvents['id'];
                    ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card eventImg">
                                    <div class="card-body">
                                        <div class="imgEvent" style="background: url(<?php echo $rowEvents['flyer'] ?>);background-position: center; background-repeat: no-repeat;background-size: cover;">
                                        </div>
                                        <div class="infoEventContact">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div id="cardPaymentBrick_container"></div>
                                </div>
                            </div>

                        </div>
                    <?
                    }
                    ?>
                    <?php include('../assets/components/footer.php') ?>
                </div>
            </div>
            <?php include('../assets/components/script.php') ?>
            <script>
                $(document).ready(function() {
                    const mp = new MercadoPago("APP_USR-beaf9490-6e0f-4775-9631-c5a976505f60");
                    const bricksBuilder = mp.bricks({
                        theme: 'bootstrap'
                    });

                    const renderCardPaymentBrick = async (bricksBuilder) => {

                        const settings = {
                            initialization: {
                                amount: 100, //valor del pago a realizar
                                current: 'COP',
                                locale: "es-CO",
                            },
                            customization: {
                                visual: {
                                    style: {
                                        theme: 'dark' | 'default' | 'bootstrap' | 'flat'
                                    }
                                }
                            },
                            callbacks: {
                                onReady: () => {
                                    // callback llamado cuando Brick esté listo
                                },
                                onSubmit: (cardFormData) => {
                                    // callback llamado cuando el usuario haga clic en el botón enviar los datos

                                    // ejemplo de envío de los datos recolectados por el Brick a su servidor
                                    return new Promise((resolve, reject) => {
                                        fetch("/process_payment", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                },
                                                body: JSON.stringify(cardFormData)
                                            })
                                            .then((response) => {
                                                // recibir el resultado del pago
                                                resolve();
                                            })
                                            .catch((error) => {
                                                // tratar respuesta de error al intentar crear el pago
                                                reject();
                                            })
                                    });
                                },
                                onError: (error) => {
                                    // callback llamado para todos los casos de error de Brick
                                },
                            },
                        };
                        const cardPaymentBrickController = await bricksBuilder.create('cardPayment', 'cardPaymentBrick_container', settings);
                    };
                    renderCardPaymentBrick(bricksBuilder);
                });


                let win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    let options = {
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
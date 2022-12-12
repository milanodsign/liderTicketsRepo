<?php
$title = "Editar Usuario";
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
                        <div class="align-items-start col-md-4 d-flex justify-content-center">
                            <img class="w-100" src="../assets/img/logo.svg" alt="" srcset="">
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="../assets/api/php/users/actUser.php" class="row" method="post">
                                        <input class="form-control form-control-lg" type="hidden" name="idUser" value="<?php echo $rowUser['id'] ?>">
                                        <h2>Edita tus datos Personales</h2>
                                        <div class="col-md-12">
                                            <label for="name"><span class="t_ubicacion">Nombre:</span></label>
                                            <input class="form-control form-control-lg" type="text" name="name" id="name" value="<?php echo $rowUser['name'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mail"><span class="t_ubicacion">Correo Electrónico:</span></label>
                                            <input class="form-control form-control-lg" type="email" name="mail" id="mail" value="<?php echo $rowUser['mail'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone"><span class="t_ubicacion">Teléfono:</span></label>
                                            <input class="form-control form-control-lg" type="tel" name="phone" id="phone" value="<?php echo $rowUser['phone'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pass"><span class="t_ubicacion">Contraseña:</span></label>
                                            <input class="form-control form-control-lg" type="password" name="pass" id="pass" value="<?php echo $rowUser['pass'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pass1"><span class="t_ubicacion">Repita contraseña:</span></label>
                                            <input class="form-control form-control-lg" type="password" id="pass1" value="<?php echo $rowUser['pass'] ?>" onblur="valPass()" required>
                                            <span class="valPass">Las contraseñas no coinciden</span>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-end mt-4">
                                            <input class="btn btn-lg btn-primary btn-lg mb-0" type="submit" value="Editar Usuario" class="btn btn-lg btn-primary w-100 mt-4 mb-0" id="btnEditUser">
                                        </div>
                                    </form>
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
                    $("#banco").load('../assets/api/ajaxSearch/selectBank.php');
                });

                const valPass = () => {
                    let pass = $("#pass").val();
                    let valPass = $("#pass1").val();
                    if (valPass !== pass) {
                        $(".valPass").addClass("active");
                        $("#btnEditUser").prop("disabled", true);
                    } else {
                        $(".valPass").removeClass("active");
                        $("#btnEditUser").prop("disabled", false);
                    }
                };
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
<?php
$title = "Datos de la Productora";
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
        <html lang="es">

        <head>
            <?php include('../assets/components/header.php') ?>
        </head>

        <body class="g-sidenav-show   bg-gray-100 dashboard">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php include('../assets/components/nav.php') ?>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                <?php include('../assets/components/navBar.php') ?>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card eventImg">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <article>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <h2>Datos como Productor</h2>
                                        <div class="div-100">
                                            <label for="banco"><span class="t_ubicacion">País:</span></label>
                                            <select id="pais_actual_usr" name="pais_actual_usr" disabled="disabled">
                                                <option value="" selected="selected">Selecciona comuna...</option>
                                                <option value="argentina">Argentina</option>
                                                <option value="chile" selected="">Chile</option>
                                                <option value="mexico">México</option>
                                                <option value="paraguay">Paraguay</option>
                                                <option value="peru">Perú</option>
                                                <option value="uruguay">Uruguay</option>
                                                <option value="bolivia">Bolivia</option>
                                                <option value="colombia">Colombia</option>
                                                <option value="ecuador">Ecuador</option>
                                                <option value="usa">USA</option>
                                                <option value="espana">España</option>
                                                <option value="panama">Panamá</option>
                                                <option value="venezuela">Venezuela</option>
                                                <option value="brasil">Brasil</option>
                                                <option value="costarica">Costa Rica</option>
                                                <option value="dominicana">Republica Dominicana</option>
                                            </select>
                                        </div>
                                        <p style="font-size: 15px">
                                            Esta información será privada. En tus eventos solo indicaremos el nombre de tu productora.
                                            &nbsp;Los datos serán usados para la confección de las facturas asociadas al resultado de sus eventos.
                                        </p>
                                        <div class="div-100">
                                            <label for="nombre_fantasia"><span class="t_ubicacion">Nombre de Fantasía:</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="nombre_fantasia" id="nombre_fantasia" value="QUEENS" placeholder="Escribe el nombre aquí" spellcheck="false" data-ms-editor="true" class="valid">
                                        </div>
                                        <div class="div-50">
                                            <label for="rut_organizador"><span class="t_ubicacion">RUT:</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="rut_organizador" id="rut_organizador" value="77120889-4" placeholder="Escribe el RUT aquí" spellcheck="false" data-ms-editor="true">
                                        </div>

                                        <div class="div-50">
                                            <label for="nombre"><span class="t_ubicacion">Razón Social o Nombre Completo:</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="nombre_organizador" id="nombre_organizador" value="QUEENS SPA" placeholder="Escribe el nombre aquí" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <div class="div-50">
                                            <label for="giro_organizador"><span class="t_ubicacion">Giro Comercial o Rubro:</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="giro_organizador" id="giro_organizador" value="PRODUCTORA" placeholder="Escribe el giro aquí" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <div class="div-50">
                                            <label for="direccion_organizador"><span class="t_ubicacion">Dirección Comercial:</span></label>
                                            <input class="form-control form-control-lg" type="text" size="50" name="direccion_organizador" id="direccion_organizador" value="AV NUEVA PROVIDENCIA 1881" placeholder="Escribe la dirección aquí" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <div class="div-50">
                                            <label class="aux1" for="region">Región:</label>
                                            <select class="form-control form-control-lg" name="region" id="region">
                                                <option value="">Selecciona...</option>
                                                <option value="13" selected="selected">Región Metropolitana de Santiago</option>
                                                <option value="1">I Región de Tarapacá</option>
                                                <option value="14">XIV Región de Los Ríos</option>
                                                <option value="12">XII Región de Magallanes y Antártica</option>
                                                <option value="11">XI Región de Aysén</option>
                                                <option value="10">X Región de Los Lagos</option>
                                                <option value="9">IX Región de la Araucanía</option>
                                                <option value="8">VIII Región del Biobío</option>
                                                <option value="7">VII Región del Maule</option>
                                                <option value="6">VI Región del Libertador General Bernardo O'Higgins</option>
                                                <option value="5">V Región de Valparaíso</option>
                                                <option value="4">IV Región de Coquimbo</option>
                                                <option value="3">III Región de Atacama</option>
                                                <option value="2">II Región de Antofagasta</option>
                                                <option value="15">XV Región de Arica y Parinacota</option>
                                            </select>
                                        </div>
                                        <div class="div-50">
                                            <label for="comuna"><span class="t_ubicacion">Comuna:</span></label>
                                            <select class="form-control form-control-lg" name="sin_comuna" id="comunaInicial">
                                                <option value="">Selecciona...</option>
                                                <option value="1310">Ñuñoa</option>
                                                <option value="1346">Alhué</option>
                                                <option value="1340">Buin</option>
                                                <option value="1342">Calera de Tango</option>
                                                <option value="1325">Cerrillos</option>
                                                <option value="1330">Cerro Navia</option>
                                                <option value="1333">Colina</option>
                                                <option value="1303">Conchalí</option>
                                                <option value="1345">Curacaví</option>
                                                <option value="1321">El Bosque</option>
                                                <option value="1351">El Monte</option>
                                                <option value="1324">Estacion Central</option>
                                                <option value="1304">Huechuraba</option>
                                                <option value="1302">Independencia</option>
                                                <option value="1350">Isla de Maipo</option>
                                                <option value="1320">La Cisterna</option>
                                                <option value="1314">La Florida</option>
                                                <option value="1316">La Granja</option>
                                                <option value="1317">La Pintana</option>
                                                <option value="1311">La Reina</option>
                                                <option value="1334">Lampa</option>
                                                <option value="1309">Las Condes</option>
                                                <option value="1308">Lo Barnechea</option>
                                                <option value="1323">Lo Espejo</option>
                                                <option value="1328">Lo Prado</option>
                                                <option value="1312">Macul</option>
                                                <option value="1326">Maipú</option>
                                                <option value="1344">María Pinto</option>
                                                <option value="1343">Melipilla</option>
                                                <option value="1352">Padre Hurtado</option>
                                                <option value="1341">Paine</option>
                                                <option value="1349">Peñaflor</option>
                                                <option value="1313">Peñalolén</option>
                                                <option value="1322">Pedro Aguirre Cerda</option>
                                                <option value="1338">Pirque</option>
                                                <option value="1306">Providencia</option>
                                                <option value="1329">Pudahuel</option>
                                                <option value="1336">Puente Alto</option>
                                                <option value="1332">Quilicura</option>
                                                <option value="1327">Quinta Normal</option>
                                                <option value="1305">Recoleta</option>
                                                <option value="1331">Renca</option>
                                                <option value="1339">San Bernardo</option>
                                                <option value="1315">San Joaquín</option>
                                                <option value="1337">San José de Maipo</option>
                                                <option value="1319">San Miguel</option>
                                                <option value="1347">San Pedro</option>
                                                <option value="1318">San Ramón</option>
                                                <option value="1301">Santiago</option>
                                                <option value="1348">Talagante</option>
                                                <option value="1335">Tiltil</option>
                                                <option value="1307">Vitacura</option>
                                            </select>
                                        </div>
                            </div>
                            <div class="div-50">
                                <label for="telefono_organizador"><span class="t_ubicacion">Teléfono Organización:</span></label>
                                <input class="form-control form-control-lg" type="text" size="50" name="telefono_organizador" id="telefono_organizador" value="+56973259109" placeholder="Escribe el teléfono aquí" spellcheck="false" data-ms-editor="true">
                            </div>
                            <div class="div-50">
                                <label for="email_organizador"><span class="t_ubicacion">Email Organización:</span></label>
                                <input class="form-control form-control-lg" type="text" size="50" name="email_organizador" id="email_organizador" value="info@lidertickets.com" placeholder="Escribe el email aquí" spellcheck="false" data-ms-editor="true">
                            </div>

                            <div class="">
                                <label for="descripcion_organizador"><span class="t_ubicacion">Descripción :</span></label>
                                <textarea name="descripcion_organizador" id="descripcion_organizador" placeholder="Describe aquí a tu productora de manera breve y precisa." style="font: 400 13.3333px Arial;" spellcheck="false" data-ms-editor="true"></textarea>
                            </div>
                            <div>
                                <a href="perfil" class="btn-vol"><i class="icon-left-open"></i>Volver</a>
                                <input class="form-control form-control-lg" type="submit" name="button2" id="button2" class="btn" value="GUARDAR">
                            </div>
                            </form>
                            <form name="country_usr_change" id="country_usr_change" method="post" enctype="multipart/form-data" action="https://www.passline.com/datos-organizador-2">
                                <input class="form-control form-control-lg" type="hidden" name="pais_usr_2" id="pais_usr_2" value="">
                            </form>
                            </article>
                        </div>
                    </div>

                </div>
                <?php include('../assets/components/footer.php') ?>
                </div>
            </main>

            <?php include('../assets/components/script.php') ?>

            <script>
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
<?php
$title = "Editar Evento";
$type = $_GET['type'];
$idEvent = $_GET['idEvent'];
$nomEvent = $_GET['nomEvent'];

switch ($type) {
  case 'presencial':
    $typeEvn = 1;
    break;
  case 'streaming':
    $typeEvn = 2;
    break;
  case 'mixto':
    $typeEvn = 3;
    break;
}

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
                  <h3>Editas los datos de tu evento <?php echo $nomEvent ?>!</h3>
                </div>
                <div class="card-body">
                  <form method="POST" class="row" action="../assets/api/php/event/editEvent.php" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM `eventos` WHERE `id`= '" . $idEvent . "'"; 
                    $result = $mysqli->query($sql);
                    while ($rowEvent = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>
                      <input type="hidden" name="idEvent" id="idEvent" value="<?php echo $rowEvent['id'] ?>">
                      <input type="hidden" name="eventType" value="<?php echo $type ?>">
                      <div class="form-group col-md-4">
                        <label for="">Pais del evento</label>
                        <select class="form-control form-control-lg" name="pais" id="pais">
                          <option value="chile" selected>Chile</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Tipo de evento</label>
                        <select class="form-control form-control-lg" name="tipo" id="tipo">
                          <option value="0" selected>Público</option>
                          <option value="1">Privado</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Evento para mayores de edad</label>
                        <select class="form-control form-control-lg" name="mayores" id="mayores">
                          <option value="0" selected="selected">NO</option>
                          <option value="1">SI</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Nombre del evento</label>
                        <input type="text" name="nomEvent" class="form-control form-control-lg" value="<?php echo $rowEvent['nomEvent'] ?>">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Categoria</label>
                        <select placeholder="Selecciona hasta 3 tags" class="form-control  form-control-lg select-tags pmd-select2-tags" name="categoria">
                          <option value="55">Acción</option>
                          <option value="3149">Acid</option>
                          <option value="3172">Acid House</option>
                          <option value="1455">Administración &amp; Finanzas</option>
                          <option value="3196">Afro</option>
                          <option value="94">Alternative Metal</option>
                          <option value="3152">Ambien</option>
                          <option value="95">American Hip Hop</option>
                          <option value="69">Animación</option>
                          <option value="84">Anime</option>
                          <option value="3125">Arcade</option>
                          <option value="28">Automovilismo</option>
                          <option value="56">Aventuras</option>
                          <option value="78">Épicas</option>
                          <option value="1443">Ópera</option>
                          <option value="96">Bachata</option>
                          <option value="2499">Badminton</option>
                          <option value="97">Baladas</option>
                          <option value="31">Baloncesto</option>
                          <option value="2652">Balonmano</option>
                          <option value="3183">Bass</option>
                          <option value="30">Béisbol</option>
                          <option value="74">Bélicas</option>
                          <option value="3144">Beach Volleyball</option>
                          <option value="27">Bicicletadas</option>
                          <option value="1458">Bienestar</option>
                          <option value="3180">Bigroom</option>
                          <option value="98">Blues</option>
                          <option value="99">Bolero</option>
                          <option value="100">Bossa Nova</option>
                          <option value="3171">Breaks</option>
                          <option value="3121">Cachengue</option>
                          <option value="1434">Carnaval</option>
                          <option value="2805">Carreras</option>
                          <option value="101">Celta</option>
                          <option value="3148">Chicago</option>
                          <option value="3166">Chicago House</option>
                          <option value="57">Ciencia Ficción</option>
                          <option value="1452">Ciencias Políticas</option>
                          <option value="54">Cine</option>
                          <option value="67">Cine 2D</option>
                          <option value="82">Cine Alternativo</option>
                          <option value="79">Cine de Autor</option>
                          <option value="81">Cine de Culto</option>
                          <option value="83">Cine Experimental</option>
                          <option value="80">Cine Independiente</option>
                          <option value="65">Cine Mudo</option>
                          <option value="66">Cinema Sonoro</option>
                          <option value="88">Circo Infantil</option>
                          <option value="3140">circo Los Tachuelas</option>
                          <option value="1632">Circos</option>
                          <option value="3126">Circuito</option>
                          <option value="50">Clásica</option>
                          <option value="58">Comedia</option>
                          <option value="1989">Comedia Americana</option>
                          <option value="2040">Comedia Hispana</option>
                          <option value="1938">Comedia Latina</option>
                          <option value="92">Comics</option>
                          <option value="1460">Comunicación</option>
                          <option value="1461">Comunicación Efectiva</option>
                          <option value="93">Conciertos</option>
                          <option value="3206">Cortometraje</option>
                          <option value="3168">Cosmic</option>
                          <option value="11">Country</option>
                          <option value="73">Crimen</option>
                          <option value="104">Criollo</option>
                          <option value="1420">Crowfunding</option>
                          <option value="3110">Cueca</option>
                          <option value="9">Cumbia</option>
                          <option value="3127">Cumbia / Guachaca</option>
                          <option value="3122">Cumbia Guachaca</option>
                          <option value="1448">Cursos / Talleres</option>
                          <option value="3193">Dance Hall</option>
                          <option value="206">Dancehall</option>
                          <option value="257">Death Metal</option>
                          <option value="2856">Decathlon</option>
                          <option value="3164">Deep house</option>
                          <option value="76">Deportivas</option>
                          <option value="1427">Despedida de soltero</option>
                          <option value="3146">Detroit</option>
                          <option value="3165">Detroit House</option>
                          <option value="25">Disco</option>
                          <option value="3123">Discoteca</option>
                          <option value="359">Djent</option>
                          <option value="3207">Documental</option>
                          <option value="410">Doom Metal</option>
                          <option value="3153">Downbeat</option>
                          <option value="3128">Drag</option>
                          <option value="60">Drama</option>
                          <option value="3185">Drum &amp; Bass</option>
                          <option value="461">Dub</option>
                          <option value="3182">Dub House</option>
                          <option value="3147">Dub techno</option>
                          <option value="3194">Dub-Roots</option>
                          <option value="512">Dubstep</option>
                          <option value="3186">Dubstep /Bass</option>
                          <option value="563">Early Reggae</option>
                          <option value="5">Electrónica</option>
                          <option value="3150">Electro</option>
                          <option value="614">Electro pop</option>
                          <option value="3112">Electro Tango</option>
                          <option value="3179">Electro-House</option>
                          <option value="3156">Electronic</option>
                          <option value="3129">Estrategia</option>
                          <option value="1478">Evento Familiar</option>
                          <option value="85">Evento Infantil</option>
                          <option value="90">Evento Infantil Educativo</option>
                          <option value="2907">Eventos Culturales</option>
                          <option value="2142">Eventos Deportivos</option>
                          <option value="38">Excursión</option>
                          <option value="1480">Experiencias Familiares</option>
                          <option value="1479">Experiencias Gastronómicas</option>
                          <option value="3161">Experimental</option>
                          <option value="1447">Familiar</option>
                          <option value="61">Fantasía</option>
                          <option value="3131">Fútbol</option>
                          <option value="3009">Ferias / Congresos</option>
                          <option value="3113">Festival</option>
                          <option value="1477">Festival de Cine</option>
                          <option value="3205">Festival de Cine Documental</option>
                          <option value="1469">Festival de Cumbia</option>
                          <option value="1476">Festival de Experiencias</option>
                          <option value="1472">Festival de Gastronomía</option>
                          <option value="1470">Festival de Hip Hop</option>
                          <option value="1471">Festival de Integración de géneros musicales</option>
                          <option value="3197">Festival de la Cerveza</option>
                          <option value="1466">Festival de Música Electrónica</option>
                          <option value="1467">Festival de Metal</option>
                          <option value="3130">Festival de Punk</option>
                          <option value="1468">Festival de Rock</option>
                          <option value="1474">Festival Industria del Entretenimiento</option>
                          <option value="1475">Festival Mixto</option>
                          <option value="1473">Festival Profesional</option>
                          <option value="1531">Festivales Sociales</option>
                          <option value="89">Fiesta</option>
                          <option value="1432">Fiesta Año Nuevo</option>
                          <option value="1424">Fiesta de cumpleaños</option>
                          <option value="1426">Fiesta de disfraces</option>
                          <option value="1431">Fiesta Navidad</option>
                          <option value="1425">Fiesta patronal</option>
                          <option value="1430">Fiesta Privada</option>
                          <option value="1429">Fiesta Religiosa</option>
                          <option value="1433">Fiesta Reyes</option>
                          <option value="1428">Fiesta Sorpresa</option>
                          <option value="1423">Fiestas</option>
                          <option value="1437">Fiestas Del Orgullo LGBTQIA+</option>
                          <option value="1435">Fiestas Grupales</option>
                          <option value="1436">Fiestas Mixtas</option>
                          <option value="3139">Fiestas Patrias</option>
                          <option value="3174">Filter house</option>
                          <option value="20">Flamenco</option>
                          <option value="817">Folk</option>
                          <option value="3117">Folklore</option>
                          <option value="3138">Fonda</option>
                          <option value="2703">Formula 1</option>
                          <option value="2754">Formula E</option>
                          <option value="3176">French</option>
                          <option value="868">Funk</option>
                          <option value="919">Funk Metal</option>
                          <option value="3178">Funky</option>
                          <option value="29">Futbol</option>
                          <option value="71">Futuristas</option>
                          <option value="2958">Gamer</option>
                          <option value="970">Garage Rock</option>
                          <option value="1449">Gastronomía</option>
                          <option value="1021">Glam Metal</option>
                          <option value="32">Golf</option>
                          <option value="1072">Gospel</option>
                          <option value="3187">Grime</option>
                          <option value="1123">Groove Metal</option>
                          <option value="1174">Grunge</option>
                          <option value="3204">Halloween</option>
                          <option value="1225">Hard Rock</option>
                          <option value="3158">hardcore</option>
                          <option value="3155">Hardtechno</option>
                          <option value="3188">Headz</option>
                          <option value="1327">Heavy Metal</option>
                          <option value="1378">Hip Hop</option>
                          <option value="3191">Hip-Hop</option>
                          <option value="75">Históricas</option>
                          <option value="33">Hockey</option>
                          <option value="14">House</option>
                          <option value="1734">Humor / Stand Up Comedy</option>
                          <option value="1450">Idiomas</option>
                          <option value="1380">Indie</option>
                          <option value="3157">industrial</option>
                          <option value="1446">Infantil</option>
                          <option value="3169">Italo</option>
                          <option value="1381">Jazz</option>
                          <option value="51">Jazz / Blues</option>
                          <option value="3177">Jazzy House</option>
                          <option value="1382">K-Pop</option>
                          <option value="13">KPOP</option>
                          <option value="3175">latin</option>
                          <option value="1383">Latin Hip Hop</option>
                          <option value="1453">Liderazgo</option>
                          <option value="35">Lucha</option>
                          <option value="86">Magia</option>
                          <option value="26">Maratón</option>
                          <option value="3114">Música Africana</option>
                          <option value="3115">Música Árabe</option>
                          <option value="3201">Música Bailable</option>
                          <option value="3116">Música Chilena</option>
                          <option value="3141">Música Clásica</option>
                          <option value="3199">Música de los 80</option>
                          <option value="3200">Música de los 90</option>
                          <option value="3124">Música Disco</option>
                          <option value="3120">Música Folklorica Argentina</option>
                          <option value="3143">Música Ranchera</option>
                          <option value="1456">Medicina</option>
                          <option value="1384">Melodic Death Metal</option>
                          <option value="1385">Merengue</option>
                          <option value="1386">Metal</option>
                          <option value="1387">Metalcore</option>
                          <option value="3162">Minimal</option>
                          <option value="1444">Monólogo</option>
                          <option value="40">Montaña</option>
                          <option value="1451">Music Business</option>
                          <option value="3118">musica folklorica</option>
                          <option value="3119">musica folklorica Chilena</option>
                          <option value="1388">Musica Progresiva</option>
                          <option value="62">Musical</option>
                          <option value="2091">Musical de Comedia</option>
                          <option value="3132">Musicales</option>
                          <option value="2397">Natación</option>
                          <option value="3160">Neotrance</option>
                          <option value="3151">New Beat</option>
                          <option value="3">Niños</option>
                          <option value="59">No-Ficción</option>
                          <option value="1389">Nu Metal</option>
                          <option value="3167">NY house</option>
                          <option value="1421">Obra de Caridad</option>
                          <option value="1419">Obra Social</option>
                          <option value="3198">October Fest</option>
                          <option value="3192">Old School</option>
                          <option value="41">Paracaidismo / Parapente</option>
                          <option value="87">Parque de diversiones</option>
                          <option value="68">Películas 3D</option>
                          <option value="1390">Perreo</option>
                          <option value="39">Playa</option>
                          <option value="53">Podcast</option>
                          <option value="1887">Podcast Hispano</option>
                          <option value="1836">Podcast Inglés</option>
                          <option value="1785">Podcast Latino</option>
                          <option value="72">Policíacas</option>
                          <option value="1391">Polka</option>
                          <option value="44">POP</option>
                          <option value="1393">Pop / Punk</option>
                          <option value="1394">Pop / Rock</option>
                          <option value="1454">Programación</option>
                          <option value="3173">Progresive House</option>
                          <option value="1395">Punk</option>
                          <option value="1396">Punk Rock</option>
                          <option value="3195">R&amp;B</option>
                          <option value="37">Rafting</option>
                          <option value="3133">Rally</option>
                          <option value="1397">Ranchera</option>
                          <option value="1398">Rap</option>
                          <option value="49">Rap / Hip Hop</option>
                          <option value="3154">Rave</option>
                          <option value="48">Reggae</option>
                          <option value="1400">Reggae Fusion</option>
                          <option value="47">Reggaeton</option>
                          <option value="70">Religiosas</option>
                          <option value="1401">Rhythm and Blues</option>
                          <option value="1402">Rock</option>
                          <option value="43">Rock / Punk</option>
                          <option value="1403">Rock Alternativo</option>
                          <option value="1404">Rock and Roll</option>
                          <option value="1405">Rock en español</option>
                          <option value="1406">Rock Psicodélico</option>
                          <option value="1407">Roots Reggae</option>
                          <option value="2601">Rugby</option>
                          <option value="1408">Rumba</option>
                          <option value="46">Salsa</option>
                          <option value="1457">Salud</option>
                          <option value="1459">Salud Mental</option>
                          <option value="1410">Samba</option>
                          <option value="3134">Sim Racing</option>
                          <option value="3135">Simulacion</option>
                          <option value="17">Ska</option>
                          <option value="21">Soul</option>
                          <option value="3190">Soul Funk Hip Hop</option>
                          <option value="1413">Stoner Rock</option>
                          <option value="3184">Subgeneros del Bass</option>
                          <option value="63">Suspenso</option>
                          <option value="1414">Swing</option>
                          <option value="23">Tango</option>
                          <option value="1438">Teatro</option>
                          <option value="3170">Techhouse</option>
                          <option value="3163">Techhouse House</option>
                          <option value="1416">Techno</option>
                          <option value="34">Tenis</option>
                          <option value="64">Terror</option>
                          <option value="1463">Tour Conciertos</option>
                          <option value="1465">Tours de Aventura</option>
                          <option value="1464">Tours Gastronómicos</option>
                          <option value="1462">Tours Turísticos</option>
                          <option value="1439">Tragedia</option>
                          <option value="1445">Tragicomedia</option>
                          <option value="52">Trap</option>
                          <option value="1418">Trash Metal</option>
                          <option value="36">Trekking</option>
                          <option value="3159">Tribal</option>
                          <option value="3189">Trip Hop</option>
                          <option value="3181">UK Garage</option>
                          <option value="3142">Vallenato</option>
                          <option value="3203">viñas</option>
                          <option value="3202">vinos</option>
                          <option value="2448">Voleiball</option>
                          <option value="3136">Voleibol</option>
                          <option value="3145">Volleyball</option>
                          <option value="77">Western</option>
                          <option value="3137">Workshops</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Artistas</label>
                        <input type="text" class="form-control form-control-lg" name="artista" value="<?php echo $rowEvent['artista'] ?>">
                      </div>
                      <div class="form-group col-md-12">
                        <label for="">Descripción del evento</label>
                        <textarea name="descripcion" id="" class="form-control form-control-lg"><?php echo $rowEvent['descripcion'] ?></textarea>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="datepicker-start">Fecha inicio del evento</label>
                          <input name="fechaIni" type="date" class="form-control form-control-lg" id="datepicker-start" value="<?php echo $rowEvent['fechaIni'] ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="datepicker-start">Hora inicio del evento</label>
                          <input name="horaIni" type="time" class="form-control form-control-lg" id="datepicker-start" value="<?php echo $rowEvent['horaIni'] ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="datepicker-end">Fecha de finalización del evento</label>
                          <input name="fechaFin" type="date" class="form-control form-control-lg" id="datepicker-end" value="<?php echo $rowEvent['fechaFin'] ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="datepicker-end">Hora de finalización del evento</label>
                          <input name="horaFin" type="time" class="form-control form-control-lg" id="datepicker-end" value="<?php echo $rowEvent['horaFin'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Región</label>
                        <select name="region" id="regionEdit" class="form-control form-control-lg">
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Comuna</label>
                        <select name="comuna" id="comunaEdit" class="form-control form-control-lg" value="">
                          <option value="<?php echo $rowEvent['comuna'] ?>"><?php echo $rowEvent['comuna'] ?></option>
                          <option value="-1">Seleccione Región</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Dirección</label>
                        <input name="dir" id="" class="form-control form-control-lg" value="<?php echo $rowEvent['dir'] ?>">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Lugar del evento</label>
                        <input type="text" name="lugar" id="" class="form-control form-control-lg" value="<?php echo $rowEvent['lugar'] ?>">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Flyer del evento</label>
                        <input type="hidden" name="flayerActual" value="<?php echo $rowEvent['flyer'] ?>">
                        <input type="file" name="flyer" id="" class="form-control form-control-lg">
                        <span style="color: #ff0000;font-size: 10px;">La imagen debe ser de 1080x1080px</span>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Banner del evento</label>
                        <input type="hidden" name="bannerActual" value="<?php echo $rowEvent['banner'] ?>">
                        <input type="file" name="banner" id="" class="form-control form-control-lg">
                        <span style="color: #ff0000;font-size: 10px;">La imagen debe ser de 1583x380px</span>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="">Layout del local</label>
                        <input type="hidden" name="secflyerActual" value="<?php echo $rowEvent['secflyer'] ?>">
                        <input type="file" name="secflyer" id="" class="form-control form-control-lg">
                      </div>
                      <div class="form-group col-md-12 btnSubmin d-flex justify-content-end mt-4">
                        <input type="submit" value="Editar evento" class="btn btn-lg btn-primary btn-lg mb-0">
                      </div>
                    <?php
                    }
                    ?>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php include('../assets/components/footer.php') ?>
        </div>
      </div>

      <?php include('../assets/components/script.php') ?>
      <script src="../assets/js/index.js"></script>
      <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $('#datepicker').datepicker({
          uiLibrary: 'bootstrap4'
        });
      </script>
    </body>

    </html>
<?php
  }
}
?>
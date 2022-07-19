<?php
$title = "Dashboard";
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
  $sql = "SELECT * FROM `user` WHERE `id`= " . $_SESSION['id'] ;
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>
    <!DOCTYPE html>
    <html lang="en">

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
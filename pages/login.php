<?php
$title = 'Iniciar Sesión'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Lider Tickets - <?php echo $title ?>
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/custom.css">

</head>

<body class="login">
  <main class="main-content  mt-0">
    <?php include('../assets/components/navIndex.php') ?>
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-lg-7 col-sm-12 d-flex flex-column justify-content-center text-center w100">
              <div class="position-relative h-100 m-3 d-flex flex-column justify-content-center overflow-hidden">
                <img src="../assets/img/logo.svg" alt="" srcset="">
              </div>
            </div>
            <div class="col-lg-5 col-md-7 col-xl-5 d-flex flex-column mt-5 mx-auto mx-lg-0">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h2 class="font-weight-bolder" id="titleCard">Iniciar sesión</h2>
                  <p class="mb-0" id="subTitleCard">Ingresa tus datos para iniciar sesión</p>
                </div>
                <div class="card-body">
                  <form id="formLogin" class="active" role="form" action="../assets/api/conex/valLogin.php" method="POST">
                    <div class="mb-3">
                      <input type="email" name="mail" class="form-control form-control-lg" placeholder="Correo electrónico" aria-label="Correo electrónico">
                    </div>
                    <div class="mb-3 position-relative">
                      <input type="password" name="pass" id="passLogin" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Contraseña">
                      <i class="fa fa-eye-slash eyePass" aria-hidden="true" onclick="visiblePass()"></i>
                    </div>
                    <div class="d-flex forgoutPass justify-content-center">
                      <span onclick="forgoutPass()">¿Olvidaste tu contraseña?</span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 enter"><img src="../assets/img/entrar.png" alt=""></button>
                    </div>
                  </form>
                  <form id="formFogout" role="form" action="../assets/api/conex/valLogin.php" method="POST">
                    <div class="mb-3">
                      <input type="email" name="mail" class="form-control form-control-lg" placeholder="Correo electrónico" aria-label="Correo electrónico">
                    </div>
                    <div class="d-flex forgoutPass justify-content-center">
                      <span onclick="goLogin()">Volver al Login</span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 enter"><img src="../assets/img/enviar.png" alt=""></button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    ¿No tienes una cuenta?
                    <a href="./register.php" class="text-primary text-gradient font-weight-bold">Registrate</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12">
            <div id="map-overlay" class="col-sm-12 d-flex justify-content-center">
              © <?php echo date('Y') ?> LiderTickets, developed by <span class="font-weight-bold m-1 mb-0 mt-0"> MilanoD&D</span>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </main>
  <!--   Core JS Files   -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    const visiblePass = () => {
      const pass = document.getElementById('passLogin');
      const eye = document.querySelector('.eyePass');
      if (pass.type === 'password') {
        pass.type = 'text';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
      } else {
        pass.type = 'password';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
      }
    }
    const visibilityPassForgout1 = () => {
      const pass = document.getElementById('passLogin1');
      const eye = document.querySelector('.eyePass1');
      if (pass.type === 'password') {
        pass.type = 'text';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
      } else {
        pass.type = 'password';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
      }
    }
    const visibilityPassForgout2 = () => {
      const pass = document.getElementById('passLogin2');
      const eye = document.querySelector('.eyePass2');
      if (pass.type === 'password') {
        pass.type = 'text';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
      } else {
        pass.type = 'password';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
      }
    }
    const forgoutPass = () => {
      const formLogin = document.getElementById('formLogin');
      const formFogout = document.getElementById('formFogout');
      formLogin.classList.remove('active');
      $('#titleCard').html('Recuperar Contraseña');
      $('#subTitleCard').html('Ingresa tu correo electrónico y te enviaremos un enlace para que puedas recuperar tu contraseña');
      formFogout.classList.add('active');
    }
    const goLogin = () => {
      const formLogin = document.getElementById('formLogin');
      const formFogout = document.getElementById('formFogout');
      formFogout.classList.remove('active');
      $('#titleCard').html('Iniciar sesión');
      $('#subTitleCard').html('Ingresa tus datos para iniciar sesión');
      formLogin.classList.add('active');
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
<?php ?>
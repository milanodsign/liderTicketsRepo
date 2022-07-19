<?php
$title = "Registro";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('../assets/components/header.php') ?>
</head>

<body class="register">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <img class="logoRegister" src="../assets/img/small-logos/Logo_Home_Svg.svg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div id="contentCard" class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-body">
              <form action="../assets/api/php/regUser.php?txt=Usuario Registrado Satisfactoriamente" method="POST" id="registro" name="registro" class="contacto row" autocomplete="off">
                <div class="div-100">
                  <label for="nombre"><span class="t_ubicacion">Nombre completo:</span></label>
                  <input type="text" size="50" name="nombre" id="nombre" value="" placeholder="Escribe tu nombre completo aquí" spellcheck="false" data-ms-editor="true" class="form-control form-control-lg">
                </div>
                <div class="div-50">
                  <label for="email"><span class="t_ubicacion">Email:</span></label>
                  <input type="email" size="50" name="email" id="email" value="" placeholder="Escribe tu email aquí" class="form-control form-control-lg">
                </div>
                <div class="div-50">
                  <label for="telefono"><span class="t_ubicacion">Teléfono:</span></label>
                  <input type="tel" size="50" name="telefono" id="telefono" value="" placeholder="Escribe tu teléfono aquí" class="form-control form-control-lg">
                </div>

                <span style="clear:both; display: block"></span>
                <div class="div-50">
                  <label for="clave"><span class="t_ubicacion">Clave:</span></label>
                  <input type="password" size="50" name="clave" id="clave" value="" placeholder="Escribe tu clave aquí" class="form-control form-control-lg">
                </div>
                <div class="div-50">
                  <label for="repetir_clave"><span class="t_ubicacion">Repetir clave:</span></label>
                  <input type="password" size="50" name="repetir_clave" id="repetir_clave" value="" placeholder="Repite la clave" class="form-control form-control-lg">
                </div>

                <!-- <div class="g-recaptcha div-50" data-sitekey="6LdKyCQTAAAAANngEInKLldYDXUY4a1lf2fgr5tu">
                  <div style="width: 304px; height: 78px;">
                    <div><iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LdKyCQTAAAAANngEInKLldYDXUY4a1lf2fgr5tu&amp;co=aHR0cHM6Ly93d3cucGFzc2xpbmUuY29tOjQ0Mw..&amp;hl=es&amp;v=4rwLQsl5N_ccppoTAwwwMrEN&amp;size=normal&amp;cb=f8chrvh2mhnc" width="304" height="78" role="presentation" name="a-9elm0zy3fye8" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                  </div><iframe style="display: none;"></iframe>
                </div> -->

                <div class="align-items-center d-flex justify-content-end mt-4 w-100">
                  <button type="submit" name="button2" id="button2" class="btn btn-primary w-100">REGÍSTRATE</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <?php include('../assets/components/footer.php') ?>

  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
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
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  <script src="../assets/js/custom.js"></script>
</body>

</html>
<?php ?>
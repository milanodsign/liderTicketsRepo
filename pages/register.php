<?php
$title = "Registro";
?>
<!DOCTYPE html>
<html lang="es">

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
            <img class="logoRegister" src="../assets/img/logo.svg" alt="">
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
                <div class="col-md-6">
                  <label for="nombre"><span class="t_ubicacion">Nombre completo:</span></label>
                  <input type="text" size="50" name="nombre" id="nombre" value="" placeholder="Escribe tu nombre completo aquí" spellcheck="false" data-ms-editor="true" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6">
                  <label for="email"><span class="t_ubicacion">Email:</span></label>
                  <input type="email" size="50" name="email" id="email" value="" placeholder="Escribe tu email aquí" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6">
                  <label for="telefono"><span class="t_ubicacion">Teléfono:</span></label>
                  <input type="tel" size="50" name="telefono" id="telefono" value="" placeholder="Escribe tu teléfono aquí" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6">
                  <label for="pais"><span class="t_ubicacion">País:</span></label>
                  <select name="pais" id="pais" class="form-control form-control-lg" required>
                    <option value="">Seleccione</option>
                    <option value="chile">Chile</option>
                    <option value="argentina">Argentina</option>
                    <option value="uruguay">Uruguay</option>
                    <option value="paraguay">Paraguay</option>
                    <option value="peru">Perú</option>
                    <option value="mexico">México</option>
                    <option value="bolivia">Bolivia</option>
                    <option value="colombia" selected>Colombia</option>
                    <option value="ecuador">Ecuador</option>
                    <option value="usa">USA - CANADA</option>
                    <option value="espana">España</option>
                    <option value="panama">Panamá</option>
                    <option value="venezuela">Venezuela</option>
                    <option value="brasil">Brasil</option>
                    <option value="costarica">Costa Rica</option>
                    <option value="guatemala">Guatemala</option>
                    <option value="salvador">El Salvador</option>
                    <option value="dominicana">Republica Dominicana</option>
                  </select>
                </div>

                <span style="clear:both; display: block"></span>
                <div class="div-50">
                  <label for="clave"><span class="t_ubicacion">Clave:</span></label>
                  <input type="password" size="50" name="clave" id="clave" value="" placeholder="Escribe tu clave aquí" class="form-control form-control-lg" required>
                </div>
                <div class="div-50">
                  <label for="repetir_clave"><span class="t_ubicacion">Repetir clave:</span></label>
                  <input type="password" size="50" name="repetir_clave" id="repetir_clave" value="" placeholder="Repite la clave" class="form-control form-control-lg" onblur="valPass()" required>
                  <span class="valPass">Las contraseñas no coinciden</span>
                </div>

                <div class="align-items-center d-flex justify-content-end mt-4 w-100">
                  <button type="submit" name="button2" id="button2" class="btn btn-primary w-100">REGÍSTRATE</button>
                </div>
                <span class="d-flex justify-content-center w-100 text-primary text-gradient font-weight-bold">
                  <a href="../index">
                    o vuelve al Inicio
                  </a>
                </span>
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
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
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
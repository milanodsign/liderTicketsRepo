<?php ?>
<section class="banner" role="banner" id="banner">
  <header id="header">
    <div class="header-content clearfix">
      <span class="logo">
        <a href="index.php">
          <img src="<?php if ($title == 'Iniciar Sesión') {
                      echo '../assets/img/logo.svg';
                    } else {
                      echo './assets/img/logo.svg';
                    } {
                    } ?>" alt="LiderTickets">
        </a>
      </span>
      <nav class="navigation" role="navigation">
        <ul class="primary-nav">
          <li><a href="<?php if ($title == 'Colombia') {
                          echo '#banner';
                        } else {
                          echo 'https://lidertickets.cl';
                        } {
                        } ?>">Inicio</a></li>
          <li><a href="<?php if ($title == 'Colombia') {
                          echo '#eventGrid';
                        } else {
                          echo 'https://lidertickets.cl#eventGrid';
                        } {
                        } ?>">Eventos</a></li>
          <li><a href="<?php if ($title == 'Colombia') {
                          echo '#commingSoon';
                        } else {
                          echo 'https://lidertickets.cl#commingSoon';
                        } {
                        } ?>">Proximo Evento</a></li>
          <li><a href="<?php if ($title == 'Colombia') {
                          echo '#contact';
                        } else {
                          echo 'https://lidertickets.cl#contact';
                        } {
                        } ?>">Contáctanos</a></li>
          <?php
          if ($title != 'Iniciar Sesión') {
            echo '<li><a href="./pages/login.php">Iniciar Sesión</a></li>';
          }

          ?>
        </ul>
      </nav>
      <a href="#" class="nav-toggle">Menu<span></span></a>
    </div>
  </header>
</section>
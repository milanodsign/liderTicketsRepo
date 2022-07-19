<?php ?>
<aside class="sidenav bg-lt navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
            <img src="../assets/img/small-logos/Logo_Home_Svg.svg" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Perfil de Usuario</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/dashboard.php">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/eventsGrid.php">
                    <i class="fa-solid fa-arrows-to-circle"></i>
                    <span class="nav-link-text">Eventos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-ticket"></i>
                    <span class="nav-link-text">Mis tickets</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-user-pen"></i>
                    <span class="nav-link-text">Editar datos</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Perfil de productor</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#eventCreate">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="nav-link-text">Crear evento</span>
                </a>
                <div class="divCollapse" id="eventCreate">
                    <ul>
                        <li>
                            <a href="../pages/eventCreate.php?type=presencial">
                                <i class="fa-solid fa-caret-right"></i>
                                <span class="sub-item">Presencial</span>
                            </a>
                        </li>
                        <li>
                            <a href="../pages/eventCreate.php?type=streaming">
                                <i class="fa-solid fa-caret-right"></i>
                                <span class="sub-item">Streaming</span>
                            </a>
                        </li>
                        <li>
                            <a href="../pages/eventCreate.php?type=mixto">
                                <i class="fa-solid fa-caret-right"></i>
                                <span class="sub-item">Mixto</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../pages/myEvents.php">
                    <i class="fa-solid fa-table"></i>
                    <span class="nav-link-text">Mis eventos</span>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span class="nav-link-text">Ventas totales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-server"></i>
                    <span class="nav-link-text">Base de datos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="nav-link-text">Datos del productor</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-building-columns"></i>
                    <span class="nav-link-text">Datos bancarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-brands fa-paypal"></i>
                    <span class="nav-link-text">Datos paypal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../assets/api/conex/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-link-text">Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<?php ?>
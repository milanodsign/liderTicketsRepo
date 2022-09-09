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
                <a class="nav-link" href="../pages/eventsGrid.php">
                    <i class="fa-solid fa-arrows-to-circle"></i>
                    <span class="nav-link-text">Eventos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" aria-expanded="false" href="#myTickets">
                    <i class="fa-solid fa-ticket"></i>
                    <span class="nav-link-text">Mis tickets</span>
                </a>
                <div class="divCollapse" id="myTickets">
                        <ul>
                            <li>
                                <a href="../pages/myTicketsSale.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Comprados</span>
                                </a>
                            </li>
                            <li>
                                <a href="../pages/myTicketsCourtesy.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Cortesía</span>
                                </a>
                            </li>
                        </ul>
                    </div>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i class="fa-solid fa-user-pen"></i>
                    <span class="nav-link-text">Editar datos</span>
                </a>
            </li>
            <?php
            if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1) {
            ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Perfil de productor</h6>
                </li>
                <?php 
            }?>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" aria-expanded="false" href="#eventCreate">
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
                <?php
            if ($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/myEvents.php">
                        <i class="fa-solid fa-table"></i>
                        <span class="nav-link-text">Mis eventos</span>
                    </a>
                </li>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link " href="#">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="nav-link-text">Ventas totales</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link " href="../pages/dataBaseDownload.php">
                        <i class="fa-solid fa-server"></i>
                        <span class="nav-link-text">Base de datos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/producerData.php">
                        <i class="fa-solid fa-user-check"></i>
                        <span class="nav-link-text">Datos del productor</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/banks.php">
                        <i class="fa-solid fa-building-columns"></i>
                        <span class="nav-link-text">Datos bancarios</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link " href="#">
                        <i class="fa-brands fa-paypal"></i>
                        <span class="nav-link-text">Datos paypal</span>
                    </a>
                </li> -->
            <?php
            }
            ?>
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
<?php ?>
<aside class="sidenav bg-lt navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="../assets/img/logo.svg" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <!-- Perfil de Usuario -->
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
                <a class="nav-link " href="../pages/editUser.php">
                    <i class="fa-solid fa-user-pen"></i>
                    <span class="nav-link-text">Editar datos usuario</span>
                </a>
            </li>

            <!-- Perfil de Adminsitrados -->
            <?php
            if ($rowUser['userType'] == 2) {
            ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Perfil de administrador</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" aria-expanded="false" href="#request">
                        <i class="fa-solid fa-code-pull-request"></i>
                        <span class="nav-link-text">Solicitudes</span>
                    </a>
                    <div class="divCollapse" id="request">
                        <ul>
                            <li>
                                <a href="../pages/requestCreateEvent.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Creación de Eventos</span>
                                </a>
                            </li>
                            <li>
                                <a href="../pages/requestEditEvent.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Edición de eventos</span>
                                </a>
                            </li>
                            <li>
                                <a href="../pages/requestEditTicket.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Edición de Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a href="../pages/requestPrintTickets.php">
                                    <i class="fa-solid fa-caret-right"></i>
                                    <span class="sub-item">Impresión de tickets</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="../pages/eventSelect.php">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span class="nav-link-text">Balance Eventos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="../pages/qrValidator.php">
                        <i class="fa-solid fa-qrcode"></i>
                        <span class="nav-link-text">Validar Tickets</span>
                    </a>
                </li>
            <?php
            } ?>

            <!-- Perfil de Productor -->

            <?php
            if ($rowUser['userType'] == 1 || $rowUser['userType'] == 2) {
            ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Perfil de productor</h6>
                </li>
            <?php
            } ?>
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
            if ($rowUser['userType'] == 1 || $rowUser['userType'] == 2) {
            ?>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/myEvents.php">
                        <i class="fa-solid fa-table"></i>
                        <span class="nav-link-text">Mis eventos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/printedTicketRequests.php">
                        <i class="fa-solid fa-print"></i>
                        <span class="nav-link-text">Impresion de Tickets</span>
                    </a>
                </li>
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
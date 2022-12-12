<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../../conex/conexConfig.php');

$ref = $_GET['ref'];
$id = $_GET['id'];



$update = 'UPDATE `ticketsSales` SET `status`=1, `idTransaction`= "' . $id . '" WHERE `ref`="' . $ref . '"';
$result = $mysqli->query($update);
if ($result === TRUE) {
    $response[] = array(
        'message' => true,
    );

    $sqlTS = 'SELECT * FROM `ticketsSales` WHERE `ref`="' . $ref . '"';
    $resultTS = $mysqli->query($sqlTS);
    $filas = mysqli_num_rows($resultTS);

    while ($row = $resultTS->fetch_array(MYSQLI_ASSOC)) {
        $idEvent = $row['idEvent'];
        $ticketType = $row['ticketType'];
        $cant = $row['cant'];
        $name = $row['name'];
        $email = $row['email'];
        $docType = $row['docType'];
        $numDoc = $row['numDoc'];
        $phone = $row['phone'];
        $shoppingDate = $row['shoppingDate'];
        $shoppingTime = $row['shoppingTime'];
        $codTicket = $row['codTicket'];
    }

    $sqlE = 'SELECT * FROM `eventos` WHERE `id`="' . $idEvent . '"';
    $resultE = $mysqli->query($sqlE);
    while ($rowE = $resultE->fetch_array(MYSQLI_ASSOC)) {
        $idUser = $rowE['idUser'];
        $eventType = $rowE['eventType'];
        $pais = $rowE['pais'];
        $tipo = $rowE['tipo'];
        $mayores = $rowE['mayores'];
        $nomEvent = $rowE['nomEvent'];
        $categoria = $rowE['categoria'];
        $artista = $rowE['artista'];
        $descripcion = $rowE['descripcion'];
        $fechaIni = $rowE['fechaIni'];
        $horaIni = $rowE['horaIni'];
        $fechaFin = $rowE['fechaFin'];
        $horaFin = $rowE['horaFin'];
        $region = $rowE['region'];
        $comuna = $rowE['comuna'];
        $dir = $rowE['dir'];
        $lugar = $rowE['lugar'];
        $link = $rowE['link'];
        $flyer = $rowE['flyer'];
        $banner = $rowE['banner'];
    }

    $sqlTT = 'SELECT * FROM `ticketsType` WHERE `id`="' . $ticketType . '"';
    $resultTT = $mysqli->query($sqlTT);
    while ($rowTT = $resultTT->fetch_array(MYSQLI_ASSOC)) {
        $ticketName = $rowTT['name'];
    }

    if ($filas == 1) {
        include('../../../lib/phpqrcode/qrlib.php');
        QRcode::png($row['codTicket'], "../temp/qrTickets.png", 'QR_ECLEVEL_Q', '10', '0');
        $qrTickets = '<img src="https://lidertickets.cl/assets/api/php/temp/qrTickets.png"/>';

        $para      = $email;
        $titulo    = '¡Tu entrada está aquí! | Cod: ' . $codTicket;
        $mensaje   = '
        <html lang="es">
    
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Entrada de Cortesia</title>
        </head>
        
        <body>
            <div style="background:#1e1f29;color:#333;font-family:Lato,Arial,sans-serif;font-size:16px!important;line-height:1;text-align:center;min-width:100%">
                <div style="margin:0 auto;text-align:center">
        
                    <img src="https://lidertickets.cl/assets/img/small-logos/logoMail.png" alt="Lider Tickets"
                        border="0" style="margin:1.5rem 0" class="CToWUd">
                </div>
        
                <table cellpadding="0" cellspacing="0" align="center"
                    style="width:640px;margin:0 auto">
                    <tbody>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" align="center"
                                    style="border-collapse:separate;border-spacing:0;overflow:hidden;text-align:center;width:100%">
        
                                    <tbody>
                                        <tr>
                                            <td
                                                style="background:#fff;padding:0 16px;border-top-left-radius:5px;border-top-right-radius:5px">
                                                <h1 style="font-size:30px;font-weight:700">¡Qué envidia ' . $name . '!</h1>
        
                                                <p style="line-height:1.2">Gracias por confiar en nosotros, estas cerca de
                                                    disfrutar de tu evento.<br>A continuación encontrarás el código de tu cupón    
                                                    ¡Disfrútalo!</p>
        
                                            </td>
                                        </tr>
        
        
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">
                                                <table cellpadding="0" cellspacing="10"
                                                    style="background:#f7f8f9;border:1px dashed #cecece;text-align:left;width:100%">
        
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding-bottom:20px;text-align:center">
                                                                <div class="m_809902376527534251cupFoto"
                                                                    style="display:inline-block;font-size:18px;font-weight:700;vertical-align:top;width:260px">
                                                                    
                                                                    <img src="https://lidertickets.cl' . urlencode($flyer) . '"
                                                                        alt="' . $nomEvent . '" style="width:260px;max-width:100%" class="CToWUd a6T">
                                                                    <div class="a6S" dir="ltr" style="opacity: 0.01;">
                                                                        <div id=":2e2" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q"
                                                                            title="Descargar" role="button" tabindex="0"
                                                                            aria-label="Descargar el archivo adjunto "
                                                                            data-tooltip-class="a1V">
                                                                            <div class="akn">
                                                                                <div class="aSK J-J5-Ji aYr"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m_809902376527534251cupProd"
                                                                    style="display:inline-block;font-size:18px;font-weight:700;padding-left:15px;vertical-align:top;width:300px">
                                                                    
                                                                    <h2
                                                                        style="color:#0094de;font-size:20px;margin:0;padding-bottom:5px">
                                                                        ' . $nomEvent . '
                                                                    </h2>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Lugar: 
                                                                        <strong>
                                                                            ' . $lugar . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Dirección: 
                                                                        <strong>
                                                                            ' . $dir . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Fecha: 
                                                                        <strong>
                                                                            ' . $fechaIni . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Hora: 
                                                                        <strong>
                                                                            ' . date('h:i A', strtotime($horaIni)) . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Ticket: 
                                                                        <strong>
                                                                            ' . $ticketName . '
                                                                        </strong>
                                                                    </span>
                                                                    
        
                                                                    <img src="https://ci3.googleusercontent.com/proxy/IdvEMJeLZukZK8FRBmt3-P_rbLsnv-4dZNdc8dHBY2y6YEj1dOA2LUfNgwg2rrxvwPjEJGmw9Git9RzL-67dztcumzSflGUn6gNgvIYH8MTjMFyYpKianvzy8Sbbjvu6nGnqkXhUrB86hK-cGHxa1Q=s0-d-e1-ft#http://cuponassets.cuponatic-latam.com/front/frontendCo/images/cupon_html/valido-celularS.png"
                                                                        style="display: block;
                                                                        margin: 0 auto;
                                                                        margin-top: 1.5rem;" width="99"
                                                                        alt="Cupón válido en el celular" class="CToWUd">
                                                                </div>
                                                            </td>
                                                        </tr>
        
                                                        <tr>
        
                                                            <td style="padding-bottom:20px;text-align:center">
                                                                <div style="border:1px dotted #a4a4a4;margin:0 auto;text-align:center;vertical-align:top;width:100%, padding: 1.5rem 0;">
                                                                <img src="https://lidertickets.cl/assets/api/php/temp/qrTickets.png" style="margin-bottom: 1.5rem"/>
                                                                <span style="display:block;font-size:26px;word-break:break-all">
                                                                ' . $codTicket . '
                                                                </span>
                                                                </div>
                                                            </td>
                                                        </tr>
        
                                                        <tr>
                                                            <td width="52%">&nbsp;</td>
        
                                                        </tr>
        
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">
                                                <hr style="background:#c4c4c4;border:0;height:8px">
                                                <p style="font-size:12px!important">¿Tienes alguna sugerencia, duda o consulta
                                                    sobre nuestro servicio?
                                                    Estaremos felices de ayudarte. Por favor escríbemos a <a
                                                        href="mailto:info@lidertickets.co" style="color:#333"
                                                        target="_blank">info@lidertickets.cl</a> o llámanos al PBX
                                                    0000000000.</p>
                                                <p><strong>¡Que tengas un día Lidertickets!</strong></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
        </body>
        
        </html>';
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: lidertickets.cl <info@lidertickets.cl>' . "\r\n";
        mail($para, $titulo, $mensaje, $cabeceras);
    } else {
        $para      = $email;
        $titulo    = '¡Tus entradas están aquí!';
        $mensaje   = '
        <html lang="es">
    
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Entrada de Cortesia</title>
        </head>
        
        <body>
            <div style="background:#1e1f29;color:#333;font-family:Lato,Arial,sans-serif;font-size:16px!important;line-height:1;text-align:center;min-width:100%">
                <div style="margin:0 auto;text-align:center">
        
                    <img src="https://lidertickets.cl/assets/img/small-logos/logoMail.png" alt="Lider Tickets"
                        border="0" style="margin:1.5rem 0" class="CToWUd">
                </div>
        
                <table cellpadding="0" cellspacing="0" align="center"
                    style="width:640px;margin:0 auto">
                    <tbody>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" align="center"
                                    style="border-collapse:separate;border-spacing:0;overflow:hidden;text-align:center;width:100%">
        
                                    <tbody>
                                        <tr>
                                            <td
                                                style="background:#fff;padding:0 16px;border-top-left-radius:5px;border-top-right-radius:5px">
                                                <h1 style="font-size:30px;font-weight:700">¡Qué envidia ' . $name . '!</h1>
        
                                                <p style="line-height:1.2">Gracias por confiar en nosotros, estas cerca de
                                                    disfrutar de tu evento.<br>Compraste ' . $filas . ' tickets para tu evento    
                                                    ¡Disfrútalo!</p>
        
                                            </td>
                                        </tr>
        
        
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">
                                                <table cellpadding="0" cellspacing="10"
                                                    style="background:#f7f8f9;border:1px dashed #cecece;text-align:left;width:100%">
        
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding-bottom:20px;text-align:center;width:100%">
                                                                <div class="m_809902376527534251cupFoto"
                                                                    style="display:inline-block;font-size:18px;font-weight:700;vertical-align:top;width:260px">
                                                                    
                                                                    <img src="https://lidertickets.cl' . $flyer . '"
                                                                        alt="' . $nomEvent . '" style="width:260px;max-width:100%" class="CToWUd a6T">
                                                                    <div class="a6S" dir="ltr" style="opacity: 0.01;">
                                                                        <div id=":2e2" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q"
                                                                            title="Descargar" role="button" tabindex="0"
                                                                            aria-label="Descargar el archivo adjunto "
                                                                            data-tooltip-class="a1V">
                                                                            <div class="akn">
                                                                                <div class="aSK J-J5-Ji aYr"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m_809902376527534251cupProd"
                                                                    style="display:inline-block;font-size:18px;font-weight:700;padding-left:15px;vertical-align:top;width:300px">
                                                                    
                                                                    <h2
                                                                        style="color:#0094de;font-size:20px;margin:0;padding-bottom:5px">
                                                                        ' . $nomEvent . '
                                                                    </h2>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Lugar: 
                                                                        <strong>
                                                                            ' . $lugar . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Dirección: 
                                                                        <strong>
                                                                            ' . $dir . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Fecha: 
                                                                        <strong>
                                                                            ' . $fechaIni . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Hora: 
                                                                        <strong>
                                                                            ' . date('h:i A', strtotime($horaIni)) . '
                                                                        </strong>
                                                                    </span>
                                                                    <span style="display:block;font-size:14px;font-weight:400;padding-top:10px">Ticket: 
                                                                        <strong>
                                                                            ' . $ticketName . '
                                                                        </strong>
                                                                    </span>
                                                                    
        
                                                                    <img src="https://ci3.googleusercontent.com/proxy/IdvEMJeLZukZK8FRBmt3-P_rbLsnv-4dZNdc8dHBY2y6YEj1dOA2LUfNgwg2rrxvwPjEJGmw9Git9RzL-67dztcumzSflGUn6gNgvIYH8MTjMFyYpKianvzy8Sbbjvu6nGnqkXhUrB86hK-cGHxa1Q=s0-d-e1-ft#http://cuponassets.cuponatic-latam.com/front/frontendCo/images/cupon_html/valido-celularS.png"
                                                                        style="display: block;
                                                                        margin: 0 auto;
                                                                        margin-top: 1.5rem;" width="99"
                                                                        alt="Cupón válido en el celular" class="CToWUd">
                                                                </div>
                                                            </td>
                                                        </tr>
        
                                                        <tr>
                                                            <td style="text-align:center">
                                                                <a href="https://www.lidertickets.cl/pages/login.php" style="background-color: #e09900; border-color: #e09900;color: #fff;border: 0;cursor: pointer;" target="_blank">Ver mis Tickets</a>
                                                            </td>
        
                                                            <td style="padding-bottom:20px;text-align:center">
                                                                <div style="border:1px dotted #a4a4a4;margin:0 auto;text-align:center;vertical-align:top;width:100%, padding: 1.5rem 0;">
                                                                
                                                                </div>
                                                            </td>
                                                        </tr>
        
                                                        <tr>
                                                            <td width="52%">&nbsp;</td>
        
                                                        </tr>
        
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;padding:0 16px">
                                                <hr style="background:#c4c4c4;border:0;height:8px">
                                                <p style="font-size:12px!important">¿Tienes alguna sugerencia, duda o consulta
                                                    sobre nuestro servicio?
                                                    Estaremos felices de ayudarte. Por favor escríbemos a <a
                                                        href="mailto:info@lidertickets.cl" style="color:#333"
                                                        target="_blank">info@lidertickets.cl</a> o llámanos al PBX
                                                    0000000000.</p>
                                                <p><strong>¡Que tengas un día Lidertickets!</strong></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
        </body>
        
        </html>';
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: liderTickets.cl <info@lidertickets.cl>' . "\r\n";
        mail($para, $titulo, $mensaje, $cabeceras);
    }
} else {
    $response[] = array(
        'message' => false,
    );
}

echo json_encode($response);

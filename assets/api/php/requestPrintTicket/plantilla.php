<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://lidertickets.cl/assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <title><?php echo $cant . ' Tickets- ' . $nomTicketType . ' de ' . $nomEvent ?></title>
    <style>
        label {
            font-size: 4.95pt;
            text-align: center;
            display: block;
            width: 100%;
            margin: 0 auto;
        }

        @page {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>

<body style="text-transform: uppercase;font-family: 'Lato', sans-serif;text-align: center;">
    <?php
    $logoXS = 'logo.png';
    $logoxsBase64 = "data:image/png;base64," . base64_encode(file_get_contents($logoXS));
    if ($imgTicket == '') {
        $logoLG = 'logoCentral.png';
    } else {
        $result = explode('/', $imgTicket);
        // $logoLG = 'imgTicketPrint/logo-comedy.png';
        $logoLG = 'logoCentral.png';
        // var_dump($logoLG);
        // exit();
    }
    $logoLGBase64 = "data:image/png;base64," . base64_encode(file_get_contents($logoLG));
    // var_dump($logoLGBase64);
    //     exit();
    for ($i = 0; $i < $cant; $i++) {
        $path = 'qrCode/';
        $file = uniqid() . ".png";
        $route = $path . $file;
        $ecc = 'QR_ECLEVEL_H';
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codTicket = 'TF' . substr(str_shuffle($permitted_chars), 0, 10);
        include_once('../../../lib/phpqrcode/qrlib.php');
        QRcode::png($codTicket, $route, $ecc, '10', '0');
        $qrCodeBase64 = "data:image/png;base64," . base64_encode(file_get_contents($route));
        $qRcode = "<img src='" . $qrCodeBase64 . "' style='width: 10.31mm; height: 10.31mm;' />";

        $sqlTF = "INSERT INTO `ticketsFisicos`(`id`, `idUser`, `idEvent`, `nomEvent`, `ticketType`, `ticketCode`, `cant`, `priceTickets`, `descriptionTickets`, `lugar`, `dir`, `fecha`, `hora`) VALUES (NULL,'" . $idUser . "','" . $idEvent . "','" . $nomEvent . "','" . $ticketType . "','" . $codTicket . "','" . $cant . "','" . $priceTicket . "','" . $descriptionTickets . "','" . $lugar . "','" . $dir . "','" . $fecha . "','" . $hora . "')";
        $resultTF = $mysqli->query($sqlTF);
        // var_dump($resultTF);
        // exit();

    ?>

        <table style="page-break-after: always; width: 140mm; height: 50mm;transform: rotate(180deg)">
            <tbody>
                <tr>
                    <td style="width: 20mm; height: 50mm; position: relative; text-align: center; padding: 0;">
                        <div>
                            <img src="<?php echo $logoxsBase64 ?>">
                        </div>
                        <div style="margin-top: 1mm;">
                            <label for="">TICKET</label>
                            <div style="font-size: 10px; width: 100%; text-align: center; margin: 0 auto;"><?php echo $nomTicketType ?></div>
                        </div>
                        <?php
                        if ($showPrice != 2) {
                        ?>
                            <div style="margin-top: 1mm;">
                                <label for="">PRECIO</label>
                                <div style="font-size: 10px; width: 100%; text-align: center; margin: 0 auto;"><?php echo $price ?></div>
                            </div>
                        <?php
                        }
                        ?>
                        <div style="margin-top: 1mm;">
                            <label for="">FECHA EVENTO</label>
                            <div style="font-size: 10px; width: 100%; text-align: center; margin: 0 auto;"><?php echo date("d/m/Y", strtotime($fecha)) ?></div>
                        </div>
                        <div style="margin-top: 1mm;">
                            <?php echo $qRcode ?>
                        </div>
                        <div style="font-size: 8px; width: 85%; text-align: center; margin: 0 auto;margin-top: 1mm;">
                            <?php echo $codTicket ?>
                        </div>
                    </td>
                    <td style="width: 90mm; height: 50mm; position: relative; text-align: center; padding: 0;">
                        <div>
                            <img src="<?php echo $logoLGBase64 ?>">
                        </div>
                        <div style="font-size: 17px;">
                            <b><?php echo $nomEvent ?></b>
                        </div>
                        <div style="width: 220px; margin: 0 auto; text-align: left;">
                            <label for="" style="display: inline-block;width: 30px;text-align: left;">LUGAR:</label>
                            <div style="font-size: 10px; width: auto; text-align: center; margin: 0 auto;display: inline-block;"><?php echo $lugar ?></div>
                        </div>
                        <div style="width: 220px; margin: 0 auto; text-align: left;">
                            <label for="" style="display: inline-block;width: 30px;text-align: left;">Fecha:</label>
                            <div style="font-size: 10px; width: auto; text-align: center; margin: 0 auto;display: inline-block;"><?php echo fecha($fecha) . ' | ' . date('h:i A', strtotime($hora)) ?></div>
                        </div>
                        <div style="width: 220px; margin: 0 auto; text-align: right;">
                            <?php
                            if ($showPrice != 2) {
                            ?>
                                <label for="" style="display: inline-block;width: 30px;text-align: left;">Precio:</label>
                                <div style="font-size: 10px; width: auto; text-align: center; margin: 0 auto;display: inline-block;"><?php echo $price ?></div>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                    <td style="width: 30mm; height: 50mm; position: relative; text-align: center; padding: 0;">
                        <div>
                            <img src="<?php echo $logoxsBase64 ?>">
                        </div>
                        <div style="margin-top: 1mm;">
                            <label for="" style="width: 100%; text-align: center;">TICKET</label>
                            <div style="font-size: 10px; width: 85%; text-align: center; margin: 0 auto;"><?php echo $nomTicketType ?></div>
                        </div>
                        <?php
                        if ($showPrice != 2) {
                        ?>
                            <div style="margin-top: 1mm;">
                                <label for="" style="width: 100%; text-align: center;">PRECIO</label>
                                <div style="font-size: 10px; width: 85%; text-align: center; margin: 0 auto;"><?php echo $price ?></div>
                            </div>
                        <?php
                        }
                        ?>
                        <div style="margin-top: 1mm;">
                            <label for="" style="width: 100%; text-align: center;">FECHA EVENTO</label>
                            <div style="font-size: 10px; width: 85%; text-align: center; margin: 0 auto;"><?php echo date("d/m/Y", strtotime($fecha)) ?></div>
                        </div>
                        <div style="margin-top: 1mm;">
                            <?php echo $qRcode ?>
                        </div>
                        <div style="font-size: 8px; width: 85%; text-align: center; margin: 0 auto;margin-top: 1mm;">
                            <?php echo $codTicket ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php
        $qRcode = '';
    }
    ?>
    </div>
</body>

</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$sql = "SELECT * FROM `eventos` WHERE `fechaIni` >= (NOW() + 1) AND estado=1 ORDER BY `fechaIni` ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Evento</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['id'] . '" style="text-transform: uppercase;">' . $row['nomEvent'] . '</option>';
};

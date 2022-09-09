<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$dep = $_GET['dep'];
$sql = "SELECT `munCol` FROM `munDepCol` WHERE `depCol`='" . $dep . "' ORDER BY munCol ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Municipio</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['munCol'] . '">' . $row['munCol'] . '</option>';
};


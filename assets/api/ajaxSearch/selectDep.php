<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$sql = "SELECT DISTINCT depCol FROM `munDepCol` ORDER BY depCol ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Departamento</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['depCol'] . '">' . $row['depCol'] . '</option>';
};


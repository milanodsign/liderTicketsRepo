<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$sql = "SELECT DISTINCT region FROM `comRegCL` ORDER BY region ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Región</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['region'] . '">' . $row['region'] . '</option>';
};


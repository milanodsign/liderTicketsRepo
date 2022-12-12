<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$dep = $_GET['dep'];
$sql = "SELECT `comuna` FROM `comRegCL` WHERE `region`='" . $dep . "' ORDER BY comuna ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Comuna</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['comuna'] . '">' . $row['comuna'] . '</option>';
};


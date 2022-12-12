<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$id = $_GET['id'];
$sqlE = "SELECT * FROM `eventos` WHERE `id`= '" . $id . "'";
$resultE = $mysqli->query($sqlE);
while ($rowEvent = $resultE->fetch_array(MYSQLI_ASSOC)) {
    $sql = "SELECT DISTINCT region FROM `comRegCL` ORDER BY region ASC";
    $result = $mysqli->query($sql);
    echo '<option value="' . $rowEvent['region'] . '">' . $rowEvent['region'] . '</option>';
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '<option value="' . $row['region'] . '">' . $row['region'] . '</option>';
    }
};

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$id = $_GET['id'];
$sql = "SELECT * FROM `ticketsType` WHERE `idEvent`='" . $id . "' ORDER BY `name` ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione Ticket</option>';
echo '<option value="c">Cortesía</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
};

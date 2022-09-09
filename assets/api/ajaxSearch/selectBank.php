<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$sql = "SELECT * FROM `bancos` ORDER BY banco ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['banco'] . '">' . $row['banco'] . '</option>';
};


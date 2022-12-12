<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
$sql = "SELECT * FROM `categorias` ORDER BY nombre ASC";
$result = $mysqli->query($sql);
echo '<option value="">Seleccione</option>';
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
};


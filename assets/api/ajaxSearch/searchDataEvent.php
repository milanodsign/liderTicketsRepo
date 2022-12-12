<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');
require('../conex/cors.php');
$id = $_GET['id'];
$sql = "SELECT * FROM `eventos` WHERE `id` = '" . $id . "'";
$result = $mysqli->query($sql);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $sql = "SELECT * FROM `producerData` WHERE `idUser` = '" . $row['idUser'] . "'";
    $result = $mysqli->query($sql);
    while ($rowP = $result->fetch_array(MYSQLI_ASSOC)) {
        $nomProd = $rowP['name'];
        $numDoc = $rowP['numDoc'];
    }
    if (isset($nomProd) && isset($numDoc)) {
        $nomProd = $nomProd;
        $numDoc = $numDoc;
    }
    else {
        $nomProd = "";
        $numDoc = "";
    }
    $response[] = array(
        'nomEvent' => $row['nomEvent'],
        'dir' => $row['dir'],
        'lugar' => $row['lugar'],
        'prod' => $nomProd,
        'numDoc' => $numDoc,
        'idEvent' => $row['id'],
        'fechaEvent' => $row['fechaIni'],
        'horaEvent' => $row['horaIni'],
    );
};

echo json_encode($response);

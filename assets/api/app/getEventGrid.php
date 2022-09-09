<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');

$id = $_GET['id'];
// var_dump($id);exit();
$sql = "SELECT * FROM `eventos` WHERE `idUser`=" . $id . " AND `estado`=1";
$result = $mysqli->query($sql);
// var_dump($result);exit();
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $response[] = array(
        "flyer" => $row['flyer'],
        "id" => $row['id'],
        "nomEvent" => $row['nomEvent'],
    );
}

echo json_encode($response);

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../conex/conexConfig.php');

$mail = $_GET['mail'];
$pass = $_GET['pass'];


$sql = "SELECT *FROM user WHERE mail='" . $mail . "'";
$result = $mysqli->query($sql);
$filas = mysqli_num_rows($result);
if ($filas != 0) {
    $row = mysqli_fetch_array($result);
    if ($row['pass'] != $pass) {
        $message = 0;
    } else {
        if ($row['userType'] == 0) {
            $message = 1;
            $id = $row['id'];
            $name = $row['name'];
            $mail = $row['mail'];
            $phone = $row['phone'];
            $pais = $row['pais'];
            $pass = $row['pass'];
            $userType = $row['userType'];
        } else {
            $message = 2;
        }
    }
} else {
    $message = 4;
}
$response[] = array(
    "message" => $message,
    "id" => $id,
    "name" => $name,
    "mail" => $mail,
    "phone" => $phone,
    "pais" => $pais,
    "pass" => $pass,
    "userType" => $userType,
);
echo json_encode($response);

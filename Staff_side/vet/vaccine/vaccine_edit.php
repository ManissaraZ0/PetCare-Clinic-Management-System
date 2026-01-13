<?php

session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

include '../../../connect.php';

$vaccine_id = $_POST["vaccine_id"];
$vaccine_name = (string) $_POST["vaccine_name"];
$type_id = $_POST["type_id"];
$vaccine_price = (integer) $_POST["vaccine_price"];
$status = (string) $_POST["status"];

$sql = "UPDATE `vaccine` SET `vaccine_name`= '$vaccine_name', `vaccine_price`= '$vaccine_price',`type`= '$type_id',`status`= '$status'
WHERE `vaccine_id`= $vaccine_id";
echo $sql;
$result = $conn->query($sql);
if ($result) {
    header("location: vaccine.php");
}

$conn->close();
?>
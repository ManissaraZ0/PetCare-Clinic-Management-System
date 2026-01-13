<?php
session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

include '../../../connect.php';

$sql = "SELECT * FROM owner";
$result = $conn->query($sql);

$outp = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($outp);

$conn->close();
?>
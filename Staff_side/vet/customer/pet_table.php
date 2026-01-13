<?php
session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

include '../../../connect.php';

$sql = "SELECT p.owner_id, p.pet_id, p.name, type_name FROM pet p INNER JOIN pet_type t
ON p.type = t.type_id";
$result = $conn->query($sql);

$outp = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($outp);

$conn->close();
?>
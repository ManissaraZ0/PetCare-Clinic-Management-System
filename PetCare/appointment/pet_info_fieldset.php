<?php
session_start();

include '../../connect.php';

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../");
} else {
    $ownerId = $_SESSION["owner_id"];
}

if (isset($_GET['petId'])) {
    $petId = $_GET['petId'];

    $sql = "SELECT p.name, p.breed, p.age, p.gender, p.type, type_name FROM pet p INNER JOIN pet_type t
                ON p.type = t.type_id WHERE pet_id='$petId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }
}

$conn->close();
?>
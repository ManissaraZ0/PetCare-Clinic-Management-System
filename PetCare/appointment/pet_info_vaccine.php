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

    $sql = "SELECT v.vaccine_id, v.vaccine_name, v.vaccine_price FROM vaccine v 
                                    INNER JOIN pet_type t ON v.type = t.type_id 
                                    inner join pet p on p.`type` = t.type_id 
                                    WHERE p.pet_id = '" . $petId . "' AND v.`status` = 'available'";

    $result = $conn->query($sql);
    $text = "";
    $outp = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($outp);
}

$conn->close();
?>
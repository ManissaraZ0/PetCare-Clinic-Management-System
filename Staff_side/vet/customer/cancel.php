<?php
    include '../../../connect.php';

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../../");
    }

    $appId = "";
    if (isset($_GET["appId"])) {
        $appId = $_GET["appId"];
    }

    $sql = "SELECT * FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE appointment_id='$appId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $owner_id = $row["owner_id"];
        }
    }

    $status = "cancelled";

    $sql = "UPDATE `appointment` SET `status`= '$status' WHERE appointment_id = '$appId'";
    $result = $conn->query($sql);

    if ($result) {
        header("location: customer_info.php?ownerId=$owner_id");
    }

    $conn->close();
?>
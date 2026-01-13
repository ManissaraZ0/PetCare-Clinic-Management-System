<?php
    include '../../connect.php';

    if (!isset($_SESSION["owner_id"])) {
        header("Location: ../");
    } else {
        $ownerId = $_SESSION["owner_id"];
    }

    $appId = "";
    if (isset($_GET["appId"])) {
        $appId = $_GET["appId"];
    }

    echo "<script>
        console.log('$appId');
    </script>";

    $status = "cancelled";

    $sql = "UPDATE `appointment` SET `status`= '$status' WHERE appointment_id = '$appId'";
    $result = $conn->query($sql);

    if ($result) {
        header("location: ./");
    }

    $conn->close();
?>
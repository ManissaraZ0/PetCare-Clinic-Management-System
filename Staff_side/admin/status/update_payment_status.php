<?php
    session_start();

    include '../../../connect.php';

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../../");
    } else {
        $staffId = $_SESSION["staff_id"];
    }

    $appId = "";
    if (isset($_GET["appId"])) {
        $appId = $_GET["appId"];
    }

    $paymenStatus = "completed";

    date_default_timezone_set("Asia/Bangkok");
    $update_date = date("Y-m-d h:i:s");

    $sql = "UPDATE `appointment` SET `payment_status`= '$paymenStatus', `payment_update_date`= '$update_date', `payment_update_by`= '$staffId' WHERE appointment_id = '$appId'";
    $result = $conn->query($sql);

    if ($result) {
        header("location: status.php");
    }

    $conn->close();
?>
<?php
    session_start();

    include '../../connect.php';

    if (!isset($_SESSION["owner_id"])) {
        header("Location: ../");
    } else {
        $ownerId = $_SESSION["owner_id"];
    }

    if (isset($_GET['status']) || isset($_GET['petId'])) {
        $status = $_GET['status'];
        $petId = $_GET['petId'];

        if ($status == 'all') {
            $condition = "";
        } else {
            $condition = " AND a.status='$status'";
        }

        if ($petId == 'all') {
            $condition2 = "";
        } else {
            $condition2 = " AND a.pet_id='$petId'";
        }
    
        $sql = "SELECT * FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id 
        INNER JOIN appointment_type t ON a.type = t.appointment_type_id
        WHERE p.owner_id='$ownerId' AND a.status!='cancelled'" . $condition . $condition2;
        $result = $conn->query($sql);
    
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);
    }

    $conn->close();
?>
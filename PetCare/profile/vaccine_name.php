<?php
    session_start();

    if (!isset($_SESSION["owner_id"])) {
        header("Location: ../");
    } else {
        $ownerId = $_SESSION["owner_id"];
    }

    include '../../connect.php';

    if (isset($_GET['appId'])) {
        $appId = $_GET['appId'];

        $sqlVaccine = "SELECT * FROM appointment a INNER JOIN vaccine v ON a.vaccine_id = v.vaccine_id
                                    WHERE a.appointment_id='$appId'";

        $resultVaccine = $conn->query($sqlVaccine);

        if ($resultVaccine->num_rows > 0) {
            while ($row = $resultVaccine->fetch_assoc()) {
                echo $row["vaccine_name"];
            }
        }
    }

    $conn->close();
?>
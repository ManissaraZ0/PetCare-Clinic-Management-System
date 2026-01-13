<?php
session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

include '../../../connect.php';

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $sql = "SELECT p.owner_id, fname, time, name, appointment_type_name, a.appointment_id
                FROM appointment a INNER JOIN pet p
                ON a.pet_id = p.pet_id INNER JOIN appointment_type t
                ON a.type = t.appointment_type_id INNER JOIN owner o
                ON p.owner_id = o.owner_id WHERE a.date = '$date' AND a.status = 'in process'";
    $result = $conn->query($sql);

    $outp = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($outp);
}

$conn->close();
?>
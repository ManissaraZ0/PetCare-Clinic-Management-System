<?php
session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

include '../../../connect.php';

if (isset($_GET['vacType'])) {
    $vacType = $_GET['vacType'];

    if ($vacType == 'cat') {
        $condition = " WHERE v.type = '1'";
    } else if ($vacType == 'dog') {
        $condition = " WHERE v.type = '2'";
    } else {
        $condition = "";
    }

    $sql = "SELECT v.vaccine_id, v.vaccine_name, v.vaccine_price, v.status, v.type, type_name FROM vaccine v INNER JOIN pet_type t
    ON v.type = t.type_id" . $condition;
    $result = $conn->query($sql);

    $outp = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($outp);
}

$conn->close();
?>
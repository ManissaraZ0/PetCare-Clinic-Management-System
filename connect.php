<?php
    $servername = "10.1.3.40";
    $username = "66102010151";
    $password = "66102010151";
    $dbname = "66102010151";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // echo '<script>console.log("Database Connected")</script>';
    }
?>
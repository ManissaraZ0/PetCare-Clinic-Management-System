<?php
    session_start();
    
    include '../../../connect.php';

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../../");
    }

    $newsId = $_GET["newsId"];

    $sql = "SELECT status FROM news WHERE news_id=$newsId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status = $row["status"];
        }
    }

    if ($status == 'active') {
        $status = 'inactive';
    } else {
        $status = 'active';
    }

    $sql = "UPDATE `news` SET `status`= '$status' WHERE `news_id`= $newsId";

    $result = $conn->query($sql);
    if ($result) {
        header("location: news.php");
    }

    $conn->close();
?>
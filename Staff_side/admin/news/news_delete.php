<?php
// Start the session
session_start();

include '../../../connect.php';

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

$news_id = $_GET['newsId'];
$sql = "DELETE FROM news WHERE `news_id` = $news_id";
$result = $conn->query($sql);
if ($result) {
    header("location: news.php");
}

$conn->close();
?>
<?php

session_start();

if(!isset($_SESSION["staff_id"])) {
    header("location: ../../");
}

$data = array();

if (isset($_FILES['upload']['name'])) {
    $file_name = $_FILES['upload']['name'];
    $date = new DateTime(); //this returns the current date time
    $result = $date->format('Ymd_His');
    $pathImage = $result . "_" . $file_name;
    $folder = "../../../image-upload/news/" . $pathImage;
    $file_extension = strtolower(pathinfo($folder, PATHINFO_EXTENSION));
    if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png') {
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $folder)) {
            $data['file'] = $pathImage;
            $data['url'] = "../../../image-upload/news/".$pathImage;
            $data['uploaded'] = 1;
        } else {
            $data['uploaded'] = 0;
            $data['error']['message'] = 'Error! File not uploaded';
        }
    } else {
        $data['uploaded'] = 0;
        $data['error']['message'] = 'Invalid Extension';
    }
    echo json_encode($data);
}
?>
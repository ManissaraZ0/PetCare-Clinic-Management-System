<?php
session_start();

include '../../connect.php';

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../");
} else {
    $ownerId = $_SESSION["owner_id"];
}

$sql = "SELECT * FROM pet WHERE owner_id='$ownerId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
        });
        </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Care </title>

    <!-- Icon -->
    <link rel="icon" href="../images/logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../css/font.css" />

    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color: #F9F7F7 !important;
        }

        a.active {
            text-decoration: underline !important;
            text-underline-offset: 8px !important;
        }

        .add-space-nav {
            padding-top: 72px;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px #112D4E;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #3F72AF;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #112D4E;
        }

        .bg-indigo {
            background-color: #112D4E !important;
        }

        button.bg-indigo:hover {
            background-color: #0a1d32 !important;
        }

        .btn-lb {
            background-color: #DBE2EF !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        h1.display-4 {
            font-weight: bold !important;
            text-align: center;
        }

        a.text-white {
            text-decoration: none;
        }

        .validate {
            color: red;
        }

        input.hidden {
            position: absolute;
            left: -9999px;
        }

        #profile-image {
            cursor: pointer;
            width: 200px;
            height: 200px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        window.onload = function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };

        $(function() {
            $('#profile-image').on('click', function() {
                $('#profile-image-upload').click();
            });
        });
    </script>
</head>

<body>
    <?php
    function phpAlert($msg)
    {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    $nameErr = $breedErr = $ageErr = "";
    $name = $type = $breed = $age = $gender = "";
    $checkError = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $type = test_input($_POST["type"]);

        $fullPath = "image-upload/avatar/cat-avatar.png";
        if (!empty($_FILES["uploadfile"]["name"])) {
            $filename = $_FILES["uploadfile"]["name"];
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $date = new DateTime(); //this returns the current date time
            $result = $date->format('Ymd_His');
            $pathImage = $result . "_" . $filename;
            $folder = "../../image-upload/profile/" . $pathImage;
            $fullPath = "image-upload/profile/" . $pathImage;

            $file_extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" ) {
                if($type == 2)
                    $fullPath = "image-upload/avatar/dog-avatar.png";
                else
                    $fullPath = "image-upload/avatar/cat-avatar.png";
                phpAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            } else {
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)) {
                    phpAlert("Image uploaded successfully!");
                } else {
                    phpAlert("Failed to upload image!");
                }

            }
        } else {
            if($type == 2)
                $fullPath = "image-upload/avatar/dog-avatar.png";
        }


        if (empty($_POST["petName"])) {
            $nameErr = "Please enter your pet's name";
            $checkError = false;
        } else {
            $name = test_input($_POST["petName"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $nameErr = "Only letters allowed";
                $checkError = false;
            } else {
                $nameErr = "";
            }
        }

        if (empty($_POST["age"])) {
            $ageErr = "Please enter your pet's age";
            $checkError = false;
        } else {
            $age = (int) test_input($_POST["age"]);
            $ageErr = "";
        }
        $breed = test_input($_POST["breed"]);
        $gender = test_input($_POST["gender"]);
        $ownerId = (int) $_SESSION["owner_id"];

        date_default_timezone_set("Asia/Bangkok");
        $create_date = date("Y-m-d");

        if ($checkError) {
            $sql = "INSERT INTO `pet` (`name`, `type`, `age`, `breed`, `gender`, `path`, `owner_id`, `create_date`) 
            VALUES ('$name', '$type', '$age', '$breed', '$gender', '$fullPath', '$ownerId', '$create_date');";
            $result = $conn->query($sql);

            if ($result) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            header("Location: ./");
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><b> Welcome </b></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" style="text-align: center;">
                    <p> Let's add your first pet. </p>
                </div>

            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="../">
                <img src="../images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="../"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>

    <div class="mt-4 container">
        <h1 class="mb-4 display-4"> Add Pet </h1>
        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-10 col-md-8 col-lg-6 col-xl-6" enctype="multipart/form-data">
                <div class="mb-4 row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div id="profile-image">
                            <img src="../images/avatar.png" class="rounded-circle" />
                        </div>
                    </div>
                </div>
                <div class="mb-4 mt-5 row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input class="form-control" id="profile-image-upload" name="uploadfile" type="file">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="petName" class="form-label">Name</label> <small class="validate"><?php echo $nameErr; ?></small>
                        <input type="text" class="form-control" placeholder="Pet name" name="petName" id="petName" required autofocus value="<?php echo $name;?>">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="1" <?php if (isset($type) && $type == 1) echo "selected"; ?>>Cat</option>
                            <option value="2" <?php if (isset($type) && $type == 2) echo "selected"; ?>>Dog</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="breed" class="form-label">Breed</label>
                        <input type="text" class="form-control" placeholder="Breed" name="breed" id="breed" value="<?php echo $breed;?>">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="age" class="form-label">Age</label> <small class="validate"><?php echo $ageErr; ?></small>
                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="Age" name="age" id="age" min="1" required value="<?php echo $age;?>">
                            <span class="input-group-text"> Year </span>
                        </div>
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="male" <?php if (isset($gender) && $gender == "male") echo "selected"; ?>>Male</option>
                            <option value="female" <?php if (isset($gender) && $gender == "female") echo "selected"; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="mt-5 mb-5 d-grid">
                    <button type="submit" class="btn btn-success bg-indigo">Add pet</button>
                </div>
            </form>

        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
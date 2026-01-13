<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../");
} else {
    $ownerId = $_SESSION["owner_id"];
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#profile-image').on('click', function() {
                $('#profile-image-upload').click();
            });
        });
    </script>
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
            border-color: transparent !important;
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
    </style>
</head>

<body>
    <?php
    function phpAlert($msg)
    {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    include '../../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $type = $_POST["type"];
        $pet_id = $_POST["pet_id"];
        $name_pet = (string) $_POST["name"];
        $breed_pet = (string) $_POST["breed"];
        $age_pet = $_POST["age"];

        $updatePath = "";
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
                phpAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            } else {
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)) {
                    phpAlert("Image uploaded successfully!");
                    $updatePath = ", `path` = '$fullPath'";
                } else {
                    phpAlert("Failed to upload image!");
                }
            }
        } 

        $sql = "UPDATE `pet` SET `name`= '$name_pet', `breed`= '$breed_pet', `age`= '$age_pet' $updatePath WHERE `pet_id`= $pet_id";
        $result = $conn->query($sql);

        if ($result) {
            header("location: ./");
        }
    } else {
        $editId = $_GET["editId"];

        $sql = "SELECT * FROM pet WHERE pet_id='$editId'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $pet_id = $row["pet_id"];
                $type = $row["type"];
                $name_pet = $row["name"];
                $breed_pet = $row["breed"];
                $age_pet = $row["age"];
                $path = $row["path"];
            }
        }
    }
    ?>
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
        <h1 class="mb-4 display-4"> Pet Profile </h1>
        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-10 col-md-8 col-lg-6 col-xl-6" enctype="multipart/form-data">
                <input type="hidden" name="pet_id" id="pet_id" value="<?php echo $pet_id; ?>">
                <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">

                <div class="mb-4 row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div id="profile-image">
                            <img class="mt-3 mb-3 rounded-4" src="../../<?php echo $path; ?>" alt="Card image" width="200px">
                        </div>
                    </div>
                </div>
                <div class="mb-4 mt-5 row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input class="form-control" id="profile-image-upload" name="uploadfile" type="file">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-">
                        <label for="name" class="form-label"> Name </label>
                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="<?php echo $name_pet; ?>" required>
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-">
                        <label for="breed" class="form-label"> Breed </label>
                        <input type="text" class="form-control" placeholder="Breed" name="breed" id="breed" value="<?php echo $breed_pet; ?>">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-">
                        <label for="age" class="form-label"> Age </label>
                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="Age" name="age" id="age" value="<?php echo $age_pet; ?>" min="1" required>
                            <span class="input-group-text"> Year </span>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-5 d-grid">
                    <button type="submit" class="btn btn-success bg-indigo btn-block">Change</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
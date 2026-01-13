<?php
session_start();

include '../../connect.php';

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../");
} else {
    $ownerId = $_SESSION["owner_id"];

    $sql = "SELECT * FROM pet WHERE owner_id='$ownerId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        header("Location: ../../profile/add_pet.php");
    }
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

        .btn-lb {
            background-color: #DBE2EF !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        h1.display-4 {
            font-weight: bold !important;
        }

        a.text-white {
            text-decoration: none;
        }

        .reset {
            all: revert;
        }
    </style>
</head>

<body>
    <script>
        function callPetInfo(petId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    name = myObj["name"];
                    type = myObj["type_name"];
                    type_id = myObj["type"];
                    breed = myObj["breed"];
                    age = myObj["age"];
                    gender = myObj["gender"];

                    let text = "<fieldset class='reset' style='padding: 20px;'>";
                    text += "<legend class='reset'><h4> &nbsp; Pet information &nbsp; </h4></legend>";
                    text += "<label for='name' class='mb-2'>Name:</label>";
                    text += "<input type='text' id='name' name='name' class='form-control' value='" + name + "' readonly>";
                    text += "<label for='type' class='mt-3 mb-2'>Type:</label>";
                    text += "<input type='text' id='type' name='type' class='form-control' value='" + type + "' readonly>";
                    text += "<label for='breed' class='mt-3 mb-2'>Breed:</label>";
                    text += "<input type='text' id='breed' name='breed' class='form-control' value='" + breed + "' readonly>";
                    text += "<label for='age' class='mt-3 mb-2'>Age:</label>";
                    text += "<input type='text' id='age' name='age' class='form-control' value='" + age + "' readonly>";
                    text += "<label for='gender' class='mt-3 mb-2'>Gender:</label>";
                    text += "<input type='text' id='gender' name='gender' class='form-control' value='" + gender + "' readonly>";
                    text += "</fieldset>";
                    document.getElementById('pet-info').innerHTML = text;

                }
            }
            xhr.open("GET", "pet_info_fieldset.php?petId=" + petId, true);
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var petIdSelect = document.getElementById('pet_id');

            petIdSelect.addEventListener("change", function() {
                var petId = petIdSelect.value;
                callPetInfo(petId);
            });
        });
    </script>

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
        <h1 class="mb-4 display-4"> Appointment - Health check </h1>
        <p class="mb-5"> สวัสดี, คุณ <?php echo $_SESSION["fname_owner"] . " " . $_SESSION["lname_owner"]; ?> </p>


        <form method="POST" action="confirm_health.php">
            <div class="row">
                <div class="col- col-xl-9">

                    <div class="row">
                        <div class="col-6">
                            <label for="pet_id" class="mb-2">
                                <h4> Choose pet </h4>
                            </label>
                            <select name="pet_id" id="pet_id" class="mb-4 form-select">
                                <?php
                                $sql = "SELECT * FROM pet WHERE owner_id='$ownerId'";
                                $result = $conn->query($sql);
                                $firstPet = 0;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($firstPet == 0)
                                            $firstPet = $row["pet_id"];
                                        echo "<option value=" . $row["pet_id"] . ">" . $row["name"] . "</option>";
                                    }
                                }
                                if ($firstPet != 0) {
                                    echo "<script>callPetInfo('" . $firstPet . "')</script>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div id="pet-info"></div>

                    <div class="mt-4 row">
                        <div class="col-6">
                            <label for="date" class="mb-2">
                                <h4> Date </h4>
                            </label>
                            <?php
                                date_default_timezone_set("Asia/Bangkok");
                                $tomorrow = date('Y-m-d', strtotime("+1 day"));
                                $twoMonth = date("Y-m-d", strtotime("+2 months"));
                            ?>
                            <input type="date" id="date" name="date" class="form-control" min="<?php echo $tomorrow; ?>" max="<?php echo $twoMonth; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="time" class="mb-2">
                                <h4> Time </h4>
                            </label>
                            <select name="time" id="time" class="form-select" required>
                                <option value="10:00-11:00"> 10:00-11:00 น. </option>
                                <option value="11:00-12:00"> 11:00-12:00 น. </option>
                                <option value="13:00-14:00"> 13:00-14:00 น. </option>
                                <option value="14:00-15:00"> 14:00-15:00 น. </option>
                                <option value="15:00-16:00"> 15:00-16:00 น. </option>
                                <option value="16:00-17:00"> 16:00-17:00 น. </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 row">
                        <div class="col-6">
                            <label for="price" class="mb-2">
                                <h4> Price </h4>
                            </label>
                            <input type="text" id="price" name="price" class="form-control" value="890" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-">
                            <button type="submit" class="mt-5 mb-5 btn btn-success" id="submitbtn" name="submitbtn" style="width: 100%;"> Appoint </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
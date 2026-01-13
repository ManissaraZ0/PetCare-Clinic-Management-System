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

    $petId = $date = $time = $vaccineId = $vaccinePrice ="";
    if (isset($_POST["pet_id"])) {
        $petId = (integer) $_POST["pet_id"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $vaccineId = $_POST["vaccine_id"];
        $vaccinePrice = $_POST["price"];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../css/font.css" />
    
    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color:  #F9F7F7 !important;
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
    <?php
        $sql = "SELECT p.pet_id, p.name, p.breed, p.age, p.gender, p.type, type_name, o.phone FROM pet p INNER JOIN owner o
                ON p.owner_id = o.owner_id INNER JOIN pet_type t ON p.type = t.type_id WHERE pet_id='$petId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pet_id = $row["pet_id"];
                $pet_name = $row["name"];
                $pet_breed = $row["breed"];
                $pet_age = $row["age"];
                $pet_gender = $row["gender"];
                $pet_type = $row["type_name"];
                $phone = $row["phone"];
            }
        }
    
        date_default_timezone_set("Asia/Bangkok");
        $create_date = date("Y-m-d h:i:s");
    
        $status = "in process";

        $app_type = "2";

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $pet_id = $_GET["pet_id"];
            $app_type = $_GET["app_type"];
            $date = $_GET["date"];
            $time = $_GET["time"];
            $create_date = $_GET["create_date"];
            $status = $_GET["status"];
            $price = $_GET["price"];

            $payment_status = 'unpaid';

            $sql = "INSERT INTO `appointment` (`pet_id`, `type`, `date`, `time`, `create_date`, `status`, `update_by`, `vaccine_id`, `price`, `description`, `update_date`, `payment_status`) 
            VALUES ('$pet_id', '$app_type', '$date', '$time', '$create_date', '$status', NULL, NULL, '$price', NULL, NULL, '$payment_status');";
            $result = $conn->query($sql);
    
            if ($result) {
                header("Location: ../");
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
        <h1 class="mb-4 display-4"> Confirm </h1>
        <p class="mb-5"> สวัสดี, คุณ <?php echo $_SESSION["fname_owner"] . " " . $_SESSION["lname_owner"]; ?> </p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
            <input type="hidden" id="pet_id" name="pet_id" value="<?php echo $pet_id; ?>">
            <input type="hidden" id="app_type" name="app_type" value="2">
            <input type="hidden" id="create_date" name="create_date" value="<?php echo $create_date; ?>">
            <input type="hidden" id="vaccine_id" name="vaccine_id" value="<?php echo $vaccineId; ?>">
            <input type="hidden" id="status" name="status" value="<?php echo $status; ?>">

            <div class="row">
                <div class="col- col-xl-9">

                    <fieldset class="reset" style="padding: 20px;">
                        <legend class="reset"><h4> &nbsp; Pet information &nbsp; </h4></legend>
                        <div class="row">
                            <div class="col-2 col-xl-1">
                                <label for="name" class="mt-2 mb-2"> Name </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <input type="text" id="name" name="name" class="form-control" readonly value="<?php echo $pet_name; ?>">
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-2 col-xl-1">
                                <label for="phone" class="mt-2 mb-2"> Phone </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <input type="text" id="phone" name="phone" class="form-control" readonly value="<?php echo $phone; ?>">
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-2 col-xl-1">
                                <label for="type" class="mt-2 mb-2"> Type </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <input type="text" id="type" name="type" class="form-control" readonly value="<?php echo $pet_type; ?>">
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-2 col-xl-1">
                                <label for="breed" class="mt-2 mb-2"> Breed </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <input type="text" id="breed" name="breed" class="form-control" readonly value="<?php echo $pet_breed; ?>">
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-2 col-xl-1">
                                <label for="age" class="mt-2 mb-2"> Age </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <div class="input-group">
                                    <input type="text" id="age" name="age" class="form-control" readonly value="<?php echo $pet_age; ?>">
                                    <span class="input-group-text"> Year </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-2 col-xl-1">
                                <label for="gender" class="mt-2 mb-2"> Gender </label>
                            </div>
                            <div class="col-10 col-xl-6">
                                <input type="text" id="gender" name="gender" class="form-control" readonly value="<?php echo $pet_gender; ?>">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mt-4 reset" style="padding: 20px;">
                        <legend class="reset"><h4> &nbsp; Appointment details &nbsp; </h4></legend>
                        <div class="row">
                            <div class="col-2 col-xl-1">
                                <label for="date" class="mt-2 mb-2"> Date </label>
                            </div>
                            <div class="col-10 col-xl-5">
                                <input type="date" id="date" name="date" class="form-control" readonly value="<?php echo $date; ?>">
                            </div>
                            <div class="col-2 col-xl-1">
                                <label for="time" class="mt-2 mb-2"> Time </label>
                            </div>
                            <div class="col-10 col-xl-5">
                                <input type="text" id="time" name="time" class="form-control" readonly value="<?php echo $time; ?>">
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <p> Type : Health check </p>
                        </div>
                        <div class="row">
                            <div class="col-2 col-xl-1">
                                <label for="price" class="mt-2 mb-2"> Price </label>
                            </div>
                            <div class="col-10 col-xl-5">
                                <input type="text" id="price" name="price" class="form-control" readonly value="890">
                            </div>
                        </div>
                    </fieldset>
        
                    <div class="row">
                        <div class="col-">
                            <button type="submit" class="mt-5 mb-5 btn btn-success" id="submitbtn" name="submitbtn" style="width: 100%;"> Confirm </button>
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